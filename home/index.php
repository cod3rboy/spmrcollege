<?php
    //Specify Page Title
    $page_title = "Sri Partap Memorial Rajput PG College of Commerce, Jammu";
	//INCLUDE header.php File
	require("../templates/common/header.php");
?>
<!--HOMEPAGE CONTENT CONTAINER having two rows-->
<div class="container-fluid" style="font-family:'Trebuchet MS';">
    <!-- ROW1 WITH Welcome and Pricipal Message sections -->
    <div class="row">
        <!--Welcome Greeting Section-->
        <div class="col-md-6">
            <div class= "showcase">
                <div class="showcase-head">
                    Welcome to Govt. SPMR College of Commerce
                </div>
                <!--Bootstrap Media Component-->
                <div class="media">
                    <div class="media-left"><img class="media-object" src="../images/maharaja-thumb.jpg" alt="Maharaja Partap Singh Ji">
                        <p class="text-center" style="font-size:13px;"><b>Maharaja Pratap Singh</b></p>
                    </div>
                    <div class="media-body">
                        Sri Pratap Memorial Rajput College of Commerce, a prestigious name in the discipline of commerce, was founded in the year 1955 to keep alive the memory of Late His Highness Maharaja Pratap Singh of Jammu and Kashmir State. The commerce stream was introduced for the first time in the State by Dr. Karan Singh, the then visionary Sadar-e-Riyasat in 1955... The college, in its infancy, was housed in the Ajaib Ghar building behind the New Secretariat and at later stage it was shifted to the then Police Complex near Jogi Gate, ...
                    </div>
                </div>
                <!--END Bootstrap Media Component-->
                <!--Horizontal Row-->
                <hr>
                <div class="row"><div class="col-xs-12"><p class="text-center" style="font-family:arial;"><a href="collegehistory.php" class="btn btn-primary" role="button">View History</a></p></div></div>
            </div>
        </div>
        <!--END Welcome Greeting Section-->
        <!--Principal Message Section-->
        <div class="col-md-6">
            <div class="showcase">
                <div class="showcase-head">Principal Message</div>
                <!--Bootstrap Media Component-->
                <div class="media" style="padding:5px;">
                    <div class="media-left">
                        <?php
                            // Default Principal Name
                            $principal_name = "No Name";
                            // Default Principal Photo
                            $principal_image = "../images/nophoto.png";
                            // Connect to Database and Query Principal name and photo
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $result = $clgdb->executeSql("SELECT name, pic_path FROM tbl_principal;");
                                if($row = $result->fetch_assoc()){
                                    $principal_name = $row['name']; // Store Principal Name
                                    $principal_image = $row['pic_path']; // Store Principal Photo
                                }
                                $clgdb->disconnect(); // Disconnect from database
                            }
                        ?>
                        <!--Principal Image and Name-->
                        <img class="media-object" src="<?php echo "$principal_image"; ?>" alt="Principal <?php echo $principal_name;?>" style="width:80px; height:106px;">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading"><b><?php echo $principal_name." (Principal)"; ?></b></h5>
                        Dear Students, We are all aware that education is a fundamental pillar of democracy, sustainable development, human rights and peace. It is a dynamic process by which knowledge, character and behavior of a person is moulded in a positive direction. I congratulate you for enrolling yourself in this college by making a choice for higher education to seek advanced knowledge and better skills while developing professional and practical insights into your area of study.
                    </div>
                </div>
                <!--END Bootstrap Media Component-->
                <!--Horizontal Row-->
                <hr>
                <div class="row"><div class="col-xs-12"><p class="text-center" style="font-family:arial;"><a href="principaldesk.php" class="btn btn-primary" role="button">Read More</a></p></div></div>
            </div>
        </div>
        <!--End Principal Message Section-->
    </div>
    <!--END ROW1 WITH Welcome and Pricipal Message sections-->

    <!--Horizontal Row-->
    <hr>
    <!-- ROW2 with vision, gallery, imp links, notifications,downloads and Patronage Sections-->
    <div class="row">
        <!--Vision Mission Goal and Notifications Section-->
        <div class="col-lg-6">
            <!-- ROW1 with Vision Goals and Mission Section-->
            <div class="row">
                <!--Vision Goals and Mission Section-->
                <div class="col-md-12">
                    <div class="showcase">
                        <div class="showcase-head" style="margin-bottom:10px;">Our Vision, Goals and Mission</div>
                        <!--Bootstrap Tabs Component-->
                        <ul id="myTab1" class="nav nav-tabs">
                            <li class="active"> <a href="#home1" data-toggle="tab" style="font-size:15px;font-family:arial;letter-spacing:1px;">Vision</a></li>
                            <li><a href="#pane2" data-toggle="tab" style="font-size:15px;font-family:arial;letter-spacing:1px;">Goals</a></li>
                            <li> <a href="#pane3" data-toggle="tab" style="font-size:15px;font-family:arial;letter-spacing:1px;">Mission</a></li>
                        </ul>
                        <div id="myTabContent1" class="tab-content tab-container">
                            <div class="tab-pane fade in active" id="home1">
                                <br>
                                <div style="background-color:#CCCCCC;font-weight:bold;text-align:center;font-size:16px;margin-bottom:15px;padding:2px;">
                                    <img src="../images/icon_vision.png" alt="Vision Icon"> Vision
                                </div>
                                <ul>
                                    <li>Looking into our strengths we endeavor to emerge as an Educational Institution of excellence in the field of Commerce, Management and Information Technology.</li>
                                    <li>To promote and excel in entrepreneurial skills in the techno-savvy competitive era of liberalization and globalization.</li>
                                    <li>To make the institute a hub of excellence in the academic and co-curricular sphere, thereby institutionalizing a culture of openness, transparency and meritocracy in the campus.</li>
                                    <li>It aims to broaden its traditional progressive vision to regularly stay updated through research and by use of the latest technology.</li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="pane2">
                                <br>
                                <div style="background-color:#CCCCCC;font-weight:bold;text-align:center;font-size:16px;margin-bottom:15px;padding:2px;">
                                    <img src="../images/icon_goal.png" alt="Goals Icon"> Goals
                                </div>
                                <ul>
                                    <li>Absorption of virtues of traditional commensurate with the 21st century technology.</li>
                                    <li>To enhance creativity, Knowledge and relevant skills, both in academia and extracurricular activities.</li>
                                    <li>To make education holistic, qualitative,socially and economically productive and relevant to the fast changing socio-economic environment.</li>
                                    <li>Exploration, expansion and dissemination of need based knowledge.</li>
                                    <li>To nurture dynamic citizens who are socially and ethically responsible and are creative contributors to the society.</li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="pane3">
                                <br>
                                <div style="background-color:#CCCCCC;font-weight:bold;text-align:center;font-size:16px;margin-bottom:15px;padding:2px;">
                                    <img src="../images/icon_mission.png" alt="Mission Icon"> Mission
                                </div>
                                <ul>
                                    <li> To strengthen economic, cultural and social fabric of the region through education, research and enterprise to elicit tangible results in Business, Industries and Information Technology sectors.</li>
                                    <li>To Enhance Job placement for students </li>
                                    <li>To develop strong and dependable Industry Linkage</li>
                                    <li>To create scope for Infrastructural improvements (Canteen, Toilets, Auditorium, Ramps, more classrooms)</li>
                                    <li>To introduce new courses - Vocational Courses</li>
                                </ul>
                            </div>
                            <div class="row"><div class="col-xs-12"><p class="text-center" style="font-family:arial;"><a href="collegeprofile.php" class="btn btn-primary" role="button">Read More</a></p></div></div>
                        </div>
                        <!--END Bootstrap Tabs Component-->
                    </div>
                </div>
                <!--END Vision Goals and Mission Section-->
            </div>
            <!--END ROW1 with Vision Goals and Mission Section-->
            <!--ROW2 with Notifications Section-->
            <div class="row">
                <!--Notifications Section-->
                <div class="col-md-12">
                    <div class="showcase">
                        <div class="showcase-head">Notifications</div>
                        <!--Horizontal Row-->
                        <hr>
                        <div style="height:155px;overflow:auto;overflow-x:hidden;">
                            <?php
								//PHP CODE TO FETCH HOMEPAGE NOTIFICATIONS
                                $clgdb->connect();
                                if($clgdb->isConnected()){
                                    $notifications = $clgdb->executeSql("SELECT id, title, description, UNIX_TIMESTAMP(time_stamp) As dated FROM tbl_notification ORDER BY time_stamp DESC LIMIT 8;");
                                    if(!$notifications->num_rows){
                                        // Display No Notifications Issued
                                        echo "
                                            <div style=\"position:relative;height:100%;\">
                                                <div style=\"position:absolute;width:100%;text-align:center;top:40%;font-size:22px;color:#999999;\"><i class=\"fa fa-bell-slash-o\"></i> No notifications issued yet</div>
                                            </div>
                                        ";
                                    }else{
                                        // Display Notifications
                                        echo "<table class=\"tbl\">";
                                        while($notify = $notifications->fetch_assoc()){
                                            $id = $notify['id'];
                                            $title = $notify['title'];
                                            $desc = $notify['description'];
                                            $timestamp = $notify['dated'];
                                            $dated = date("d-M-Y h:i a", $timestamp);
                                            // check if the notification is new i.e. is not 10 days old
                                            $time_gap = (60 * 60 * 24 * 10);
                                            $is_new = ((time() - $time_gap) < $timestamp) ? true : false;
                                            $new_badge = ($is_new) ? "<span class=\"label label-info\">New</span>" : "";
                                            echo "
                                                <tr>
                                                    <td class=\"tbl-item\" style=\"text-align:center;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #EEEEEE;background-color: white;\">
                                                        <i class=\"fa fa-bullhorn\" aria-hidden=\"true\"></i>
                                                    </td>
                                                    <td class=\"tbl-item\" style=\"text-align:left;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #EEEEEE;background-color: white;\">
                                                        <a data-toggle=\"modal\" data-target=\"#notificationModal$id\" class=\"showcase-link\" href=\"#\">$title</a> $new_badge
                                                        <table>
                                                            <tr>
                                                                <td><div class=\"timestamp\">Issued Date : $dated</div></td>
                                                            </tr>
                                                        </table>
                                                        <div role=\"dialog\" class=\"modal fade\" id=\"notificationModal$id\">
                                                            <div class=\"modal-dialog\">
                                                                <div class=\"modal-content\">
                                                                    <div class=\"modal-header\">
                                                                        <button class=\"close\" data-dismiss=\"modal\">Close <i class=\"fa fa-close\" aria-hidden=\"true\"></i></button>
                                                                        <div class=\"modal-title\"><strong>$title</strong></div>
                                                                    </div>
                                                                    <div class=\"modal-body\">$desc</div>
                                                                    <div class=\"modal-footer timestamp\">Issued Date : $dated</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                        echo "</table>";
                                    }
                                    $clgdb->disconnect();
                                }
							?>
                        </div>
                        <!--Horizontal Row-->
                        <hr>
                        <div class="row"><div class="col-xs-12"><p class="text-center" style="font-family:arial;"><a href="notifications.php" class="btn btn-primary" role="button">View All</a></p></div></div>
                    </div>
                </div>
                <!--END Notifications Section-->
            </div>
            <!--END ROW2 with Notifications Section-->
        </div>
        <!--END Vision Mission Goal and Notifications Section-->
        <!--Gallery, Downloads and Important Links and Patronage Sections-->
        <div class="col-lg-6">
            <!--Gallery and Downloads Sections-->
            <div class="col-sm-7">
                <!--ROW1 with Gallery Section-->
                <div class="row">
                    <!--Gallery Section-->
                    <div class="col-sm-12">
                        <div class="showcase" style="background-color:#EEEEEE;">
                            <div class="showcase-head">Photo Gallery</div>
                                <?php
                                // PHP SCRIPT TO GENERATE PHOTO GALLERY TABLE
                                // There are two rows and half-half of the total images are
                                // shown in both rows.

                                // Class definition of GalleryImage object
                                class GalleryImage{
                                    public $id; // To Store Gallery Image ID
                                    public $path; // To Store path to full resolution image
                                    public $thumb_path; // To Store path to thumbnail
                                    public $caption; // To Store caption of Image
                                    public $timestamp; // To Store Image upload timestamp

                                    // Constructor
                                    public function __construct($img_id, $img_path, $img_thumb_path, $img_caption, $img_timestamp){
                                        $this->id = $img_id;
                                        $this->path = $img_path;
                                        $this->thumb_path = $img_thumb_path;
                                        $this->caption = $img_caption;
                                        $this->timestamp = $img_timestamp;
                                    }
                                }
                                $clgdb->connect();
                                if($clgdb->isConnected()){
                                    // Get all images that are set for slider
                                    $count_rec_query = $clgdb->executeSql("SELECT * FROM tbl_gallery WHERE use_in_slider = 1;");
                                    // Get Total records
                                    $total_records = $count_rec_query->num_rows;
                                    if(!$total_records){ // When total records are 0
                                        // Display no pictures message in the gallery
                                        echo "
                                            <div style=\"position:relative;margin:auto;min-height:300px;\">
                                                <div style=\"position:absolute;margin:auto;width:100%;top:50%;font-size:20px;color:#777777;text-align:center;\"><i class=\"fa fa-image\" aria-hidden=\"true\"></i> No picture found</div>
                                            </div>
                                        ";
                                    }else{
                                        echo "<div class=\"marquee\" style=\"min-height:300px;\" data-direction=\"right\" data-duration=\"8000\" data-duplicated=\"true\">";
                                        // Display images from an array into table
                                        $image_array = array();

                                        // No of images to display in slider
                                        $slider_images_count = 6;
                                        // Query randomly $slider_images_count images from images set for slider
                                        $results = $clgdb->executeSql("SELECT id, img_path, img_thumb_path, caption, DATE_FORMAT(time_stamp, \"Upload Date : %d-%b-%Y\") AS time_stamp FROM tbl_gallery WHERE use_in_slider = 1 ORDER BY RAND() LIMIT $slider_images_count;");
                                        while($row = $results->fetch_assoc()){
                                            // Create a new GalleryImage Object and Store it in Image Array
                                            $image = new GalleryImage($row['id'], $row['img_path'], $row['img_thumb_path'], $row['caption'], $row['time_stamp']);
                                            array_push($image_array, $image);
                                        }
                                        $total_rows = 2; // No of rows
                                        $total_images = count($image_array);
                                        $startpos = 0; // Start Position
                                        $endpos = ceil($total_images/2); // Ceil for odd no. of images
                                        echo "<table>";// table opening tag
                                        for ($i=0; $i < $total_rows; $i++){
                                            // Table Row Tag
                                            echo "<tr>";
                                            for($j=$startpos;$j<$endpos;$j++){
                                                $image = $image_array[$j];
                                                // Display table data column tag
                                                echo "<td><a data-toggle=\"modal\" data-target=\"#imgmodal$image->id\"><img class=\"img-responsive img-thumbnail gallery-pic\" style=\"margin:5px;\" src=\"$image->thumb_path\"></a>";
                                                // Generate Bootstrap Modal Component for gallery image in table data column
                                                echo "
                                                    <div id=\"imgmodal$image->id\" class=\"modal fade\" role=\"dialog\">
                                                        <div class=\"modal-dialog\">
					                                       <div class=\"modal-content\">
					                                           <div class=\"modal-header\">
					                                           <button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span class=\"glyphicon glyphicon-remove\"></span> Close</button>
					                                           <strong>$image->caption</strong></div>
						                                        <div class=\"modal-body\"><img src=\"$image->path\" class=\"img-responsive\" style=\"display:block;margin: 0 auto;\"></div>
						                                        <div class=\"modal-footer timestamp\">$image->timestamp</div>
					                                        </div>
				                                        </div>
                                                    </div>
												  </td>
                                                ";
                                            }
                                            // End Table Row tag
                                            echo "</tr>";
                                            // Update start and end position indicators value to
                                            // next half of the total images for second row
                                            $startpos = $endpos;
                                            $endpos = $total_images;
                                        }
                                        echo "</table>";// table closing tag
                                        echo "</div>"; // Close Marquee element
                                    }
                                    $clgdb->disconnect();
                                }
                                ?>
                            <div class="row"><div class="col-xs-12"><p class="text-center" style="font-family:arial;"><a href="gallery.php" class="btn btn-primary" role="button">Visit Gallery</a></p></div></div>
                        </div>
                    </div>
                    <!--END Gallery Section-->
                </div>
                <!--END ROW1 with Gallery Section-->
                <!--ROW2 with Downloads Section-->
                <div class="row">
                    <!--Download Section-->
                    <div class="col-sm-12">
                        <div class="showcase">
                            <div class="showcase-head">Downloads</div>
                            <!--Horizontal Row-->
                            <hr>
                            <div style="height:155px;overflow:auto;overflow-x:hidden;">
                                <?php
                                //PHP CODE TO FETCH DOWNLOADS LIST
                                    $clgdb->connect();
                                    if($clgdb->isConnected()){
                                        $downloads_recs = $clgdb->executeSql("SELECT * FROM tbl_download ORDER BY time_stamp DESC LIMIT 6;");
                                        if(!$downloads_recs->num_rows){
                                            // No Download Items Found
                                            echo "
                                            <div style=\"position:relative;height:100%;\">
                                                <div style=\"position:absolute;width:100%;text-align:center;top:40%;font-size:20px;color:#999999;\"><i class=\"fa fa-download\"></i> No files to download</div>
                                            </div>
                                        ";
                                        }else{
                                            // Display Downloads List
                                            echo "<table class=\"tbl\">";
                                            while($download = $downloads_recs->fetch_assoc()){
                                                $link = $download['link'];
                                                $file_desc = $download['filedesc'];
                                                echo "<tr><td class=\"tbl-item\" style=\"text-align:center;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #EEEEEE;background-color: white;\"><i class=\"fa fa-angle-double-down\" aria-hidden=\"true\"></i></td>
                                                      <td class=\"tbl-item\" style=\"text-align:left;border-left:none;border-right:none;border-top:none;border-bottom:1px solid #EEEEEE; background-color:white;\"><a class=\"showcase-link\" target=\"_blank\" href=\"$link\"> $file_desc</a></td></tr>";
                                            }
                                            echo "</table>";
                                        }
                                        $clgdb->disconnect();
                                    }
                                ?>
                            </div>
                            <!--Horizontal Row-->
                            <hr>
                            <div class="row"><div class="col-xs-12"><p class="text-center" style="font-family:arial;"><a href="downloads.php" class="btn btn-primary" role="button">View All</a></p></div></div>
                        </div>
                    </div>
                    <!--END Download Section-->
                </div>
                <!--END ROW2 with Downloads Section-->
            </div>
            <!--END Gallery and Downloads Sections-->
            <!--Important Links and Patronage Section-->
            <div class="col-sm-5">
                <!--Important Links Section-->
                <div class="showcase">
                    <div class="showcase-head">Important Links </div>
                    <ul style="margin-top:22px;">
                        <li><a href="http://www.coeju.com" class="my-link" target="_blank">Controller of Examination</a></li>
                        <hr class="hr-divider">
                        <li><a href="http://www.smvdu.ac.in" class="my-link" target="_blank">Shri Mata Vaishno Devi University</a></li>
                        <hr class="hr-divider">
                        <li><a href="http://www.jammuuniversity.in" class="my-link" target="_blank">Jammu University</a></li>
                        <hr class="hr-divider">
                        <li><a href="http://www.kashmiruniversity.net" class="my-link" target="_blank">Kashmir University</a></li>
                        <hr class="hr-divider">
                        <li><a href="http://www.ugc.ac.in" class="my-link" target="_blank">UGC Delhi</a></li>
                        <hr class="hr-divider">
                        <li><a href="http://www.jkhighereducation.nic.in" class="my-link" target="_blank">JK Higher Education</a></li>
                    </ul>
                </div>
                <!--END Important Links Section-->
                <!-- Patronage Section -->
                <div class="showcase">
                    <div class="showcase-head">With Patronage Of ...</div>
                    <div class="marquee patronage-section" data-direction="up" data-duration="8000" data-duplicated="true">
                        <div class="media-object-default">

                            <div class="media img-rounded" style="background-color: #0066CC;padding:5px;">
                                <div class="media-left">
                                    <img class="media-object img-circle patronage-photo" src="../images/ansari.png" alt="Janab Syed Mohammad Altaf Bukhari">
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading">Janab Syed Mohammad Altaf Bukhari</h5>
                                    <b>Hon'ble Minister for Education</b>
                                    <br>
                                </div>
                            </div>

                            <div class="media img-rounded" style="background-color: #669900;padding:5px;">
                                <div class="media-left">
                                    <img class="media-object img-circle patronage-photo" src="../images/tour.jpg" alt="Smt. Priya Sethi">
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading">Smt. Priya Sethi</h5>
                                    <b>Hon'ble Minister of State for Education.<br>
											Technical Education, Culture, Tourism.<br>
											Horticulture, Floriculture and Parks.
										</b>
                                    <br>
                                </div>
                            </div>

                            <div class="media img-rounded" style="background-color: #660099;padding:5px;">
                                <div class="media-left">
                                    <img class="media-object img-circle patronage-photo" src="../images/commissiner.jpg" alt="Dr. Asgar Hassan Samoon">
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading">Dr. Asgar Hassan Samoon</h5>
                                    <b>IAS, Secretary,<br>Higher Education Department</b>
                                    <br>
                                </div>
                            </div>

                            <div class="media img-rounded" style="background-color:#FF9933;padding:5px;">
                                <div class="media-left">
                                    <img class="media-object img-circle patronage-photo" src="../images/director.jpg" alt="Dr. Renu Goswami">
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading">Dr. Renu Goswami</h5>
                                    <b>Director Colleges,<br>Higher Education Department</b>
                                    <br>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END Patronage Section -->
            </div>
            <!--END Important Links and Patronage Section-->
        </div>
        <!--END Gallery, Downloads and Important Links and Patronage Sections-->
    </div>
    <!-- END ROW2 with vision, gallery, imp links, notifications,downloads and Patronage Sections-->
</div>
<!--END HOMEPAGE CONTENT CONTAINER-->
	<!-- Sale Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
          <h4 class="modal-title"><strong>Please read the following message before using website</strong></h4>
        </div>
        <div class="modal-body">
          <p>
          	This is an unofficial website of SPMR College of Commerce. We neither claim to provide any service on behalf of SPMR college of commerce nor we are attached to the college. This website is just made for fun as a part of a project and now it is available for sale. If any other college/university want to have this website as their official portal then you can contact us at our email <strong>dkchalotra@gmail.com</strong> and we will modify this website according to your organisation needs. Price and other matters will be discussed with you in person. 
          </p>
          <p>Thank You for reading above message. You can consider this website as a demo and may now explore it.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<script type="text/javascript">
	setTimeout(()=>{
		$('#myModal').modal('show');
	}, 1000);
</script>
<?php 
	//INCLUDE footer.php File
	require("../templates/common/footer.php");
?>