<?php
// Set Page Title
$page_title = "Former Principals";
// Include Header Code
require('../templates/common/header.php');
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
                    <a class="page-header-link" href="index.php">Home</a> / Former Principals
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Generate College Former Principals Table-->
                    <div class="bar-header">College Former Principals</div>
                    <table class="tbl">
                        <tr>
                            <th class="tbl-item" style="text-align:center;">S.No.</th>
                            <th class="tbl-item" style="text-align:center;">Name</th>
                            <th class="tbl-item">Service Start</th>
                            <th class="tbl-item">Service End</th>
                        </tr>
                        <?php
                            // Connect to db
                            $clgdb->connect();
                            if($clgdb->isConnected()){ // If connection is successful
                                $query_records = "SELECT * FROM tbl_former_principals ORDER BY service_end DESC;";
                                // Get all former Principal records
                                $results = $clgdb->executeSql($query_records);
                                if(!$results->num_rows){ // When there is no former principal
                                    // Display no record message
                                    echo "
                                        <tr>
                                            <td class=\"tbl-item\" colspan=\"4\">
                                                <div class=\"lg-heading\" style=\"color:#AAAAAA;text-align:center;\">No Record Found</div>
                                            </td>
                                        </tr>
                                    ";
                                }else{ // When there are former principal records
                                    // Generate Table record for each former principal
                                    $i = 1;
                                    while($row = $results->fetch_assoc()){
                                        $name = $row['name'];
                                        $start = $row['service_start'];
                                        $end = $row['service_end'];
                                        echo"
                                        <tr>
                                            <td class=\"tbl-item\" style=\"text-align:center;\">$i</td>
                                            <td class=\"tbl-item\" style=\"text-align:center;\">$name</td>
                                            <td class=\"tbl-item\">$start</td>
                                            <td class=\"tbl-item\">$end</td>
                                        </tr> 
                                    ";
                                        $i++;
                                    }
                                }
                                $clgdb->disconnect(); // disconnect from db
                            }
                        ?>
                    </table>
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
// Include Footer Code
require('../templates/common/footer.php');
?>
