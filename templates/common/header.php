<?php
// Include Database Connectivity File
require("../database.php");
// Create a new College Database
$clgdb = new CollegeDatabase();
$clgdb->connect();
// Online Admission Link in the navigation bar
$online_admission_link = "#";
if($clgdb->isConnected()){
    // Fetch Online Admission Link from the database
    $admission_link = $clgdb->executeSql("SELECT * FROM tbl_admission_link;");
    while($link = $admission_link->fetch_assoc()){
       $online_admission_link = $link['link'];
    }

    //Insert Page Hit in the database
    $visitor_ip = mysqli_real_escape_string($clgdb->conn, $_SERVER['REMOTE_ADDR']); // Get IP Address
    $insert_visitor_data = "INSERT INTO tbl_visitor (ip_address) VALUES (\"$visitor_ip\");";
    $clgdb->executeSql($insert_visitor_data);
    // Disconnect from database
    $clgdb->disconnect();
}
?>
<!DOCTYPE html>
<html lang="en">
<!--Header-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Sri Pratap Memorial Rajput College of Commerce, a prestigious name in the discipline of commerce, was founded in the year 1955 to keep alive the memory of Late His Highness Maharaja Pratap Singh of Jammu and Kashmir State."/>
	<meta name="keywords" content="Sri Pratap Memorial Rajput College of Commerce Jammu, S.P.M.R College of Commerce Jammu, commerce college jammu, B.Com Course, B.Com jammu, Commerece B.Com jammu,Commerece college affiliated to university of jammu, affiliated to jammu university colleges, affiliated to jammu university commerce college" />
	<meta name="robots" content="index,follow">
    <meta name="author" content="Trilokia Inc { Code, Debug & Execute } - A Webdesign Company in Jammu, India : www.trilokiainc.com">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title;?></title>
    <link rel="icon" type="image/png" href="../images/favicon.png">
    <!-- Bootstrap CSS THEME-->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <!--Lightbox css file-->
    <link rel="stylesheet" href="../css/ekko-lightbox.css">
    <!--Font-awesome theme file-->
    <link rel="stylesheet" href="../css/font-awesome.css">
    <!--CUSTOM DEFINED CSS THEME FILE -->
    <link rel="stylesheet" href="../css/theme.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Jquery Marquee Plugin -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.marquee/1.4.0/jquery.marquee.min.js"></script>
</head>
<!--End Header-->
<!--Body-->
<body>
    <!--Bootstrap FIXED TOP NAVIGATION BAR-->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <!--Navbar toggle button for mobile display -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myInverseNavbar2" aria-expanded="false"> <span class="sr-only">Toggle navigation menu</span><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
                <div class="navbar-brand date">
                    <span class="glyphicon glyphicon-calendar"></span>
                    <?php
					// GET Today Date
					$format = 'l, d F, Y'; //Example: Sunday, 01 January, 2016
                    $formatted_date = date($format);//Get formatted current date
                    echo $formatted_date;
				?>
                </div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="myInverseNavbar2">
                <!--NAVIGATION MENU LIST ITEMS-->
                <ul class="nav navbar-nav navbar-right">
                    <!--Navigation Home Button-->
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <!-- End Navigation Home Button -->
                    <!--Navigation About Menu-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <span class="glyphicon glyphicon-info-sign"></span> About <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="principaldesk.php">Principal Desk</a></li>
                            <li><a href="collegehistory.php">College History</a></li>
                            <li><a href="collegeprofile.php">College Profile</a></li>
                            <li><a href="gallery.php">Gallery</a></li>
                            <li><a href="formerprincipals.php">Former Principals</a></li>
                            <li><a href="committee.php">College Committee</a></li>
                            <li><a href="contactus.php">Contact</a></li>
                            <li><a href="alumni.php">Alumni</a></li>
                        </ul>
                    </li>
                    <!--End Navigation About Menu-->
                    <!--Navigation Campus Menu-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <span class="glyphicon glyphicon-leaf"></span> Campus <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Academic Facilities</li>
                            <li><a href="library.php">Library</a></li>
                            <li><a href="academicfacilities.php?id=lab">Computer Lab</a></li>
                            <li><a href="academicfacilities.php?id=smartclass">Smart Classroom</a></li>
                            <li><a href="academicfacilities.php?id=gamesandsports">Games And Sports</a></li>
                            <li><a href="scholarships.php">Scholarships</a></li>
                            <li><a href="academicfacilities.php?id=placement">Job Placement</a></li>
                            <li role="separator" class="divider" style="background-color:#b0bec5; margin-left:15pt; margin-right:15pt"></li>
                            <li class="dropdown-header">Infrastructure</li>
                            <li><a href="hostel.php">Hostel</a></li>
                            <li><a href="infrastructure.php?id=canteen">Canteen</a></li>
                            <li><a href="infrastructure.php?id=dispensary">Medical Dispensary</a></li>
                            <li><a href="infrastructure.php?id=girlscommonroom">Girl's Common Room</a></li>
                            <li role="separator" class="divider" style="background-color:#b0bec5; margin-left:15pt; margin-right:15pt"></li>
                            <li><a href="grievance.php">Grievance Redressal</a></li>
                        </ul>
                    </li>
                    <!--End Navigation Campus Menu-->
                    <!--Navigation Academics Menu-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <span class="glyphicon glyphicon-education"></span> Academics <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="coursedetails.php">Courses Details</a></li>
                            <li><a href="academic_cal.php">Academic Calendar</a></li>
                            <li><a href="faculty.php">Faculty</a></li>
                            <li role="separator" class="divider" style="background-color:#b0bec5; margin-left:15pt; margin-right:15pt"></li>
                            <li class="dropdown-header">Examination</li>
                            <li><a href="assessment.php">Internal Assessment</a></li>
                            <!--<li><a href="examination.php">External Assessment</a></li>-->
                            <li><a href="results.php">Results</a></li>
                            <li role="separator" class="divider" style="background-color:#b0bec5; margin-left:15pt; margin-right:15pt"></li>
                            <li class="dropdown-header" >Publication</li>
                            <li><a href="publication.php?id=newsletter">News Letter</a></li>
                            <li><a href="publication.php?id=prospectus">Prospectus</a></li>
                        </ul>
                    </li>
                    <!--End Navigation Academics Menu-->
                    <!--Navigation  Admissions Menu-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <span class="glyphicon glyphicon-user"></span> Admissions <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $online_admission_link; ?>" target="_blank">Online Admission</a></li>
                            <li><a href="admission.php?id=admission_rules">Admission Rules</a></li>
                            <li><a href="admission.php?id=docs_req">Document Required</a></li>
                            <li><a href="admission.php?id=fee_struct">Fee Structure</a></li>
                            <li><a href="admission.php?id=intake_cap">Intake Capacity</a></li>
                        </ul>
                    </li>
                    <!--End Navigation Admissions  Menu-->
                    <!--Navigation Activities Menu-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <span class="glyphicon glyphicon-bookmark"></span> Activities <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="activities.php?id=culevents">Cultural Events</a></li>
                            <li><a href="activities.php?id=debates">Debates</a></li>
                            <li><a href="activities.php?id=symposium">Symposium</a></li>
                            <li><a href="sports.php">Sports</a></li>
                            <li><a href="ncc.php">NCC</a></li>
                            <li><a href="nss.php">NSS</a></li>
                        </ul>
                    </li>
                    <!--End Navigation Activities Menu-->
                </ul>
                <!--END NAVIGATION MENU LIST ITEMS-->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <!--END NAVIGATION BAR-->
    <!-- COLLEGE LOGO NAME HEADER -->
    <div class="container-fluid header-box">
        <div class="header">
            <div class="clg-name"><a href="index.php"><img src="../images/logo.png" class="logo" alt="College Logo"></a> GOVT. SPMR COLLEGE OF COMMERCE</div>
            <div class="affiliation">( Affiliated to University of Jammu )</div>
        </div>
    </div>
    <!-- END COLLEGE LOGO NAME HEADER -->
    <!--BANNER AND UPDATES Container-->
    <div class="container-fluid">
        <!--ROW1 Banner-->
        <div class="row">
            <div class="col-xs-12">
                <!--BOOTSTRAP CAROUSEL Banner Component-->
                <div id="carousel-299058" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-299058" data-slide-to="0" class="active"> </li>
                        <li data-target="#carousel-299058" data-slide-to="1" class=""> </li>
                        <li data-target="#carousel-299058" data-slide-to="2" class=""> </li>
                        <li data-target="#carousel-299058" data-slide-to="3" class=""> </li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active"> <img class="img-responsive" src="../images/banner1.jpg" alt="thumb">
                            <div class="carousel-caption slider-caption">Principal Office Block</div>
                        </div>
                        <div class="item"> <img class="img-responsive" src="../images/banner2.jpg" alt="thumb">
                            <div class="carousel-caption slider-caption">College Library Building</div>
                        </div>
                        <div class="item"> <img class="img-responsive" src="../images/banner3.jpg" alt="thumb">
                            <div class="carousel-caption slider-caption">College Ground for Games and Sports</div>
                        </div>
                        <div class="item"> <img class="img-responsive" src="../images/banner4.jpg" alt="thumb">
                            <div class="carousel-caption slider-caption">College Departments Building</div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-299058" data-slide="prev"><span class="icon-prev"></span></a> <a class="right carousel-control" href="#carousel-299058" data-slide="next"><span class="icon-next"></span></a>
                </div>
                <!--END BOOTSTRAP CAROUSEL Banner Component-->
            </div>
        </div>
        <!--End ROW1 Banner-->
        <!--Horizontal ROW -->
        <hr class="hr-divider">
        <!--UPDATES SECTION-->
        <div class="row" style="margin-left:0px; margin-right:0px;">
            <div class="col-xs-2 alert-head">Updates</div>
            <div class="col-xs-10 alert-body marquee" data-duration="10000" data-duplicated="true">
                <div style="font-family:'Trebuchet MS' , sans-serif;">
                    <ul class="inline-list" style="overflow:hidden;">
                        <?php
                        // PHP CODE TO FETCH Updates
                        $clgdb->connect();
                        if($clgdb->isConnected()){
                            $results = $clgdb->executeSql("SELECT title, link, UNIX_TIMESTAMP(time_stamp) As dated FROM tbl_updates ORDER BY time_stamp DESC;");
                            if(!$results->num_rows){
                                echo "<li>No updates yet</li>";
                            }else{
                                // Get Updates from Database and generate <li></li> tags for each update
                                // Update Format :-  Update Title Here NEW (02-10-2017)
                                while($update = $results->fetch_assoc()){
                                    $update_title = $update['title'];
                                    $update_link = $update['link'];
                                    $timestamp = $update['dated'];
                                    $update_dated = date("(d-m-Y)", $timestamp);
                                    // check if the update is new i.e. is not 10 days old
                                    $time_gap = (60 * 60 * 24 * 10);
                                    $is_new = ((time() - $time_gap) < $timestamp) ? true : false;
                                    // Set new badge if the update is new
                                    $new_badge = ($is_new) ? "<span class=\"label label-info\">New</span>" : "";
                                    if(is_null($update_link) or (strlen(trim($update_link)) <= 0)){ // When Update does not have link
                                        $update_link = "#";
                                    }
                                    echo "<li style=\"margin-right:10px;\"><a class=\"alert-link\" href=\"$update_link\">$update_title $new_badge $update_dated</a> |</li>";
                                }
                            }
                            $clgdb->disconnect();
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--END UPDATES SECTION-->
        <!--CSS Horizontal ROW -->
        <hr class="hr-divider">
    </div>
    <!--END BANNER AND UPDATES Container-->