<?php
    //Specify Page Title
    $page_title = "Principal Desk";
    //INCLUDE HEADER CODE
    require("../templates/common/header.php");
?>
<!--Bootstrap Container-->
<div class="container">
    <!--Bootstrap Row-->
    <div class="row">
        <!--Bootstrap Full size Column-->
        <div class="col-md-12">
            <!--Page Content Container-->
            <div class="page-container" id="scroll-content">
                <!--Page Header-->
                <div class="page-header"><a class="page-header-link" href="index.php">Home</a> / Principal Desk</div>
                <!--END Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Bootstrap Row-->
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-8 col-xs-offset-2 col-md-offset-0">
                            <?php
                            $principal_name = "No Name";
                            $principal_photo_path = "../images/nophoto.png";
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $principal_info = $clgdb->executeSql("SELECT * FROM tbl_principal ;");
                                if($principal_info && $principal_info->num_rows){
                                    while($info = $principal_info->fetch_assoc()){
                                        $principal_name = $info['name'];
                                        $principal_photo_path = $info['pic_path'];
                                    }
                                }
                                $clgdb->disconnect();
                            }
                            ?>
							<!--Principal Name and Photo-->
                            <img src="<?php echo $principal_photo_path; ?>" alt="Principal <?php echo $principal_name; ?>" class="img-responsive img-thumbnail" style="display:block;margin:0 auto;">
                            <div style="text-align:center;font-size:16px;"><b><?php echo $principal_name; ?> (Principal)</b></div>
                        </div>
                    </div>
                    <!--END Bootstrap Row-->
                    <!--Custom Horizontal Row-->
                    <hr class="hr-divider">
                    <div class="md-heading page-content-heading">From the Desk of Principal</div>
                    <br>
                    <div class="page-content">
                        Dear students, I welcome you all to this college for the session 2016-2017. We are all aware that education is a fundamental pillar of democracy, sustainable development, human rights and peace. It is a dynamic process by which knowledge, character and behavior of a person is moulded in a positive direction. I congratulate you for enrolling yourself in this college by making a choice for higher education to seek advanced knowledge and better skills while developing professional and practical insights into your area of study. 
						<br>
						<br>
						It is my proud privilege to inform you that our college has introduced on-line admission from this session. The students will get an opportunity to get hand on experience of the technology already existing here. I assure my students that we will make every effort to provide you with the best possible facilities available in our college. Infact, we will go out of our way to facilitate and support your academic and professional objectives and goals. Serious thought has been given to various academic pursuits aimed at encouraging students to excel in different fields of knowledge like B.C.A, B.B.A, B.COM, B.COM HONS and M.COM. However, we expect that you will be forthcoming in supporting the faculty and administration for development and progressive functioning of the college. 
						<br>
						<br>
						I hope you will find the academic atmosphere of the college conducive for your future development as a professional as well as a human being. Once again, I welcome the students to this institution and look forward to their co-operation in the successful accomplishment of the achievement of the goals and objectives planned and foreseen by the college for its students. 
                    </div>
                </div>
                <!--END Page Body-->
            </div>
            <!--END Page Content Container-->
        </div>
        <!--End Bootstrap column-->
    </div>
    <!--END Bootstrap Row-->
</div>
<!--END Bootstrap Container-->
<?php
    //INCLUDE FOOTER CODE
    require("../templates/common/footer.php");
?>