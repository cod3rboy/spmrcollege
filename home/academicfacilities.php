<?php
    //Include Header Code
    $page_title = "Academic Facilities";
    require("../templates/common/header.php");
    // Set Scroll Position ID
    if(!isset($_GET['id'])){ // When id variable is not set by user
        // Set Scroll Position ID to Page Content Container
        $scroll_id = "pagecontent";
    }else{ // When id variable is set by user
        // Set Scroll Position to the ID in the id variable
        $scroll_id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    }
?>
<!--Bootstrap Container-->
<div class = "container">
    <!---Bootstrap Row-->
     <div  class = "row">
         <!--Bootstrap Column-->
          <div class = "col-xs-12">
              <!--Page Content Container-->
              <div class="page-container" id="pagecontent">
                  <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / <a class="page-header-link" href="facilities.php">Facilities</a> / Academic Facilities
                </div>
                  <!--End Page Header-->
                  <!--Page Body-->
                <div class="page-body">
                    <!--Library Section-->
                    <div class="lg-heading page-content-heading bar-header">
                        <i class="fa fa-book" aria-hidden="true"></i> LIBRARY
                    </div>
				    <div class="page-content">
                        <ul>
                            <li>The college library has a collection of more than 40,000 text and reference books besides a number of journals, magazines, periodicals, newsletters and newspapers.</li>
                            <li>Facilities of Reading Room and Reference Section are also provided to the students. With the help of the University Grants Commission, a Text Book Section has also been established where a large number of text books are made available to the needy and deserving students. </li>
                            <li>A photocopying machine has been installed in the library for the staff and the students to make use of it at a nominal cost.</li>
                        </ul>
				    </div>
					<hr>
                    <!--Computer Lab Section-->
                    <div class="lg-heading page-content-heading bar-header" id="lab">
                        <i class="fa fa-desktop" aria-hidden="true"></i> COMPUTER LAB
                    </div>
				    <div class="page-content">
                        <ul>
                            <li>Keeping in view the global advancement in computer sciences, the utility of computer education and info-tech awareness has become the need of the hour.</li>
                            <li>Recognizing this fact and to fulfill the objective, the college has set up a computer lab equipped with latest software and internet to provide a wide range of facilities and training to the students and staff.</li>
                        </ul>
				    </div>
					<hr>
                    <!--Smart Classroom Section-->
					<div class="lg-heading page-content-heading bar-header" id="smartclass">
						<span class="glyphicon glyphicon-blackboard"></span> SMART CLASSROOM
                    </div>
				    <div class="page-content">
                        <ul>
                            <li>The college has developed a smart classroom fully equipped with the latest teaching aids such as projector, video camera, multimedia, Laptop, TV, CD player, slide projectors and a fully functional public address system, with all kinds of latest gadgets conforming to national standards and ISI specifications.</li>
                            <li>The aim is to provide our commerce graduate a place where he /she can come and get refreshed with not only the latest technology but also to participate in regular presentation of discourses by teachers and guest lectures.</li>
                            <li>The adjoining committee room is used for interaction with the business magnates and various faculty members.</li>
                            <li>Students also participate in group discussions, interviews, presentations, seminars etc. arranged from time to time.</li>
                            <li>While using the facility, students get an opportunity to put into application and focus on “Applied Management”.</li>
                        </ul>
				            
				    </div>
				    <hr>
                    <!--Games and Sports Section-->
                    <div class="lg-heading page-content-heading bar-header" id="gamesandsports">
                        <i class="fa fa-futbol-o" aria-hidden="true"></i> GAMES AND SPORTS
                    </div>
				    <div class="page-content">
                        <ul>
                            <li> S.P.M.R. College is renowned for producing victors in sports.</li>
                            <li>The college has a splendid playground for Cricket, Football, Hockey, Tennis, Volleyball, Kabaddi, Handball, Basket Ball, and Badminton.</li>
                            <li> Games are played regularly and every student is expected to play at least one game.</li>
                            <li>After the completion of the admission process, college teams are announced on the basis of the trials and a rigorous selection process.</li>
                            <li>Arrangements have been made for indoor games.</li>
                            <li>Indoor games include chess, table tennis and carrom board.</li>
                            <li>Table tennis which can be played in multipurpose halls and Girl's Common Room.</li>
                            <li>Members of the various teams must report punctually for practice and for matches. The absentees will be fined.</li>
                            <li>Students are required to take care of the games items they use. TPO get them issued, they shall prove their identity and submit their identity card, which will be returned after the safe return of the items.</li>
                        </ul>
				    </div>
                    <hr>
                    <!--Scholarships Section-->
                    <div class="lg-heading page-content-heading bar-header">
						<span class="glyphicon glyphicon-education"></span> SCHOLARSHIPS
                    </div>
				    <div class="page-content">
                        <ul>
                            <li>The College provides scholarships to Scheduled Castes, Scheduled Tribes, Low Income groups, Other Social Castes, RBA, Frontier and Handicapped students.</li>
                            <li>National Loan scholarships and National Scholarships are awarded by the government of India.</li>
                            <li>Besides these, merit scholarships are also awarded to the deserving students by Jammu University.</li> 
                            <li>Over and above these scholarships, liberal help is given to the deserving students out of the Mutual Benefit Fund augmented by the State Government grants and UGC Funds.</li> 
                        </ul>
				    </div>
                    <hr>
                    <!--Job Placement Section-->
                    <div class="lg-heading page-content-heading bar-header" id="placement">
						<span class="glyphicon glyphicon-briefcase"></span> JOB PLACEMENT
                    </div>
				    <div class="page-content">
                        <ul>
                            <li>Job Placement and Career counseling cell has been established to help students get the latest information about academic, career and job oriented issues.</li>
                            <li>For job placement, face to face interaction is often arranged with industrial and commercial concerns.</li>
                            <li>To provide part time job, establishment of entrepreneurs under self-employment schemes and other job related assistance are our proposed operational areas.</li>
                        </ul>
				    </div>
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
<script type="text/javascript">
    //Automatic Scroll to the page content on page load
    $(document).ready(function () {
        // Handler for .ready() called.
        $('html, body').animate({scrollTop: $('#<?php echo $scroll_id;?>').offset().top - 60}, 'slow');
    });
</script>
<?php
    //Include footer code
    require("../templates/common/footer.php");
?>
