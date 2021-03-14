<?php
    //Setting page title
    $page_title="College Profile";
    //Include Header Code
    require('../templates/common/header.php');
?>

<!--Bootstrap Container-->
<div class="container">
	<!--Bootstrap Row-->
	<div class="row">
		<div class="col-xs-12">
			<!--Page Content Container-->
			<div class="page-container" id="scroll-content">
				<!--Page Header-->
                <div class="page-header"><a class="page-header-link" href="index.php">Home</a> / College Profile</div>
				<!--END Page Header-->
				<!--Page Body-->
				<div class="page-body">
                    <!--Page Logo-->
                    <img class="img-responsive page-logo" alt="star image" src="../images/star.png">
                    <hr class="hr-divider">
                    <!--Bootstrap Top Row-->
                    <div class="row">
                        <!--Accreditation Section-->
                         <div class="col-xs-12">
                             <div class="lg-heading page-content-heading bar-header">
                                 <i class="fa fa-star" aria-hidden="true"></i> Ranking
                             </div>
                             <div class="page-content">
                                 We are proud to announce that our prestigious institution has been accredited <strong>B+</strong> Level Grade by NAAC as of 3rd of May 2004.
                             </div>
                         </div>
                    </div>
                    <!--End Bootstrap Top Row-->
                    <hr class="hr-divider">
                    <!--Bootstrap Bottom Row-->
                    <div class="row">
                        <!--Left Column Vision Section -->
                        <div class="col-md-6">
                            <div class="lg-heading page-content-heading bar-header">
                                 <i class="fa fa-eye" aria-hidden="true"></i> Vision
                             </div>
                            <div class="page-content">
                            <ul>
                                <li>Looking into our strengths we endeavor to emerge as an Educational Institution of excellence in the field of Commerce, Management and Information Technology.</li>
                                <li>To promote and excel in entrepreneurial skills in the techno-savvy competitive era of liberalization and globalization.</li>
                            <li>To make the institute a hub of excellence in the academic and co-curricular sphere, thereby institutionalizing a culture of openness, transparency and meritocracy in the campus</li>
                        <li>It aims to broaden its traditional progressive vision to regularly stay updated through research and by use of the latest technology.</li>
                                </ul>
                                </div>
                        </div>
                        <!--End Vision Section-->
                        <!--Right Column Mission section-->
                        <div class="col-md-6">
                         <div class="lg-heading page-content-heading bar-header">
                                 <i class="fa fa-bullseye" aria-hidden="true"></i> Mission
                             </div>
                            <div class="page-content">
                            <ul>
                                    <li> To strengthen economic, cultural and social fabric of the region through education, research and enterprise to elicit tangible results in Business, Industries and Information Technology sectors.</li>
                                    <li>To Enhance Job placement for students </li>
                                    <li>To develop strong and dependable Industry Linkage</li>
                                    <li>To create scope for Infrastructural improvements (Canteen, Toilets, Auditorium, Ramps, more classrooms)</li>
                                    <li>To introduce new courses - Vocational Courses</li>
                                    <li>To encourage self-evaluation, accountability, autonomy and innovations in higher education.</li>
                                    <li>To undertake quality-related research studies, consultancy and training programmes.</li>
                            </ul>
                        </div>
                        </div>
                        <!--End Mission Section-->
                    </div>
    
                            
				</div>
				<!--END Page Body-->
			</div>
			<!--END Page Content Container-->
		</div>
	</div>
	<!--END Bootstrap Row-->
</div>
<!--END Bootstrap Container-->

<?php
    //Include footer Code
    require('../templates/common/footer.php');
?>