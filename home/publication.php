<?php
// Set Page Title
$page_title = "Publication";
// Import Header Code
require("../templates/common/header.php");
// Set Scroll Position ID
if(!isset($_GET['id'])){
    $scroll_id = "pagecontent";
}else{
    $scroll_id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
}
?>
<!--Bootstrap Container-->
<div class="container">
    <!--Bootstrap Row-->
    <div class="row">
        <!--Bootstrap Column-->
        <div class="col-xs-12">
            <!--Page Container-->
            <div class="page-container" id="pagecontent">
                <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / Publication
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Page Logo-->
                    <img class="img-responsive page-logo" alt="Publication Icon" src="../images/publication.png">
                    <hr class="hr-divider">
                    <!--News Letter Section-->
                    <div class="md-heading bar-header" id="newsletter"><i class="fa fa-newspaper-o" aria-hidden="true"></i> News Letter</div>
                    <div style="max-height:300px;overflow:auto;overflow-x:hidden;">
                        <table class="tbl" style="border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;">
                            <?php
                            // Query Newsletters and sort by recently uploaded
                            $query_newsletter = "SELECT title, link, UNIX_TIMESTAMP(time_stamp) As upload_date FROM tbl_newsletter ORDER BY time_stamp DESC;";
                            $clgdb->connect(); // Connect to Database
                            if($clgdb->isConnected()){
                                // Execute Newsletters Query
                                $results = $clgdb->executeSql($query_newsletter);
                                if($results->num_rows == 0){ // When there is no newsletter
                                    echo "<tr><td><div class=\"md-heading page-content\" style=\"text-align:center;color:#AAAAAA;\">No News Letter Available!</div></td></tr>";
                                }else{
                                    // Generate List of Newsletters
                                    while($record = $results->fetch_assoc()){
                                        $title = $record['title']; // Set Title
                                        $time_stamp = $record['upload_date']; // Set Uploaded Date
                                        $link = $record['link']; // Set Download Link
                                        $formatted_date = date("d-M-Y", $time_stamp); // Format Uploaded Date
                                        // check if the newsletter is new i.e. is not 10 days old
                                        $time_gap = (60 * 60 * 24 * 10);
                                        $is_new = ((time() - $time_gap) < $time_stamp) ? true : false;
                                        $new_badge = ($is_new) ? "<span class=\"label label-info\">New</span>" : ""; // Set New Badge if New
                                        // Display News Letter
                                        echo "<tr>";
                                        echo "
                                        <td class=\"tbl-item\" style=\"text-align:center;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\"><i class=\"fa fa-newspaper-o\" aria-hidden=\"true\"></i></td>
                                        <td class=\"tbl-item\" style=\"text-align:left;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\">$title $new_badge<div class=\"timestamp\">Upload Date : $formatted_date</div></td>
                                        <td class=\"tbl-item\" style=\"text-align:right;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\"><a class=\"green-btn\" href=\"$link\">Download</a></td>
                                        ";
                                        echo "</tr>";
                                    }
                                }
                                $clgdb->disconnect(); // Disconnect from database
                            }
                            ?>
                        </table>
                    </div>
                    <!--End News Letter Section-->
                    <hr class="hr-divider">

                    <!--Prospectus Section-->
                    <div class="md-heading bar-header" id="prospectus"><i class="fa fa-list-alt" aria-hidden="true"></i> Prospectus</div>
                    <div style="max-height:300px;overflow:auto;overflow-x:hidden;">
                        <table class="tbl" style="border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;">
                            <?php
                            // Query Prospectus and sort by recently uploaded in descending order
                            $query_prospectus = "SELECT title, link, UNIX_TIMESTAMP(time_stamp) As upload_date FROM tbl_prospectus ORDER BY time_stamp DESC;";
                            $clgdb->connect(); // Connect to Database
                            if($clgdb->isConnected()){
                                // Execute Prospectus Query
                                $results = $clgdb->executeSql($query_prospectus);
                                if($results->num_rows == 0){ // When there is no Prospectus
                                    echo "<tr><td><div class=\"md-heading page-content\" style=\"text-align:center;color:#AAAAAA;\">No Prospectus Available!</div></td></tr>";
                                }else{
                                    // Generate List of Prospectuses
                                    while($record = $results->fetch_assoc()){
                                        $title = $record['title']; // Set Title
                                        $time_stamp = $record['upload_date']; // Set uploaded Timestamp
                                        $formatted_date = date("d-M-Y", $time_stamp); // Format timestamp
                                        $link = $record['link']; // Set Download Link
                                        // check if the prospectus is new i.e. is not 10 days old
                                        $time_gap = (60 * 60 * 24 * 10);
                                        $is_new = ((time() - $time_gap) < $time_stamp) ? true : false;
                                        $new_badge = ($is_new) ? "<span class=\"label label-info\">New</span>" : ""; // Set new badge if prospectus is new
                                        // Display Prospectus
                                        echo "<tr>";
                                        echo "
                                        <td class=\"tbl-item\" style=\"text-align:center;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\"><i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></td>
                                        <td class=\"tbl-item\" style=\"text-align:left;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\">$title $new_badge<div class=\"timestamp\">Upload Date : $formatted_date</div></td>
                                        <td class=\"tbl-item\" style=\"text-align:right;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #FFFFFF;\"><a class=\"green-btn\" href=\"$link\">Download</a></td>
                                        ";
                                        echo "</tr>";
                                    }
                                }
                                $clgdb->disconnect(); // Disconnect from Database
                            }
                            ?>
                        </table>
                    </div>
                    <!--End Prospectus Section-->
                    <hr>
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

<!--Auto Scroll Script-->
<script type="text/javascript">
    //Automatic Scroll to the scroll position id on page load
    $(document).ready(function () {
        // Handler for .ready() called.
        $('html, body').animate({scrollTop: $('#<?php echo $scroll_id;?>').offset().top - 60}, 'slow');
    });
</script>
<?php
// Import Footer Code
require("../templates/common/footer.php");
?>
