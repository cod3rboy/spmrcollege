<?php
// Set Page Title
$page_title = "Internal Assessment";
// Import Header Code
require("../templates/common/header.php");
?>
    <hr class="hr-divider">
<!--Bootstrap Container-->
    <div class="container">
        <!--Bootstrap Row-->
        <div class="row">
            <!--Full Size Column-->
            <div class="col-xs-12">
                <!--Page Container-->
                <div class="page-container" id="scroll-content">
                    <!--Page Header-->
                    <div class="page-header">
                        <a class="page-header-link" href="index.php">Home</a> / Internal Assessment
                    </div>
                    <!--End Page Header-->
                    <!--Page Body-->
                    <div class="page-body">
                        <!--Page Logo-->
                        <img src="../images/assessment.png " class="img-responsive page-logo " alt="Internal Assessment Icon ">
                        <hr class="hr-divider ">
                        <!--Internal Assessment Header-->
                        <div class="md-heading bar-header"><i class="fa fa-pencil-square hidden-xs" aria-hidden="true"></i> Internal Assessment</div>
                        <!--Page Content-->
                        <div class="page-content">
                            <!--Assessment Rules Header-->
                            <div class="bar-header">Rules for Internal Assessment</div>
                            <!--List of Rules-->
                            <ol class="o-list">
                                <li> A Student must attend not less than 75% of the total lectures delivered during the academic session to be permitted to take the examination.</li>
                                <li>One Internal home assignment will be given to students and one Internal Assesssment Test will be held in each semester. Penalty of Rs. 50 per subject per Test will be charged from a student who fails to appear in the test the first time.</li>
                                <li> 20% of the marks in each subject are reserved for Internal Assessment .(A student has to pass in the Internal Assessment separately.)</li>
                            </ol>
                            <hr class="hr-divider">
                            <!--Marks Break Up Header-->
                            <div class="bar-header">Break up of the 20% Marks</div>
                            <!--List of Marks Break Up Criteria-->
                            <ol class="o-list">
                                <li>The distribution of marks will be under :
                                    <ul>
                                        <li>10 marks for internal home assessment.</li>
                                        <li>10 Marks for the Assessment Test.</li>
                                    </ul>
                                </li>
                                <li>B.C.A. / B.B.A. / B.Com. Part III Old Course:
                                    <ul>
                                        <li>The Internal Assessment Test will be of 20 marks.</li>
                                        <li>7.5 Marks are for each of the two assessment tests in case of General English and one test of 15 marks for other subjects.</li>
                                        <li>5% for attendance.</li>
                                    </ul>
                                </li>
                                <li>For B.C.A. / B.B.A. Part III here will also be :
                                    <ul>
                                        <li>First Internal Assessment will be based on Presentation.</li>
                                        <li>Second Internal Assignment will be based on written Assessment Test.</li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                        <!--Page Content-->
                    </div>
                    <!--End Page Body-->
                </div>
                <!--End Page Container-->
            </div>
            <!--End Full Size Column-->
        </div>
        <!--End Bootstrap Row-->
    </div>
<!--End Bootstrap Container-->
<?php
// Import Footer Code
require("../templates/common/footer.php");
?>