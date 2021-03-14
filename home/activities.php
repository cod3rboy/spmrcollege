<?php
    //Set page title
    $page_title = "Activities";
    //Include Header Code
    require("../templates/common/header.php");

    // Set Scroll Position ID
    if(!isset($_GET['id'])){ // When ID variable is not set by the user
        $scroll_id = "pagecontent"; // Set Scroll Position ID to Page Content Container
    }else{ // When ID variable is set by the user
        // Set Scroll ID Position to the value in the ID variable
        $scroll_id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    }
?>
<!--Bootstrap Container-->
<div class="container">
    <!--Bootstrap Row-->
    <div class="row">
        <!--Bootstrap Column-->
        <div class="col-xs-12">
            <!--Page Content Container-->
            <div class="page-container" id="pagecontent">
                <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / Activities
                </div>
                <!--Page Body-->
                <div class="page-body">
                    <!--Cultural Events Section-->
                    <div class="lg-heading page-content-heading bar-header" id="culevents"><i class="fa fa-asl-interpreting" aria-hidden="true"></i> Cultural Events</div>
                    <div class="page-content">
                        <ul>
                            <li>We firmly believe that students must know about the glorious past, way of living, culture and moral values.</li>
                            <li>College organizes cultural events to make students understand cultures and what our ancestors have preserved for us for centuries.</li>
                        </ul>
                    </div>
                    <hr class="hr-divider">
                    <!--Debates Section-->
                    <div class="lg-heading page-content-heading bar-header" id="debates"><i class="fa fa-question-circle" aria-hidden="true"></i> Debates</div>
                    <div class="page-content">
                        <ul>
                            <li>College organizes debate competitions to provide students a platform to express their opinions on various day to day issues.</li>
                            <li>It helps them to develop argument skills, self-confidence  and builds sense of ownership and empowerment among them.</li>
                        </ul>
                    </div>
                    <hr class="hr-divider">
                    <!--Symposium Section-->
                    <div class="lg-heading page-content-heading bar-header" id="symposium"><i class="fa fa-users" aria-hidden="true"></i> Symposium</div>
                    <div class="page-content">
                        <ul>
                            <li>College organizes symposiums to enable students express their viewpoint on various important topics and share their messages, issues and problems regarding the topic and also give topics a meaningful conclusion.</li>
                            <li>Symposiums help the students to become a professional speaker and orator in future.</li>
                        </ul>
                    </div>
                    <hr class="hr-divider">
                    <!--Sports Section-->
                    <div class="lg-heading page-content-heading bar-header"><i class="fa fa-soccer-ball-o" aria-hidden="true"></i> Sports</div>
                    <div class="page-content">
                        <ul>
                            <li>Sports play a vital role in developing physical and mental ability of a person. </li>
                            <li>In this college ample opportunity is offered to the students for participation in different kinds of sports.</li>
                            <li>Enthusiasm is seen among the students when they get selected for national and international games.</li>
                            <li>Proper arrangements have been provided for housing indoor Games as well as for outdoor games.</li>
                            <li> Interested students are trained for the sports of their liking under the guidance/ supervision of Director, Department Physical Education.</li>
                            <li>Students participating in the games are given the benefit of being on duty to a maximum of 30 days.</li>
                            <li>183 players of our College participated in Inter- College Tournaments/Competitions (Men & Women) held in University of Jammu, Jammu in different games during the academic session 2016-17 and brought laurels to the institution during the academic session as per following detail.</li>
                        </ul>
                    </div>
                    <hr class="hr-divider">
                    <!--NCC Section-->
                    <div class="lg-heading page-content-heading bar-header"><i class="fa fa-male" aria-hidden="true"></i> NCC</div>
                    <div class="page-content">
                        <ul>
                            <li>NCC provides an opportunity for students to become trained personnel in the Defence
                                Forces of India.
                            </li>
                            <li>The desire of a student to be a Commissioned Officer is fulfilled by the NCC Wing of the
                                college.
                            </li>
                            <li>Infantry and Naval wings of the NCC is always here to inculcate a sense of discipline
                                and leadership qualities
                            </li>
                            <li> Besides working in peace, the cadets also are trained to serve during war-like
                                situations.
                            </li>
                            <li>There is an opportunity for cadets to attend camps both at the national and
                                international level.
                            </li>
                            <li>Multifaceted training is imparted to cadets in these camps.</li>
                        </ul>
                    </div>
                    <hr class="hr-divider">
                    <!--NSS Section-->
                    <div class="lg-heading page-content-heading bar-header"><i class="fa fa-handshake-o" aria-hidden="true"></i> NSS</div>
                    <div class="page-content">
                        <ul>
                            <li>The NSS unit of the college serves as a platform to the students to contribute their
                                services for the nation and humanity under the guidance/ supervision of NSS programme
                                officers.
                            </li>
                            <li>Regular camps at College/ University level are organised to educate students about the
                                complex problems being faced by the less privileged sections of society.
                            </li>
                            <li>The college duly recognizes the voluntary services rendered by the NSS volunteers by
                                awarding them Medals and Certificates for their good performance, having valuable points
                                at the time of Admission to institutes of higher learning or while seeking a job.
                            </li>
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
    //Include Footer Code
    require("../templates/common/footer.php");
?>