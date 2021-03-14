<?php
// Set this variable to page title (No title if not set)
$page_title = "Gallery";
// Load LightBox plugin
$load_light_box = true;
// Max allowed Images to display in homepage image slider
// But only 6 random at a time will display
define("MAX_IMAGES_IN_HOME_SLIDER", 12);
// Include Admin Panel header
require('../templates/admin/header.php');
?>
    <!--<script>
        function validateCaption(e, t){
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode >= 48 && charCode <= 57) || charCode==32 || (charCode==46))
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }
    </script>-->
<!-- Main Content -->
<section class="content">
    <?php
    // Import Utilities File
    require('utilities.php');
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        // When Upload Form is submitted
        if(isset($_POST['upload']) && isset($_FILES['upload_img']) && isset($_POST['caption'])) {
            // Select image name (in the filesystem)
            $image_name = $_FILES['upload_img']['name'];
            // Image name in the server temp directory after file uploaded
            $source_file = $_FILES['upload_img']['tmp_name'];
            // Image description entered by user
            $image_caption = $_POST['caption'];
            // Get the type of the image
            $image_type = strtolower($_FILES['upload_img']['type']);
            /* Image formats to use
                JPG : image/jpg
                JPEG : image/jpeg

                Used Array for easily add another image format in future
            */
            $image_formats = array(
                "image/jpg",
				"image/jpeg"
            );

            $is_everything_ok = true;
            $msg_array = array();

            // File Type Validation
            if (!in_array($image_type, $image_formats)) {
                $is_everything_ok = false;
                array_push($msg_array, "Image is of invalid type!");
            }

            // File size Check
            $image_file_size = $_FILES['upload_img']['size'];
            define('MB', 1048576);
            if($image_file_size > MB){
                $is_everything_ok = false;
                array_push($msg_array, "Image File exceeded maximum size of 1 MB");
            }

            // Image name validation
            // Regex - start with any letter or number or space(file name) then dot(separator) then end with any letter(extension)
            $regex = "/^[0-9a-zA-Z ]+[.][a-zA-Z]+$/";
            if(!preg_match($regex, $image_name)){
                $is_everything_ok = false;
                array_push($msg_array, "Selected image has an invalid name");
            }

            // Image Dimensions and Name check (After all validation successful we can ensure that file is a valid image and now we check its dimensions)
            if($is_everything_ok){
                $image_width = 800;
                $image_height = 600;
                if(getimagesize($source_file)[0] != $image_width || getimagesize($source_file)[1] != $image_height){
                    $is_everything_ok = false;
                    array_push($msg_array, "Image must be of dimensions $image_width (W) x $image_height (H)");
                }
            }

            if (!$is_everything_ok) {
                echo "<div class=\"callout callout-warning\">";
                echo "<ul>";
                foreach ($msg_array as $msg) {
                    echo "<li>$msg</li>";
                }
                echo "</ul>";
                echo "<h5>Note : Read instructions before uploading an image.</h5>";
                echo "</div>";
            } else {
                // Start Uploading file here
                $clgdb->connect();
                if ($clgdb->isConnected()) {
                    // Image Upload Directory
                    $image_upload_dir = "../gallery/";
                    // Thumbnail Upload Directory
                    $image_thumb_dir = "../gallery/thumbs/";
                    // Create Directories if not exist
                    if(!file_exists($image_upload_dir)) mkdir($image_upload_dir, 0777, true);
                    if(!file_exists($image_thumb_dir)) mkdir($image_thumb_dir, 0777, true);
                    $name_array = explode('.', $image_name);
                    $md5_name = md5($name_array[0]) . random_str(4, "123456789abcdefghijklmnopqrstuvwxyz"); // Use 4-char salt to avoid same name conflict
                    $enc_image_name = $md5_name . "." . $name_array[1];
                    $enc_thumb_name = $md5_name . "-thumb." . $name_array[1];
                    $image_path = $image_upload_dir . $enc_image_name;
                    $thumb_path = $image_thumb_dir . $enc_thumb_name;
                    $image_caption = mysqli_real_escape_string($clgdb->conn, $image_caption);
                    $sql_string = "INSERT INTO tbl_gallery(img_path , img_thumb_path , caption , use_in_slider) VALUES(\"$image_path\" , \"$thumb_path\" , \"$image_caption\", 0);";
                    $clgdb->executeSql($sql_string);
                    if(mysqli_affected_rows($clgdb->conn) != -1){ // If database insertion is successful
                        //Move image to upload directory
                        move_uploaded_file($source_file, $image_path);
                        //Create thumbnail of image
                        $source_image = imagecreatefromjpeg($image_path);
                        $src_width = imagesx($source_image);
                        $src_height = imagesy($source_image);
                        $thumb_width = 400;
                        $thumb_height = 300;
                        $thumb_image = imagecreatetruecolor($thumb_width, $thumb_height);
                        imagecopyresampled($thumb_image, $source_image, 0, 0, 0, 0, $thumb_width, $thumb_height,$src_width, $src_height);
                        imagejpeg($thumb_image, $thumb_path);
                        echo "<div class=\"callout callout-success\"><p>Image Uploaded Successfully!</p></div>";
                    }else{
                        echo "<div class=\"callout callout-danger\"><p>Failed to upload Image</p></div>";
                    }
                    $clgdb->disconnect();
                }
            }
        }
    }

    // Delete an Image from Gallery
    if(isset($_GET['delete'])){
        $image_path = "";
        $thumb_path = "";
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id = (int) $_GET['delete'];
            $result = $clgdb->executeSql("SELECT img_path, img_thumb_path FROM tbl_gallery WHERE id=$id ;");
            if($result->num_rows){
                while($row = $result->fetch_assoc()){
                    $image_path = $row['img_path'];
                    $thumb_path = $row['img_thumb_path'];
                }
                $clgdb->executeSql("DELETE FROM tbl_gallery WHERE id=$id ;");
                if(mysqli_affected_rows($clgdb->conn) != 0){
                    if (file_exists($image_path)) unlink($image_path);
                    if (file_exists($thumb_path)) unlink($thumb_path);
                    echo "<div class=\"callout callout-danger\"><p>Picture Deleted!</p></div>";
                }
            }
            $clgdb->disconnect();
        }

    }

    // Use an Image in Homepage Slider
    if(isset($_GET['useslider'])){
        $clgdb->connect();
        if($clgdb->isConnected()){
            $count_slider_pics = $clgdb->executeSql("SELECT * FROM tbl_gallery WHERE use_in_slider = 1;")->num_rows;
            if($count_slider_pics >= MAX_IMAGES_IN_HOME_SLIDER){
                echo "<div class=\"callout callout-info\"><p>Cannot add more pictures to slider.</p><p>Maximum limit reached in the homepage slider.</p></div>";
            }else{
                $id = (int) $_GET['useslider'];
                $clgdb->executeSql("UPDATE tbl_gallery SET use_in_slider = 1 WHERE id=$id ;");
                if(mysqli_affected_rows($clgdb->conn) != 0){
                    echo "<div class=\"callout callout-info\"><p>Picture added to homepage slider.</p></div>";
                }
            }
            $clgdb->disconnect();
        }
    }

    // Remove an Image from Homepage Slider
    if(isset($_GET['removeslider'])){
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id = (int) $_GET['removeslider'];
            $clgdb->executeSql("UPDATE tbl_gallery SET use_in_slider = 0 WHERE id=$id ;");
            if(mysqli_affected_rows($clgdb->conn) != 0){
                echo "<div class=\"callout callout-info\"><p>Picture removed from homepage slider.</p></div>";
            }
            $clgdb->disconnect();
        }
    }

    ?>
    <!--Upload Picture to Gallery Section-->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-title">Upload picture to gallery</div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="gallery.php" enctype="multipart/form-data" autocomplete="off">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="image_upload">Upload Image</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="image_upload" name="upload_img" accept="image/jpeg" tabindex="1" required>
                                <button type="button" class="btn bg-blue btn-xs" data-toggle="modal" data-target="#instructionModal">See Instructions</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="caption_box">Caption</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="caption_box" name="caption" maxlength="60" tabindex="2" placeholder="Enter caption for picture" required>
                                <small>( Add a space if no caption needed )</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" name="upload" class="btn btn-success" tabindex="3">Upload</button>
                            </div>
                        </div>
                    </form>
                    <div id="instructionModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn bg-red btn-sm pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                    <h4>Instructions to upload image</h4>
                                </div>
                                <div class="modal-body">
                                    <h5>Following Instructions must be followed while uploading an image to gallery :-</h5>
                                    <ol>
                                        <li>Only JPEG and JPG image files are allowed.</li>
                                        <li>File name should only contain letters and numbers.</li>
                                        <li>Maximum File size allowed is 1 MB.</li>
                                        <li>Dimensions of the image must be 800(W) x 600(H).</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Upload Picture to Gallery Section-->
    <div class="row">
        <!--Homepage Slider Section-->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-title">
                        Homepage Slider Pictures ( Max : <?php echo MAX_IMAGES_IN_HOME_SLIDER; ?> )
                    </div>
                </div>
                <div class="box-body">
                    <div style="min-height:100px; max-height:435px;overflow:auto;overflow-x:hidden;">
                        <?php
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $query = "SELECT id, img_path, img_thumb_path, caption, UNIX_TIMESTAMP(time_stamp) AS dated FROM tbl_gallery WHERE use_in_slider = 1 ORDER BY time_stamp DESC;";
                                $records = $clgdb->executeSql($query);
                                if($records->num_rows){
                                    while($row = $records->fetch_assoc()){
                                        $id = $row['id']; // image id
                                        $image = $row['img_path']; // image path
                                        $thumbnail =  $row['img_thumb_path']; // thumbnail path
                                        $caption = $row['caption']; // image caption
                                        $time_stamp = $row['dated']; // upload Timestamp
                                        $formatted_date = date("d-M-Y", $time_stamp);
                                        $formatted_time_stamp = "$formatted_date";
                                        //Echo image thumbnail
                                        echo
                                            "<div class=\"col-xs-6 col-lg-4\">
                                            <div class=\"thumbnail thumb-hover\">
                                                <a href=\"" . $image . "\" data-toggle=\"lightbox\" data-title=\"$caption\" data-footer=\"Upload Date : $formatted_time_stamp\" data-gallery=\"college-slider\">
                                                    <img class=\"img-responsive\" src=\"" . $thumbnail . "\" alt=\"$caption\"><br>
                                                </a>
                                            <div style=\"font-size:12px;color:#666666;text-align:center;margin-bottom:5px;\" title=\"Upload Date\" ><i class=\"fa fa-clock-o\"></i> : $formatted_time_stamp</div>
                                            <div style=\"text-align:center\">
                                                <a class=\"btn bg-red btn-xs\" href=\"?removeslider=$id\" title=\"Remove from Slider\"><i class=\"fa fa-minus\"></i></a>
                                            </div>
                                            </div>
                                     </div>";
                                    }
                                }else{
                                    echo "<div style=\"color:#AAAAAA;font-size:14px;\"><i class=\"fa fa-info-circle\"></i> No picture used in slider</div>";
                                }
                                $clgdb->disconnect();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!--End Homepage Slider Section-->
        <!--Uploaded Pictures Section-->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-title">All Uploaded Pictures</div>
                </div>
                <div class="box-body">
                    <?php
                    // Setup Pagination

                    // Tracks current page number initially set to first page
                    $current_page = 1;
                    // Stores no of records to display per page
                    $per_page = 6;
                    // Stores total no of pages required to display all records
                    $total_pages = 1;
                    // Defining Button State Constants
                    define('BUTTON_ON', 1);
                    define('BUTTON_OFF', 2);
                    // Declaring booleans to store the next / prev buttons state
                    // Both initially set to off state
                    $next_btn_state = BUTTON_OFF;
                    $prev_btn_state = BUTTON_OFF;
                    $clgdb->connect();
                    if($clgdb->isConnected()) { // If connected to database
                        // Query String to get total records in the gallery table
                        $total_rec_query = "SELECT * FROM tbl_gallery;";
                        // Execute query and get no of rows
                        $total_rec = $clgdb->executeSql($total_rec_query)->num_rows;
                        if ($total_rec == 0) { //If there is no row i.e. no record found
                            //Display No Records Found
                            $msg_string = "<div style=\"color:#AAAAAA;font-size:14px;\"><i class=\"fa fa-info-circle\"></i> No picture uploaded to gallery</div>";
                            echo $msg_string;
                        } else { //If there are records in the gallery table
                            //Calculate no of pages required to display all records
                            $total_pages = ceil($total_rec / $per_page);
                            if (isset($_GET['page'])) { // If Get variable exists
                                $page_value = (int)$_GET['page']; // Get value from variable
                                if ($page_value > $total_pages || $page_value < 1) { // If value is invalid
                                    $current_page = 1;
                                } else { // if value is valid
                                    $current_page = $page_value;
                                }
                            }
                            // Calculate offset
                            // Offset = previous page * per page limit
                            $offset = ($current_page - 1) * $per_page;
                            // SQL Query to load records from database with limit and offset
                            $query = "SELECT id, img_path, img_thumb_path, caption, UNIX_TIMESTAMP(time_stamp) AS dated, use_in_slider FROM tbl_gallery ORDER BY time_stamp DESC LIMIT $per_page OFFSET $offset;";
                            // Execute Query
                            $results = $clgdb->executeSql($query);
                            while ($row = $results->fetch_assoc()) {
                                $id = $row['id']; // image id
                                $image = $row['img_path']; // image path
                                $thumbnail =  $row['img_thumb_path']; // thumbnail path
                                $caption = $row['caption']; // image caption
                                $time_stamp = $row['dated']; // upload Timestamp
                                $use_in_slider = $row['use_in_slider']; // image used in homepage slider
                                $formatted_date = date("d-M-Y", $time_stamp);
                                $formatted_time_stamp = "$formatted_date";
                                $btn_slider_plus = "<a class=\"btn bg-green btn-xs\" href=\"?useslider=$id\" title=\"Add to slider\"><i class=\"fa fa-plus\"></i></a>";
                                if($use_in_slider){
                                    $btn_slider_plus = "";
                                }
                                //Echo image thumbnail
                                echo
                                    "<div class=\"col-xs-6 col-lg-4\">
                                            <div class=\"thumbnail thumb-hover\">
                                                <a href=\"" . $image . "\" data-toggle=\"lightbox\" data-title=\"$caption\" data-footer=\"Upload Date : $formatted_time_stamp\" data-gallery=\"college-gallery\">
                                                    <img class=\"img-responsive\" src=\"" . $thumbnail . "\" alt=\"$caption\"><br>
                                                </a>
                                            <div style=\"font-size:12px;color:#666666;text-align:center;margin-bottom:5px;\" title=\"Upload Date\" ><i class=\"fa fa-clock-o\"></i> : $formatted_time_stamp</div>
                                            <div style=\"text-align:center\">
                                                $btn_slider_plus
                                                <a class=\"btn bg-red btn-xs\" href=\"?delete=$id\" title=\"Delete\"><i class=\"fa fa-times\"></i></a>
                                            </div>
                                            </div>
                                     </div>";
                            }
                            // Setting Next and Prev Button States
                            $next_btn_state = ($total_pages > 1 && $current_page < $total_pages) ? BUTTON_ON : BUTTON_OFF;
                            $prev_btn_state = ($total_pages > 1 && $current_page > 1) ? BUTTON_ON : BUTTON_OFF;
                            // Set Next and Prev Button Properties based on state
                            $prev_btn_properties = ($prev_btn_state == BUTTON_ON) ? "class=\"btn bg-gray btn-sm\" href=\"?page=".($current_page-1)."\"": "hidden";
                            $next_btn_properties = ($next_btn_state == BUTTON_ON) ? "class=\"btn bg-gray btn-sm\" href=\"?page=".($current_page+1)."\"" : "hidden";
                            echo "</div><div class=\"box-footer\">";
                            echo "<div class=\"pull-right\">";
                            echo "<a $prev_btn_properties><i class=\"fa fa-chevron-left\"></i></a>";
                            echo "<span style=\"margin-left:5px;margin-right:5px;\">Page $current_page - $total_pages</span>";
                            echo "<a $next_btn_properties><i class=\"fa fa-chevron-right\"></i></a>";
                            echo "</div>";
                        }
                        $clgdb->disconnect();
                    }
                    ?>
                </div>
            </div>
        </div>
        <!--End Uploaded Pictures Section-->
    </div>
</section>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>