<?php
    // Setting Page Title
    $page_title = "College Committee";
    // Import Header Code
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
                    <a class="page-header-link" href="index.php">Home</a> / College Committee
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <?php
                        // Generate section of each Committee and its Members

                        $clgdb->connect(); // connect to db
                        if($clgdb->isConnected()){ // check connection
                            $committees = $clgdb->executeSql("SELECT * FROM tbl_committee;"); // Get all committees from db
                            if(!$committees->num_rows){ // When there is no committee i.e. $committees has 0 rows
                                // Display No Committee Message
                                echo "
                                    <div class=\"lg-heading\" style=\"color:#AAAAAA;text-align:center;height:100px;\">
                                                No Committee Established!
                                     </div>
                                ";
                            }else{ // When there are committees in db
                                while($com_row = $committees->fetch_assoc()){ // Get each committee
                                    $committee_name = $com_row['committee_name']; // store committee name
                                    $committee_id = (int) $com_row['id']; // store committee id
                                    $query_records = "SELECT member, tbl_committee_role.role AS role_name FROM (SELECT member_name AS member, role_id AS role FROM tbl_committee_detail WHERE committee_id = $committee_id) AS committee_table INNER JOIN tbl_committee_role ON committee_table.role = tbl_committee_role.id ;";
                                    // Get Committee Records
                                    $records = $clgdb->executeSql($query_records);
                                    // Display Committee Members table
                                    echo "<div role=\"button\" class=\"sm-heading bar-header collapsed-header collapsed\" data-toggle=\"collapse\"  data-target=\"#content$committee_id\">$committee_name</div>";
                                    echo "<div class=\"collapse\" id=\"content$committee_id\">";
                                    echo "<table class=\"tbl\">";
                                    echo "<tr>
                                    <th class=\"tbl-item\" style=\"text-align:center;\">S.No.</th>
                                    <th class=\"tbl-item\">Name</th>
                                    <th class=\"tbl-item\">Role</th>
                                    </tr> ";
                                    $i = 1;
                                    if($records && $records->num_rows){
                                        while($rec_row = $records->fetch_assoc()){
                                            $member_name = $rec_row['member'];
                                            $member_role = $rec_row['role_name'];
                                            echo "<tr><td class=\"tbl-item\" style=\"text-align:center;\">$i</td>";
                                            echo "<td class=\"tbl-item\">$member_name</td>";
                                            echo "<td class=\"tbl-item\">$member_role</td></tr>";
                                            $i++;
                                        }
                                    }else{
                                        echo"<tr><td style=\"background-color: #EEEEEE;text-align:center;font-size: 16px;padding:5px;\" colspan=\"3\">No Committee Member</td></tr>";
                                    }
                                    echo "</table>";
                                    echo "</div>";
                                    echo "<hr>";
                                }
                            }
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
    // Import Footer Code
    require('../templates/common/footer.php');
?>
