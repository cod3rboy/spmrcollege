<?php
    //Setting page title
    $page_title = 'Scholarships';
    //Include Header code
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
                    <a class="page-header-link" href="index.php">Home</a> / <a class="page-header-link" href="facilities.php">Facilities</a> / <a class="page-header-link" href="academicfacilities.php">Academic Facilities</a> / Scholarships                
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                        <!--Page Logo-->
                        <img class="img-responsive page-logo" alt="scholarship icon" src="../images/scholarship.png">
                        <hr class="hr-divider">
                        <!--Top Section0-->
                        <ul>
                            <li>The College provides scholarships to Scheduled Castes, Scheduled Tribes, Low Income groups, Other Social Castes, RBA, Frontier and Handicapped students.</li>
                            <li>National Loan scholarships and National Scholarships are awarded by the government of India.</li>
                            <li>Besides these, merit scholarships are also awarded to the deserving students by Jammu University.</li> 
                            <li>Over and above these scholarships, liberal help is given to the deserving students out of the Mutual Benefit Fund augmented by the State Government grants and UGC Funds.</li> 
                        </ul>
                        <!--End Top Section-->
                        <hr>
                        <!--No of Scholarships Section-->
                        <div class="bar-header">A number of Scholarships and Financial Assistance Schemes, as detailed below, are available with the college for the deserving students:</div>
                        <table class="tbl">
                            <tr>
                                <th class="tbl-item" style="text-align:center;">S.No.</th>
                                <th class="tbl-item">Agency</th>
                                <th class="tbl-item">Scholarship</th>
                            </tr>
                            <tr>
                                <td class="tbl-item" style="text-align:center;">1.</td>
                                <td class="tbl-item">Government of India</td>
                                <td class="tbl-item">National Merit Scholarship</td>
                            </tr>
                            <tr>
                                <td class="tbl-item" style="text-align:center;">2.</td>
                                <td class="tbl-item">State Government</td>
                                <td class="tbl-item">SC/ST, minority and low income scholarship</td>
                            </tr>
                            <tr>
                                <td class="tbl-item" style="text-align:center;">3.</td>
                                <td class="tbl-item">Univeristy of Jammu</td>
                                <td class="tbl-item">Merit Scholarship</td>
                            </tr>
                            <tr>
                                <td class="tbl-item" style="text-align:center;">4.</td>
                                <td class="tbl-item">College</td>
                                <td class="tbl-item">Financial Aid</td>
                            </tr>
                        </table>
                        <!--End No of Scholarships Section-->
                        <hr class="hr-divider">
                        <!--Grant Section-->
                        <div class="page-content-heading bar-header">The grant and continuance of the scholarships is subject to the following conditions:</div>
                        <div class="page-content">
                            <ol class="o-list">
                                <li>Regular attendance.</li>
                                <li>Satisfactory conduct.</li>
                                <li>Production of Income Certificate.</li>
                                <li>Attested copy of the State Subject Certificate.</li>
                            </ol>
                        </div>
                        <!--End Grant Section-->
                        <hr class="hr-divider">
                        <!--Drawn Period Section-->
                        <div class="page-content-heading bar-header">Scholarships shall be drawn only for the following period:</div>
                        <div class="page-content">
                            <ol class="o-list">
                                <li>Academic Session.</li>
                                <li>Sanctioned holidays and Sundays.</li>
                                <li>Permissible Leave.</li>
                                <li>A student applying for scholarships is required to submit an application on a prescribed form which can be had from the College office.</li>
                                <li>The income certificate of the father/ guardian should be issued by the Revenue Officer of the rank not less than the rank of Tehsildar. Parent/Guardian of the student applying for any scholarship must give an undertaking that in case his/her ward participates in strikes or any other subversive activity he/she will refund the amount of the scholarship received in one installment.</li>
                            </ol>
                        </div>
                        <!--End Drawn Period Section-->
                        <hr class="hr-divider">
                        <!--Scholarships issued Section-->
                        <div class="page-content-heading bar-header">Scholarships issued during session 2015-16:</div>
                        <table class="tbl">
                            <tr>
                                <th class="tbl-item">Category</th>
                                <th class="tbl-item">Male</th>
                                <th class="tbl-item">Female</th>
                                <th class="tbl-item">Total</th>
                            </tr>
                            <tr>
                                <td class="tbl-item">Other Backward Classes (OBC)</td>
                                <td class="tbl-item">17</td>
                                <td class="tbl-item">05</td>
                                <td class="tbl-item">22</td>
                            </tr>
                            <tr>
                                <td class="tbl-item">Pahari Speaking</td>
                                <td class="tbl-item">08</td>
                                <td class="tbl-item">0</td>
                                <td class="tbl-item">8</td>
                            </tr>
                            <tr>
                                <td class="tbl-item">Schedule Caste (SC)</td>
                                <td class="tbl-item">78</td>
                                <td class="tbl-item">19</td>
                                <td class="tbl-item">97</td>
                            </tr>
                            <tr>
                                <td class="tbl-item">Merit Central Scheme</td>
                                <td class="tbl-item">09</td>
                                <td class="tbl-item">01</td>
                                <td class="tbl-item">10</td>
                            </tr>
                        </table>
                        <!--End Scholarships issued Section-->
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