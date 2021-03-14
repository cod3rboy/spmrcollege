<?php
    //Specify Page Title
    $page_title = "Facilities";
    //INCLUDE HEADER CODE
    require("../templates/common/header.php");
?>
<!--Bootstrap Container-->
<div class="container">
	<!--Bootstrap Row-->
	<div class="row">
		<div class="col-xs-12">
			<!--Page Content Container-->
			<div class="page-container" id="scroll-content">
				<!--Page Header-->
                <div class="page-header"><a class="page-header-link" href="index.php">Home</a> / Facilities</div>
				<!--END Page Header-->
				<!--Page Body-->
				<div class="page-body">
                    <table style="font-size:20px;width:100%;">
                        <tr style="background-color:#CCCCCC;">
                            <td style="padding:10px;">
                                <a href="academicfacilities.php">
                                    <span class="glyphicon glyphicon-share-alt"></span> Academic Facilities 
                                </a>
                            </td>
                        </tr>
                        <tr style="background-color:#DDDDDD;">
                            <td style="padding:10px;">
                                <a href="infrastructure.php">
                                    <span class="glyphicon glyphicon-share-alt"></span> Infrastructure
                                </a>
                            </td>
                        </tr>
                    </table>
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
    //INCLUDE FOOTER CODE
    require("../templates/common/footer.php");
?>