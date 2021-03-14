<?php
    // Set Page title
    $page_title = "Results";
    // Import header code
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
                <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / Results
                </div>
                <!--End Page Container-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Page Logo-->
                    <img class="img-responsive page-logo" alt="Results Icon" src="../images/result.png">
                    <hr class="hr-divider">
                    <!--Exam Results List Section-->
                    <div class="md-heading bar-header"><i class="fa fa-bell" aria-hidden="true"></i> Exam Results</div>
                    <table class="tbl" style="border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;">
                        <?php
                        // Setup Pagination

                        // Tracks current page number initially set to first page
                        $current_page = 1;
                        // Stores no of records to display per page
                        $per_page = 10;
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
                        if($clgdb->isConnected()){ // If connected to database
                            // Query String to get total records in the results table
                            $total_rec_query = "SELECT * FROM tbl_results;";
                            // Execute query and get no of rows
                            $total_rec = $clgdb->executeSql($total_rec_query)->num_rows;
                            if($total_rec == 0){ //If there is no row i.e. no record found
                                //Display No Records Found
                                echo "<tr><td class=\"tbl-item\"><div class=\"md-heading\" style=\"text-align:center;color:#AAAAAA;\"><i class=\"fa fa-bell-slash\" aria-hidden=\"true\"></i> No result notification</div></td></tr>";
                            }else{//If there are records in the results table
                                //Calculate no of pages required to display all records
                                $total_pages = ceil($total_rec / $per_page);
                                if(isset($_GET['page'])){ // If Get variable exists
                                    $page_value = (int) $_GET['page']; // Get value from variable
                                    if($page_value > $total_pages || $page_value < 1){ // If value is invalid
                                        $current_page = 1;
                                    }else{ // if value is valid
                                        $current_page = $page_value;
                                    }
                                }
                                //  Calculate offset : Offset = previous page * per page limit
                                $offset = ($current_page - 1) * $per_page;
                                $query_records = "SELECT title, link, UNIX_TIMESTAMP(time_stamp) as dated FROM tbl_results ORDER BY time_stamp DESC LIMIT $per_page OFFSET $offset ;";
                                // Execute Query
                                $results = $clgdb->executeSql($query_records);
                                while($record = $results->fetch_assoc()){
                                    $title = $record['title'];
                                    $link = $record['link'];
                                    $time_stamp = $record['dated'];
                                    $formatted_date = "Dated : " . date("d-M-Y", $time_stamp);
                                    // check if the notification is new i.e. is not 10 days old
                                    $time_gap = (60 * 60 * 24 * 10);
                                    $is_new = ((time() - $time_gap) < $time_stamp) ? true : false;
                                    $new_badge = ($is_new) ? "<span class=\"label label-info\">New</span>" : "";
                                    echo    "<tr>
                                                <td class=\"tbl-item\" style=\"text-align:center;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\"><i class=\"fa fa-bell-o\" aria-hidden=\"true\"></i></td>
                                                <td class=\"tbl-item\" style=\"text-align:left;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\">$title $new_badge<div class=\"timestamp\">$formatted_date</div>
                                                    <table><tr><td><a class=\"btn btn-primary btn-xs\" href=\"$link\" target=\"_blank\"><i class=\"fa fa-eye hidden-xs\" aria-hidden=\"true\"></i> View</a></td></tr></table>
                                                </td>
                                            </tr>";
                                }

                                // Setting Next and Prev Button States
                                $next_btn_state = ($total_pages > 1 && $current_page < $total_pages) ? BUTTON_ON : BUTTON_OFF;
                                $prev_btn_state = ($total_pages > 1 && $current_page > 1) ? BUTTON_ON : BUTTON_OFF;
                            }
                            $clgdb->disconnect();
                        }
                        ?>
                    </table>
                    <!--End Exam Results List Section-->
                    <hr>
                    <!--Next / Prev Buttons Section-->
                    <?php
                    // Setting Next and Prev Button Properties based on button states
                    $prev_btn_properties = ($prev_btn_state == BUTTON_ON) ? "class=\"pagination-btn\" href=\"results.php?page=".($current_page-1)."\"": "class=\"pagination-btn-disabled\"";
                    $next_btn_properties = ($next_btn_state == BUTTON_ON) ? "class=\"pagination-btn\" href=\"results.php?page=".($current_page+1)."\"" : "class=\"pagination-btn-disabled\"";
                    echo"<div class=\"row\">
                            <div class=\"col-xs-12 md-heading text-center\">
                                Page $current_page of $total_pages<br><br>
                            </div>
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
                    ?>
                    <!--End Next / Prev Buttons Section-->
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
<?php
    // Import footer code
    require("../templates/common/footer.php");
?>
