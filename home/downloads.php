<?php
//Set page header
$page_title = "Downloads";
//Include Header Code
require("../templates/common/header.php");
?>
<!--Bootstrap Container-->
    <div class="container">
        <!--Bootstrap Row-->
        <div class="row">
            <!--Bootstrap Column-->
            <div class="col-xs-12">
                <!--Page Container-->
                <div class="page-container" id="scroll-content">
                    <!-- Page Header-->
                    <div class="page-header">
                        <a class="page-header-link" href="index.php">Home</a> /
                        Downloads
                    </div>
                    <!--End Page Header-->
                    <!--Page Body-->
                    <div class="page-body">
                        <!--Page Logo-->
                        <img src="../images/download.png" class="img-responsive page-logo" alt="Download Icon">
                        <hr class="hr-divider">
                        <div class="lg-heading"><i class="fa fa-download hidden-xs"  aria-hidden="true"></i> Downloads </div>
                            <?php
                            // Generate Download Items Section

                            /* Declaring Pagination variables here */
                            //Stores current page number initially set to first page
                            $current_page = 1;
                            //Stores the per page records limit
                            $per_page = 6;
                            //Stores total no of pages required to display all records
                            $total_pages = 1;
                            //Defining Constants representing Button On and off states
                            define("BUTTON_ON", 1);
                            define("BUTTON_OFF", 0);
                            // Variables to set state of next / prev buttons
                            // Initially both buttons are off and are set when
                            // there is some record in the download table
                            $next_btn_state = BUTTON_OFF;
                            $prev_btn_state = BUTTON_OFF;
                            // connecting to database
                            $clgdb->connect();
                            if($clgdb->isConnected()){ // if connection is successful
                                //Get Total no of download records in download table
                                $total_rec = $clgdb->executeSql("SELECT * FROM tbl_download;")->num_rows;
                                //echo "<h1>Total Records : $total_rec</h1>";
                                if($total_rec == 0) { // if no record found in download table
                                    // Display no record found
                                    $msg_string = "<div class=\"page-content\"><div class=\"lg-heading\" style=\"text-align:center;color:#AAAAAA;\">No files available to download!</div></div>";
                                    echo $msg_string;
                                }else {
                                    // Display records and do pagination
                                    //Get total pages
                                    $total_pages = ceil($total_rec / $per_page);
                                    if (isset($_GET['page'])) { //If Get variable exists
                                        $page_value = (int)$_GET['page'];
                                        if ($page_value > $total_pages || $page_value < 1 || (gettype($page_value) == "string")) {
                                            $current_page = 1; // if invaild value is found then set to first page
                                        } else {
                                            $current_page = $page_value; // set to the specified page
                                        }
                                    }
                                    //Calculate offset ( Previous Page * Per Page Limit)
                                    $offset = $per_page * ($current_page - 1);
                                    //Create SQL Query Command
                                    //SQL Date Format to use while querying timestamp
                                    $date_format = '%d-%b-%Y at %h:%i %p'; // Example : Uploaded on 01-Jan-2013 at 02:09 PM
                                    $query_records = "SELECT id, filename, filedesc, link, DATE_FORMAT(time_stamp, '$date_format') As dated FROM tbl_download ORDER BY time_stamp DESC LIMIT $per_page OFFSET $offset ;";
                                    $results = $clgdb->executeSql($query_records); //Querying Database
                                    echo "<table class=\"tbl\" style=\"border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\">";
                                    // Generate table row for each record
                                    while ($row = $results->fetch_assoc()) {
                                        $file_name = $row['filedesc'];
                                        $file_link = $row['link'];
                                        $file_time_stamp = $row["dated"];
                                        //Create a table entry
                                        echo "
                                            <tr>
                                            <!--Download Icon-->
                                            <td class=\"tbl-item\" style=\"text-align:center;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\"><i class=\"fa fa-arrow-down\" aria-hidden=\"true\"></i></td>
                                            <!--File Title-->
                                            <td class=\"tbl-item\" style=\"text-align:left;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\">$file_name
                                            <table>
                                                <!--Timestamp-->
                                                <tr><td><div class=\"timestamp\"><i class=\"fa fa-clock-o\"></i> $file_time_stamp</div></td></tr>
                                                <!--Download Button-->
                                                <tr><td><a role=\"button\" class=\"btn btn-primary btn-xs\" target=\"_blank\" href=\"$file_link\">Download</a></td></tr>
                                            </table>
                                            </td>
                                            </tr>";
                                    }
                                    echo "</table>";
                                    //Setting state of next/prev buttons
                                    $next_btn_state = ($current_page >= 1 && $current_page < $total_pages) ? BUTTON_ON: BUTTON_OFF ;
                                    $prev_btn_state = ($current_page > 1 && $current_page <= $total_pages) ? BUTTON_ON: BUTTON_OFF ;

                                    //Set Next / Prev Buttons properties based on Button State
                                    $prev_btn_properties = ($prev_btn_state == BUTTON_ON) ? "class=\"pagination-btn\" href=\"downloads.php?page=".($current_page-1)."\"": "class=\"pagination-btn-disabled\"";
                                    $next_btn_properties = ($next_btn_state == BUTTON_ON) ? "class=\"pagination-btn\" href=\"downloads.php?page=".($current_page+1)."\"" : "class=\"pagination-btn-disabled\"";
                                    //echo "Prev Button Properties : $prev_btn_properties";
                                    //echo "Next Button Properties : $next_btn_properties";
                                    echo "<hr class=\"hr-divider\">";
                                    echo"<div class=\"row\">
                                            <div class=\"col-xs-12 md-heading text-center\">Page $current_page of $total_pages<br><br></div>
                                         </div>
                                         <div class=\"row\">
                                            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 col-sm-offset-2 col-md-offset-3 col-lg-offset-4\">
                                                <a $prev_btn_properties>
                                                    <i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i> Prev
                                                </a>
                                                
                                            </div>
                                            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2\">
                                                <a $next_btn_properties>
                                                    Next <i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i>
                                                </a>
                                            </div>
                                         </div>";
                                }
                                    //Disconnect from the database
                                    $clgdb->disconnect();
                                }
                            ?>
                    </div>
                    <!--End Page Body-->
                </div>
                <!--End Page Container-->
            </div>
            <!-- End Bootstrap Column -->
        </div>
        <!--End Bootstrap Row-->
    </div>
<!--End Bootstrap Container-->
<?php
//Include Footer Code
require("../templates/common/footer.php");
?>