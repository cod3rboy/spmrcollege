<?php
    //INCLUDE HEADER CODE
    $page_title = "Contact Us";
    require("../templates/common/header.php");
?>

<!--Bootstrap container-->
<div class="container">
    <!--Bootstrap ROW-->
    <div class="row">
        <div class="col-xs-12">
            <!--Page Content Container-->
            <div class="page-container" id="scroll-content">
                <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / Contact Us
                </div>
                <!--END Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <img class="img-responsive page-logo" alt="Contact us Icon" src="../images/contact.png">
                        <hr class="hr-divider"> 
                    <div class="row">
                        <!--Page Content Section-->
                        <div class="col-md-6 page-content" style="background-color:#FFFFFF;">
                            <!--Address and Contact Section-->
                            <div class="rel-container">

                                <address>
                                        <div class="lg-heading bar-header">
                                            <i class="fa fa-home" aria-hidden="true" style="font-size:30px;"></i> Address
                                        </div>
                                        <br>
                                        Govt. SPMR College of Commerce
                                        <br>Canal Road, Jammu Tawi, 
                                        <br>J&amp;K (India)
                                        <br>
                                        <br>
                                </address>
                                <hr>
                                <table class="tbl">
                                    <tr>
                                        <td class="tbl-item" style="text-align:center;"><span class="glyphicon glyphicon-phone-alt"></span></td>
                                        <td class="tbl-item"><a href="tel:01912544321">0191-2544321</a></td>
                                    </tr>
                                    <tr>
                                        <td class="tbl-item" style="text-align:center;"><span class="glyphicon glyphicon-print"></span></td>
                                        <td class="tbl-item"><a href="fax:01912544321">0191-2544321</a> (fax)</td>
                                    </tr>
                                    <tr>
                                        <td class="tbl-item" style="text-align:center;"><span class="glyphicon glyphicon-envelope"></span></td>
                                        <td class="tbl-item"><a href="mailto: principal.spmrcollege@gmail.com">principal.spmrcollege@gmail.com</a></td>
                                    </tr>
                                </table>
                            </div>
                            <!--END Address and Contact Section-->
                        </div>
                        <!--Page Content Section-->
                        <div class="col-md-6 page-content" style="background-color:#FFFFFF;">
                            <!--Map Section-->
                            <div class="rel-container">
                                <div class="lg-heading bar-header" style="text-align:center;">
                                    Locate Us <span class="glyphicon glyphicon-map-marker" style="font-size:30px;"></span> On Map
                                    <br>
                                </div>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13425.880327623865!2d74.8525116!3d32.7267063!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xba1b3f6b587b1e91!2sGovt.+S.P.M.R+College+of+Commerce!5e0!3m2!1sen!2sin!4v1490272553100" frameborder="0" class="map"></iframe>
                            </div>
                            <!--END Map Section-->
                        </div>
                    </div>
                </div>
                <!--END Page Body-->
            </div>
            <!--END Page Content Container-->
        </div>
    </div>
    <!--END Bootstrap ROW-->
</div>
<!--END Bootstrap container-->

<?php
    //INCLUDE FOOTER CODE
    require("../templates/common/footer.php");
?>
