<?php
    //Include Header Code
    $page_title = "Infrastructure";
    require("../templates/common/header.php");
    // Set Scroll Position ID
    if(!isset($_GET['id'])){
        $scroll_id = "pagecontent";
    }else{
        $scroll_id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    }
?>
<!--Bootstrap Container-->
<div class = "container">
    <!--Bootstrap Row-->
     <div  class = "row">
         <!--Bootstrap Column-->
          <div class = "col-xs-12">
              <!--Page Container-->
              <div class="page-container" id="pagecontent">
                  <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / <a class="page-header-link" href="facilities.php">Facilities</a> / Infrastructure
                </div>
                  <!--End Page Header-->
                  <!--Page Body-->
                <div class="page-body">
                    <!--Hostel Section-->
                    <div class="lg-heading page-content-heading bar-header">
						<i class="fa fa-hotel" aria-hidden="true"></i> HOSTEL
                    </div>
				    <div class="page-content">
                        <ul>
                            <li>Looking into the needs of students coming from far off regions of the state to study in our college, we have built a new college hostel with a capacity to accommodate 125 students.</li>
                            <li>Efforts have been made to give all kinds of comfort to the hostellers so that they do not have to worry about day to day needs at the cost of their studies.</li>
                        </ul>
				    </div>
                    <hr>
                    <!--Canteen Section-->
                    <div class="lg-heading page-content-heading bar-header" id="canteen">
						<span class="glyphicon glyphicon-cutlery"></span> CANTEEN
                    </div>
				    <div class="page-content">
                        <ul>
                            <li>Adjoining the Recreation Hall, the college has its canteen. It is in the main campus and caters as tuck shop to the students and the staff at concessional rates.</li>
                            <li>Offlate, Lipton Kisok has also been installed.</li>
                        </ul>
				    </div>
                    <hr>
                    <!--Dispensary Section-->
					<div class="lg-heading page-content-heading bar-header" id="dispensary">
						<i class="fa fa-medkit" aria-hidden="true"></i> MEDICAL DISPENSARY
                    </div>
				    <div class="page-content">
                        <ul>
                            <li> The College Dispensary is fully equipped with all kind of medical first aid facilities for students.</li>
                            <li>Qualified pharmacist is present during the college hours for all kind of medical emergency.</li>
                            <li>The college dispensary is regularly stocked with the latest medicines and equipments.</li>
                        </ul> 			
                    </div>
					<hr>
                    <!--Girls Common Room Section-->
					<div class="lg-heading page-content-heading bar-header" id="girlscommonroom">
						<i class="fa fa-female" aria-hidden="true"></i> GIRLS COMMON ROOM
                    </div>
				    <div class="page-content">
                        <ul>
                            <li>A fully furnished Girls Common Room has been erected in the college premises keeping in view the requirements of female students.</li>
                            <li>This common room provides various facilities like magazines, newspapers, water coolers, washrooms, indoor games and also a full time female attendant as care taker.</li>
                        </ul>
				    </div>
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
<script type="text/javascript">
    //Automatic Scroll to the page content on page load
    $(document).ready(function () {
        // Handler for .ready() called.
        $('html, body').animate({scrollTop: $('#<?php echo $scroll_id;?>').offset().top - 60}, 'slow');
    });
</script>
<?php
    //Include Footer Code
    require("../templates/common/footer.php");
?>
