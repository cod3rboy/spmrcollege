<?php
    // Set Page Title
    $page_title = "College Faculty";
    // Include Header Code
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
                    <a class="page-header-link" href="index.php">Home</a> / Faculty
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Page Logo-->
                    <img class="img-responsive page-logo" alt="Faculty icon" src="../images/faculty.png">
                    <hr class="hr-divider">
                    <?php
                        // Generate College Principal section
                        $principal_name = "No Name"; // Set default Name
                        $principal_photo = "../images/nophoto.png"; // Set default photo
                        $clgdb->connect(); // connect to db
                        if($clgdb->isConnected()){ // if connection successful
                            $principal = $clgdb->executeSql("SELECT * FROM tbl_principal;"); // Principal Query
                            while($row = $principal->fetch_assoc()){
                                $principal_name = $row['name']; // Set Principal Name
                                $principal_photo = $row['pic_path']; // Set Principal Photo
                            }
                            // Generate Principal Toggle Section
                            echo "<div role=\"button\" class=\"sm-heading bar-header collapsed-header collapsed\" data-toggle=\"collapse\"  data-target=\"#principalsection\" style=\"margin-bottom:10px;\">College Principal</div>";
                            echo "<div class=\"row collapse\" id=\"principalsection\">
                                        <div class=\"col-md-6\">
                                                <div class=\"person-info-panel\" style=\"background-color: #EEEEEE;\">
                                                    <div class=\"media\">
                                                        <div class=\"media-left\">
                                                            <img src=\"$principal_photo?time=".rand(100,12000)."\" alt=\"Principal Picture\" class=\"media-object profile-pic\">
                                                        </div>
                                                        <div class=\"media-body\">
                                                            <div class=\"media-heading\">
                                                                <strong>$principal_name</strong>
                                                            </div>
                                                            <div class=\"info-panel-text\"><strong>Designation : </strong>Principal</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                   </div> <hr>";

                            // Generate Gazetted Staff Section
                            echo "<div role=\"button\" class=\"sm-heading bar-header collapsed-header collapsed\" data-toggle=\"collapse\"  data-target=\"#gazsection\" style=\"margin-bottom:10px;\">Gazetted Staff</div>";
                            // Get all departments
                            $departments = $clgdb->executeSql("SELECT * FROM tbl_department;");
                            echo "<div class=\"row collapse\" id=\"gazsection\">";
                            if(!$departments->num_rows){ // If there is no department then there is no gazetted staff and display no record found message
                                echo "<div class=\"col-xs-12\">
                                          <div class=\"page-content\">
                                              <div class=\"lg-heading\" style=\"color:#AAAAAA;text-align:center;\">
                                               No Record Found!
                                               </div>
                                            </div>
                                       </div>";
                            }else{ // when there are departments
                                while($dept_row = $departments->fetch_assoc()){ // Generate Staff List Department-Wise
                                    $department_id = $dept_row['id']; // Set department id
                                    $department_name = $dept_row['dept_name']; // Set department name
                                    // Get staff in current department
                                    $gaz_staff = $clgdb->executeSql("SELECT * FROM tbl_gaz_staff WHERE dept_id=$department_id;");
                                    echo "<div class=\"col-xs-12\">";
                                    echo "<div class=\"bar-header \" style=\"background-color:#999999;margin-bottom:8px;\">$department_name</div>";
                                    if($gaz_staff->num_rows){ // When there are some staff in current department
                                        // For each staff in current Department, Generate a Staff Panel containing staff name, photo and designation
                                        while($staff_row = $gaz_staff->fetch_assoc()){
                                            $staff_name = $staff_row["staff_name"];
                                            $staff_designation = $staff_row["designation"];
                                            $staff_photo_path = $staff_row["photo_path"];
                                            echo "<div class=\"col-md-6\">
                                                <div class=\"person-info-panel\" style=\"background-color: #EEEEEE;\">
                                                    <div class=\"media\">
                                                        <div class=\"media-left\">
                                                            <img src=\"$staff_photo_path\" alt=\"$staff_name\" class=\"media-object profile-pic\">
                                                        </div>
                                                        <div class=\"media-body\">
                                                            <div class=\"media-heading\">
                                                                <strong>$staff_name</strong>
                                                            </div>
                                                            <div class=\"info-panel-text\"><strong>Designation : </strong>$staff_designation</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                        }
                                    }else{ // When there are no staff in current department
                                        // Display no staff message
                                        echo "<div style=\"color:#AAAAAA;font-size:16px;text-align:center;\">
                                               No Staff Member!
                                               </div>";
                                    }
                                    echo "</div>";
                                }
                            }
                            echo "</div><hr>";

                            // Generate Non-Gazetted Staff Section
                            echo "<div role=\"button\" class=\"sm-heading bar-header collapsed-header collapsed\" data-toggle=\"collapse\"  data-target=\"#nongazsection\" style=\"margin-bottom:10px;\">Non-Gazetted Staff</div>";
                            $nongaz_staff = $clgdb->executeSql("SELECT * FROM tbl_nongaz_staff;"); // Get all non-gaz staff records
                            echo "<div class=\"row collapse\" id=\"nongazsection\">";
                            if(!$nongaz_staff->num_rows){ // When there is no non-gaz staff
                                // Display no record message
                                echo "<div class=\"col-xs-12\">
                                          <div class=\"page-content\">
                                              <div class=\"lg-heading\" style=\"color:#AAAAAA;text-align:center;\">
                                               No Record Found!
                                               </div>
                                            </div>
                                       </div>";
                            }else{ // Where there are non-gaz staff
                                while($staff_row = $nongaz_staff->fetch_assoc()){
                                    // Generate a Staff Panel for each non-gaz staff that contains staff name, photo and designation
                                    $staff_name = $staff_row['staff_name'];
                                    $staff_designation = $staff_row['designation'];
                                    $staff_photo_path = $staff_row['photo_path'];
                                    echo "<div class=\"col-md-6\">
                                                <div class=\"person-info-panel\" style=\"background-color: #EEEEEE;\">
                                                    <div class=\"media\">
                                                        <div class=\"media-left\">
                                                            <img src=\"$staff_photo_path\" alt=\"$staff_name\" class=\"media-object profile-pic\">
                                                        </div>
                                                        <div class=\"media-body\">
                                                            <div class=\"media-heading\">
                                                                <strong>$staff_name</strong>
                                                            </div>
                                                            <div class=\"info-panel-text\"><strong>Designation : </strong>$staff_designation</div>
                                                        </div>
                                                    </div>
                                                </div>
                                       </div>";
                                }
                            }
                            echo "</div><hr>";

                            // Generate Deputation Staff Section
                            echo "<div role=\"button\" class=\"sm-heading bar-header collapsed-header collapsed\" data-toggle=\"collapse\"  data-target=\"#deputsection\" style=\"margin-bottom:10px;\">Deputation Staff</div>";
                            $deput_staff = $clgdb->executeSql("SELECT * FROM tbl_deput_staff;"); // Get all deputation staff records
                            echo "<div class=\"row collapse\" id=\"deputsection\">";
                            if(!$deput_staff->num_rows){ // When there is no deputation staff
                                // Display no record message
                                echo "<div class=\"col-xs-12\">
                                          <div class=\"page-content\">
                                              <div class=\"lg-heading\" style=\"color:#AAAAAA;text-align:center;\">
                                               No Record Found!
                                               </div>
                                            </div>
                                       </div>";
                            }else{ // When there are deputation staff
                                // Generate a staff panel for each deputation staff that contains staff name, photo and designation
                                while($staff_row = $deput_staff->fetch_assoc()){
                                    $staff_name = $staff_row['staff_name'];
                                    $staff_designation = $staff_row['designation'];
                                    $staff_photo_path = $staff_row['photo_path'];
                                    echo "<div class=\"col-md-6\">
                                                <div class=\"person-info-panel\" style=\"background-color: #EEEEEE;\">
                                                    <div class=\"media\">
                                                        <div class=\"media-left\">
                                                            <img src=\"$staff_photo_path\" alt=\"$staff_name\" class=\"media-object profile-pic\">
                                                        </div>
                                                        <div class=\"media-body\">
                                                            <div class=\"media-heading\">
                                                                <strong>$staff_name</strong>
                                                            </div>
                                                            <div class=\"info-panel-text\"><strong>Designation : </strong>$staff_designation</div>
                                                        </div>
                                                    </div>
                                                </div>
                                       </div>";
                                }
                            }
                            echo "</div><hr>";
                            $clgdb->disconnect(); // Disconnect from db
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
    // Include Footer Code
    require("../templates/common/footer.php");
?>
