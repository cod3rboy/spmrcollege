<?php
    //Set page title
    $page_title = "Notifications";
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
                <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> /
                    Notifications
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Page Logo-->
                    <img src="../images/bullhorn.png" class="img-responsive page-logo" alt="Notification Icon">
                    <hr class="hr-divider">
                    <!--Notification List Section-->
                    <div class="lg-heading"><i class="fa fa-bullhorn hidden-xs"  aria-hidden="true"></i> Notifications</div>
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
                                // Query String to get total records in the notification table
                                $total_rec_query = "SELECT * FROM tbl_notification;";
                                // Execute query and get no of rows
                                $total_rec = $clgdb->executeSql($total_rec_query)->num_rows;
                                if($total_rec == 0){ //If there is no row i.e. no record found
                                    //Display No Records Found
                                    $msg_string = "<div class=\"page-content\"><div class=\"lg-heading\" style=\"text-align:center;color:#AAAAAA;\">No notification issued yet!</div></div>";
                                    echo $msg_string;
                                }else{ //If there are records in the notification table
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
                                    // Calculate offset
                                    // Offset = previous page * per page limit
                                    $offset = ($current_page - 1) * $per_page;
                                    // SQL Query to load notifications from database with limit and offset
                                    $query = "SELECT id, title, description, UNIX_TIMESTAMP(time_stamp) AS dated FROM tbl_notification ORDER BY time_stamp DESC LIMIT $per_page OFFSET $offset;";
                                    // Execute Query
                                    $results = $clgdb->executeSql($query);
                                    echo "<table class=\"tbl\" style=\"border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\">";
                                    while($tupple = $results->fetch_assoc()){
                                        $id = $tupple['id']; // Notification Id
                                        $title = $tupple['title']; // Notification Title
                                        $desc  = $tupple['description']; // Notification Description
                                        $time_stamp = $tupple['dated']; // Notification Timestamp
                                        $formatted_date = date("d-M-Y",$time_stamp);
                                        $formatted_time = date("h:i A",$time_stamp);
                                        $formatted_time_stamp = "Issued Date : $formatted_date at $formatted_time";
                                        // check if the notification is new i.e. is not 10 days old
                                        $time_gap = (60 * 60 * 24 * 10);
                                        $is_new = ((time() - $time_gap) < $time_stamp) ? true : false;
                                        $new_badge = ($is_new) ? "<span class=\"label label-info\">New</span>" : "";
                                        echo "
                                        <tr>
                                            <td class=\"tbl-item\" style=\"text-align:center;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\">
                                                <span class=\"glyphicon glyphicon-bullhorn\"></span>
                                            </td>
                                            <td class=\"tbl-item\" style=\"text-align:left;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\">
                                                $title $new_badge
                                                <table>
                                                    <tr>
                                                        <td><div class=\"timestamp\">$formatted_time_stamp</div>
                                                            <table><tr><td><a class=\"btn btn-success btn-xs\" href=\"#\" data-toggle=\"modal\" data-target=\"#notificationModal$id\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i> View</a></td></tr></table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <div role=\"dialog\" class=\"modal fade\" id=\"notificationModal$id\">
                                            <div class=\"modal-dialog\">
                                                    <div class=\"modal-content\">
                                                    <div class=\"modal-header\">
                                                        <button class=\"close\" data-dismiss=\"modal\">Close <i class=\"fa fa-close\" aria-hidden=\"true\"></i></button>
                                                        <div class=\"modal-title\"><strong>$title</strong></div>
                                                    </div>
                                                    <div class=\"modal-body\">$desc</div>
                                                    <div class=\"modal-footer timestamp\">$formatted_time_stamp</div>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                    }
                                    echo "</table>";
                                    // Setting Next and Prev Button States
                                    $next_btn_state = ($total_pages > 1 && $current_page < $total_pages) ? BUTTON_ON : BUTTON_OFF;
                                    $prev_btn_state = ($total_pages > 1 && $current_page > 1) ? BUTTON_ON : BUTTON_OFF;
                                    // Setting Next and Prev Button Properties based on button states
                                    $prev_btn_properties = ($prev_btn_state == BUTTON_ON) ? "class=\"pagination-btn\" href=\"notifications.php?page=".($current_page-1)."\"": "class=\"pagination-btn-disabled\"";
                                    $next_btn_properties = ($next_btn_state == BUTTON_ON) ? "class=\"pagination-btn\" href=\"notifications.php?page=".($current_page+1)."\"" : "class=\"pagination-btn-disabled\"";
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
                                // Disconnect from database
                                $clgdb->disconnect();
                            }
                        ?>
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
    //Include Footer Code
    require("../templates/common/footer.php");
?>
