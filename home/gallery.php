<?php
    //Setting Page title
    $page_title = "Photo Gallery";
    //Include Header Code
    require('../templates/common/header.php');
?>
    <!--Bootstrap Container-->
    <div class="container"
         <!--Bootstrap Row-->
        <div class="row">
            <!--Bootstrap Column-->
            <div class="col-xs-12">
                <!--Page Container-->
                <div class="page-container" id="scroll-content">
                    <!--Page Header-->
                    <div class="page-header">
                        <a class="page-header-link" href="index.php">Home</a> / Photo Gallery
                    </div>
                    <!--End Page Header-->
                    <!--Page Body-->
                    <div class="page-body">
                        <!--Page Logo-->
                        <img class="img-responsive page-logo" alt="Gallery Icon" src="../images/gallery.png">
                        <hr class="hr-divider">
                        <!--Page Heading-->
                        <div class="xl-heading"><span class="glyphicon glyphicon-picture hidden-xs"></span> Gallery</div>
                        <hr>
                        <!--Gallery Section-->
                        <div class="page-content">
                            <div class="row">
                                <?php
                                //Constants to represent on off state of buttons
                                define("BUTTON_ON", 1);
                                define("BUTTON_OFF", 0);
                                //Variables to handle on/off of prev / next buttons
                                //Initially Both Buttons are off and are set when there
                                // is some record in the gallery table
                                $prev_btn_state = BUTTON_OFF;
                                $next_btn_state = BUTTON_OFF;
                                // Use to track current page number
                                //Initially Set to first page
                                $current_page = 1;
                                // Connect to Database
                                $clgdb->connect();
                                if($clgdb->isConnected()){ //If connection is successful
                                    //Query total no of Gallery records;
                                    $total_rec = $clgdb->executeSql('SELECT * FROM tbl_gallery ;')->num_rows;
                                    if($total_rec == 0){ // When there are no records
                                        // Display No Record Message
                                        echo "<div class=\"col-xs-12\">
                                            <div class=\"lg-heading\" style=\"color:#AAAAAA;text-align:center;\">
                                                No picture found in gallery!
                                            </div>
                                        </div>";
                                    }else{ // When there are some images

                                        // Setup Pagination

                                        $per_page = 8; // No of images per page
                                        $total_pages = ceil($total_rec / $per_page); // Calculate total pages required to display all images
                                        $offset; // Use to determine offset of the records in the query
                                        if(isset($_GET['page'])){ // when gallery loads with get variable
                                            $page_value = (int) $_GET['page']; // get value from get variable page
                                            if(/*(gettype($page_value) == "string") || */$page_value > $total_pages || $page_value < 1){
                                                // If get variable contains invalid value
                                                // Handle it here
                                                $current_page = 1; // set current page to 1
                                            }else{
                                                $current_page = $page_value;
                                            }
                                        }
                                        // Calculate offset ( previous page * per_page)
                                        $offset = ($current_page - 1) * $per_page;
                                        // Create MySQL query string
                                        $sqlstring = "SELECT img_path, img_thumb_path, caption, UNIX_TIMESTAMP(time_stamp) As dated FROM tbl_gallery ORDER BY time_stamp DESC LIMIT $per_page OFFSET $offset;";
                                        // Execute Sql statement
                                        $results = $clgdb->executeSql($sqlstring);
                                        //Loop through each record in query
                                        while($row = $results->fetch_assoc()){
                                            $image_path = $row['img_path']; // Store image path
                                            $image_thumb_path = $row['img_thumb_path']; // Store image thumbnail path
                                            $timestamp = date('d-M-Y', $row['dated']); // Store timestamp
                                            $caption = $row['caption']; // Store Image Caption
                                            //Echo Image thumbnail
                                            echo
                                                "<div class=\"col-lg-3 col-md-4 col-xs-6 thumb\">
                                            <div class=\"thumbnail\">
                                                <a href=\"" . $image_path . "\" data-toggle=\"lightbox\" data-title=\"$caption\" data-footer=\"Date Uploaded : $timestamp\" data-gallery=\"college-gallery\">
                                                    <img class=\"img-responsive\" src=\"" . $image_thumb_path . "\" alt=\"$caption\"><br>
                                                </a> 
                                                <div class=\"timestamp\" style=\"text-align:center;\"><i class=\"fa fa-clock-o\"></i> : $timestamp</div>
                                            </div>
                                        </div>";
                                        }
                                        //Set Next previous buttons state
                                        $next_btn_state = ($current_page >=1 and $current_page < $total_pages) ? BUTTON_ON : BUTTON_OFF;
                                        $prev_btn_state = ($current_page > 1 and $current_page <= $total_pages) ? BUTTON_ON : BUTTON_OFF ;
                                    }
                                    //Disconnect from database
                                    $clgdb->disconnect();
                                }
                                ?>
                            </div>
                        </div>
                        <!--End Gallery Section-->
                        <hr class="hr-divider">
                        <!--Next / Prev Buttons section-->
                        <div class="row">
                            <div class="col-xs-6">
                                <a <?php if($prev_btn_state == BUTTON_ON){
                                    // Enable previous button only when there are more than 1 page and user is not  on first page
                                    echo "class=\"pagination-btn\"href=\"gallery.php?page=".($current_page-1)."\"";
                                }else {
                                    echo "class=\"pagination-btn-disabled\" ";
                                }
                                ?>>
                                    <span class="glyphicon glyphicon-chevron-left"></span> prev
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a <?php
                                if($next_btn_state == BUTTON_ON){
                                    // Enable Next button only when there are more than 1 page and user has not reached last page
                                    echo "class=\"pagination-btn\" href=\"gallery.php?page=".($current_page+1)."\"";
                                }else {
                                    echo "class=\"pagination-btn-disabled\"";
                                }
                                ?> >
                                    next <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                        <!--End Next / Prev Buttons section-->
                    </div>
                    <!--End Page Body-->
                </div>
                <!--End Page Container-->
            </div>
            <!--End Bootstrap Column-->
        </div>
        <!--End Bootstrap Row-->
    </div>
    <!--End Bootstrap Container-->

<!--Lightbox start script -->
<script>
    // Light Box load script
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
<?php
    //Include Footer Code
    require('../templates/common/footer.php');
?>