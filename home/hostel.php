<?php
    //Setting page title
    $page_title="Hostel";
    //Include Header Code
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
                    <a class="page-header-link" href="index.php">Home</a> / 
                    <a class="page-header-link" href="facilities.php">Facilities</a> / 
                    <a class="page-header-link" href="infrastructure.php">Infrastructure</a> / 
                    Hostel
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Page Logo-->
                    <img class="img-responsive page-logo" alt="Hostel Icon" src="../images/building.png">
                    <hr class="hr-divider">
                    <!--Top Section-->
                    <ul>
                        <li>Looking into the needs of students coming from far off regions of the state to study in our college, we have built a new college hostel with a capacity to accommodate 125 students.</li>
                        <li>Efforts have been made to give all kinds of comfort to the hostellers so that they do not have to worry about day to day needs at the cost of their studies.</li>
                    </ul>
                    <!--End Top Section-->
                    <hr>
                    <!--Hostel Rules Header-->
                    <div class="bar-header">
                        Following procedure, rules and regulations have to be kept in mind by the students while applying for the hostel:
                    </div>
                    <!--Page Content-->
                    <div class="page-content">
                        <!--Hostel Rules List-->
                        <ol class="o-list">
                            <li>Admission to the hostel is preferably given to students coming from far flung and backward areas, those belonging to SC/ST categories and backward classes, on the basis of merit.</li>
                            <li>A hostel admission committee makes selection of the candidates, which includes a personal interview. Students desirous of seeking admission to the hostel must apply on the proper application form provided in the prospectus (Annexure VI).</li>
                            <li>Selected candidates shall have to pay the hostel dues in full before they report to the warden for allotment of rooms.</li>
                            <li>No hosteller shall be allowed to remain in the hostel if his monthly dues are not paid within fifteen days from the scheduled date unless specially authorized by the Principal.</li>
                            <li>Resident students will be required to sign a receipt for items of furniture etc issued to them. They will be responsible for any loss/damage to the hostel property. At the end of the term every student shall hand over the items issued to him.</li>
                            <li>The common room secretary will be in-charge of the various facilities available in the common room. No one is allowed to remove any article from the common room, without the permission of the hostel warden.</li>
                            <li>Meals are served in the dining hall only. A concession can, however, be made in the case of a boarder, who is sick/physically challenged.</li>
                            <li>The hostel mess is run by a contractor and managed by the mess committee comprising of students. Mess charges must be cleared by the 10th of each month, failing which the hosteller will have to pay a fine of rupees two per day up to 15th of the month. After that, the hosteller will not be served any meals unless allowed by the warden.</li>
                            <li>The hostel gate is opened at 5 a.m. in summer and at 6 a.m. in winter and is closed at 10 p.m. in summer and 9 p.m. in winter. Gate shall not be opened during the night except in case of an emergency. No boarder shall be allowed to move out after the attendance is taken at night.</li>
                            <li>Application for leave shall be submitted to the warden in person. Boarders who are absent without prior permission are liable to be expelled from the hostel. Any boarder staying away for the whole night without permission shall be fined rupees fifty (50) for the first offence.</li>
                            <li>No guest/relative is allowed to reside in the hostel premises. Visitors are not allowed to enter the hostel rooms. They are allowed only in the visitor’s lounge.</li>
                            <li>The hostellers are responsible for the safety of their own belongings. During vacation and when on long leave they shall remove all personal property from the premises of the hostel. The hostel authorities shall not be responsible for loss or theft of any cash or valuables kept in the rooms of the boarders.</li>
                            <li>Religious meeting/gatherings/functions are not allowed inside the hostel premises.</li>
                            <li>Amusement of any kind, which is likely to disturb others, is not allowed.</li>
                            <li><b>Ragging in the hostel is strictly prohibited. Any student of the hostel indulging in ragging is liable to be expelled from the hostel and even from the college.</b></li>
                            <li>If a hosteller is asked to vacate the hostel room on disciplinary or administrative grounds, he shall have to do so immediately; failing which the warden shall break open the lock of the room and remove the belongings.</li>
                            <li>Hostel security shall be released only after all due payments have been made by a boarder. The claim for all such refunds should be made within one year from the date of leaving the hostel.</li>
                            <li>The college authorities reserve the right to alter, amend or modify any of the existing rules without prior notice. Decision of the Principal in all matters shall be final and binding.</li>
                        </ol>
                        <!--End Hostel Rules List-->
                    </div>
                    <!--End Page Content-->
                    <hr class="hr-divider">
                    <!--Available Hostels Table-->
                    <div class="bar-header">Available Hostels</div>
                    <table class="tbl">
                        <tr>
                            <th class="tbl-item" style="text-align:center;">S.No.</th>
                            <th class="tbl-item">Hostel</th>
                            <th class="tbl-item">Intake Capacity</th>
                        </tr>
                        <tr>
                            <td class="tbl-item" style="text-align:center;">1.</td>
                            <td class="tbl-item">For Boys Only</td>
                            <td class="tbl-item">125</td>
                        </tr>
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
    //Include footer Code
    require('../templates/common/footer.php');
?>