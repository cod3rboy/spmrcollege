<?php
    $page_title = "Admissions";
	require("../templates/common/header.php");

    // Set Scroll Position ID
    if(!isset($_GET['id'])){ // When id variable is not set
        $scroll_id = "pagecontent"; // Set scroll position ID to Page Content Container
    }else{ // When id variable is set
        // Set scroll position to the ID stored in id variable
        $scroll_id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    }
?>
<!--Bootstrap Container-->
   <div class="container">
       <!--Bootstrap Row-->
        <div class="row">
            <!--Bootstrap Column-->
            <div class="col-md-12">
                <!--Page Content Container-->
                <div class="page-container" id="pagecontent">
                    <!--Page Header-->
                    <div class="page-header">
                        <a class="page-header-link" href="index.php">Home</a> / Admissions
                    </div>
                    <!--End Page Header-->
                    <!--Page Body-->
                    <div class="page-body">
                        <!--Admission Page Logo-->
                        <img src="../images/admission.png" class="img-responsive page-logo" alt="Admission Icon">
						<hr class="hr-divider">
                        <!--Admission Rules Section-->
						<div class="bar-header" id="admission_rules">Admission Rules</div>
                        <div class="page-content">
                            <ul>
                                 <li>Admission to Semester I of B.Com/BCA/BBA, under CBCS shall be open to a person having passed the Higher Secondary Part II(10+2 pattern) examination (in full subjects) of the Jammu and Kashmir State Board Of School Education or an examination recognized as equivalent there to subject to availability of seats & if otherwise found eligible.</li>
                                 <li>The Admission of the Girl students in commerce stream will not be allowed in this academic session 2017-18.</li>
                                 <li>Admission is open to state subjects and children of Central Govt. Employees, Army and Para-Military Personnel posted in J&K State.</li>
                                 <li>Students seeking admission under change of stream should have at least an aggregate of 45% marks</li>
                                 <li>A student with a break in academic career will not be considered for admission in the college.However, the Principal may condone one year's gap/break,if rules ,permit, in case of students where he/she feels convinced about the reasons leading to the break/gap in studies.</li>
                                 <li>If a student, after being admitted, remains continuously absent for 14 days,he shall be removed from the college rols and shall not be re-admitted to the same class during the same year. The year so wasted shall not be counted as a year of break and dealt with under appropriate clauses if he presents himself for re-admission during the next year.</li>
                            </ul>
                        </div>
                        <hr class="hr-divider">
                        <!--Documents Required Section-->
						<div class="bar-header" id="docs_req">Documents Required</div>
						<div class="page-content">
                           <ol>
                               <li>Provisional Certificates (in original) issued by the institution last attended(Only for Semester I)</li>
                               <li>Marks Certificates of the class last passed (original only for Semester I) and two attested copies.</li>
                               <li>Character certificate issued by the Head of Institution last attended only for Semester I.</li>
                               <li>In the case of private candidates, character certificate should be signed by a First Class Magistrate/Professor of the College/Panchayat Sarpanch/MLA concerned/SHO.</li>
                               <li>Three similar copies of a recent passport size photograph.</li>
                               <li>Matriculation Certificate (original) and two attested copies(only for semester I).</li>
                               <li>Transfer certificate of father or guardian in case of wards of military/Para Military personnel/Central Govt. Employees.</li>
                               <li>Category certificate from the competent authority(original and two attested copies).</li>
                               <li>Students passing from other then J&K Board Of School Education are required to produce a migration certificate and two attested copies thereof.</li>
                               <li>All the undertakings (regarding one year gap period/ Anti Ragging) are required to be submitted by the selected candidates in the form of an Affidavit on Non-Judicial Stamp of Rs. 20/- duly attested by First Class Magistrate/Notary.</li></ol>
                        </div>
                        <hr class="hr-divider">
                        <!--Fee Structure Section-->
                        <div class="bar-header" id="fee_struct">Fee Structure</div>
                        <?php
                            /* Define Some Constants Here for database query */
                            define("FIRST_YEAR", 1);
                            define("SECOND_YEAR", 2);
                            define("THIRD_YEAR", 3);
                            // Connect to Database
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                // Get the fee structure here
                                $courses = $clgdb->executeSql("SELECT * FROM tbl_courses;");
                                while($course = $courses->fetch_assoc()){
                                    // Store course id
                                    $course_id = $course['id'];
                                    // Store course name
                                    $course_name = $course['course_name'];
                                    echo"<br>"; // New Line
                                    // Course Section Header
                                    echo"<div class=\"bar-header\" style=\"background-color:#999999;font-size:16px;\">$course_name</div>";
                                    $ist_year_fee_query = "SELECT * FROM tbl_feestructure WHERE courseid = $course_id AND courseyear = ".FIRST_YEAR." ;";
                                    $sec_year_fee_query = "SELECT * FROM tbl_feestructure WHERE courseid = $course_id AND courseyear = ".SECOND_YEAR." ;";
                                    $third_year_fee_query = "SELECT * FROM tbl_feestructure WHERE courseid = $course_id AND courseyear = ".THIRD_YEAR." ;";
                                    // Fee List
                                    echo "<ul style=\"margin-top:5px;font-weight:bold;color:#444444;\">";
                                    $ist_year_results = $clgdb->executeSql($ist_year_fee_query);
                                    // Ist Year Fee
                                    while($row = $ist_year_results->fetch_assoc()){
                                        $fee = $row['fee'];
                                        echo "<li>Sem I-II Fee : Rs. $fee</li>";
                                    }
                                    // IInd Year Fee
                                    $sec_year_results = $clgdb->executeSql($sec_year_fee_query);
                                    while($row = $sec_year_results->fetch_assoc()){
                                        $fee = $row['fee'];
                                        echo "<li>Sem III-IV Fee : Rs. $fee</li>";
                                    }
                                    // IIIrd Year Fee
                                    $third_year_results = $clgdb->executeSql($third_year_fee_query);
                                    while($row = $third_year_results->fetch_assoc()){
                                        $fee = $row['fee'];
                                        echo "<li>Sem V-VI Fee : Rs. $fee</li>";
                                    }
                                    echo "</ul>";
                                }
                                // Disconnect from Database
                                $clgdb->disconnect();
                            }
                        ?>
                        <hr class="hr-divider">
                        <!--Intake Capacity Section-->
                        <div class="bar-header" id="intake_cap">Intake Capacity</div>
                            <!--Course / Intake Capacity Table-->
                            <table class="tbl">
                                <tr>
                                    <th class="tbl-item" style="text-align:center;">Course </th>
                                    <th class="tbl-item" style="text-align:center;">Intake Capacity</th>
                                </tr>
                                <tr>
                                    <td class="tbl-item" style="text-align:center;">B.Com.</td>
                                    <td class="tbl-item" style="text-align:center;">1100 Seats</td>
                                </tr>
                                <tr>
                                    <td class="tbl-item" style="text-align:center;">B.B.A</td>
                                    <td class="tbl-item" style="text-align:center;">60 Seats + 6 Payment Seats</td>
                                </tr>
                                <tr>
                                    <td class="tbl-item" style="text-align:center;">B.C.A</td>
                                    <td class="tbl-item" style="text-align:center;">40 Seats</td>
                                </tr>
                                <tr>
                                    <td class="tbl-item" style="text-align:center;">B.Com. (Hons.)</td>
                                    <td class="tbl-item" style="text-align:center;">60 Seats + 6 Payment Seats</td>
                                </tr>
                                <tr>
                                    <td class="tbl-item" style="text-align:center;">PGDBM</td>
                                    <td class="tbl-item" style="text-align:center;">30 Seats</td>
                                </tr>
                                <tr>
                                   <td class="tbl-item" style="text-align:center;">M.Com.</td>
                                   <td class="tbl-item" style="text-align:center;">25 Seats</td>
                                </tr>
                            </table>
                        <!--End Course / Intake Capacity Table-->
                    </div>
                    <!--End Page Body-->
                </div>
                <!--End Page Content Container-->
            </div>
            <!--End Bootstrap Column-->
        </div>
       <!--End Bootstrap Row-->
    </div>
<!--End Bootstrap Container-->
<!--Horizontal Row-->
    <hr>
    <script type="text/javascript">
        //Automatic Scroll to the page content on page load
        $(document).ready(function () {
            // Handler for .ready() called.
            $('html, body').animate({scrollTop: $('#<?php echo $scroll_id;?>').offset().top - 60}, 'slow');
        });
    </script>
	<?php
    // INCLUDE FOOTER CODE
	require("../templates/common/footer.php");
	?>
   
    