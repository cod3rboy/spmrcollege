<?php
// Set this variable to page title (No title if not set)
$page_title = "Principal Info";
// Include Admin Panel header
require('../templates/admin/header.php');
?>
<script>
    function validateName(e, t){
        try {
            if (window.event) {
                var charCode = window.event.keyCode;
            }
            else if (e) {
                var charCode = e.which;
            }
            else { return true; }
            if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode==46) || (charCode==32))
                return true;
            else
                return false;
        }
        catch (err) {
            alert(err.Description);
        }
    }
    function validate(){
        var name = document.getElementById("name").value.trim();
        if(name.length == 0){
            window.alert("Name is empty!");
            return false;
        }
    }
    function validatePrincipal{
        var name = document.getElementById("old_principal_name").value.trim();
        var end = document.getElementById("end_year").value.trim();
        var start = document.getElementById("start_year").value.trim();

        if(name.length == 0){
            window.alert("Former principal name is empty!");
            return false;
        }
        if(end.length == 0){
            window.alert("Service End year is empty!");
            return false;
        }
        if(start.length == 0){
            window.alert("Service Start year is empty!");
        }

        if(start > <?php echo date("Y"); ?> || start < 1900 ){
            window.alert("Service Start Year Range is 1900 <?php echo date("Y"); ?> ");
            return false;
        }
        if(end > <?php echo date("Y"); ?> || end < 1900 ){
            window.alert("Service End Year Range is 1900 <?php echo date("Y"); ?> ");
            return false;
        }
        return true;
    }
</script>
<!-- Main Content -->
<section class="content">
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        // When Update Principal Form is submitted
        if(isset($_POST['update']) && isset($_POST['principal_name']) && isset($_FILES['principal_photo'])){
            $name = $_POST['principal_name']; // Get Principal name
            $image = $_FILES['principal_photo']['tmp_name']; // Get Photo of Principal
            define("WIDTH", 200); // Define default width
            define("HEIGHT", 216); // Define default height
            // Validation begins
            $is_everything_ok = true;
            $msg_array = array();

            // File Type Validation
            $image_formats = array( // Allowed Image Formats
                "image/jpeg"
            );
            $image_type = strtolower($_FILES['principal_photo']['type']);
            if (!in_array($image_type, $image_formats)) {
                $is_everything_ok = false;
                array_push($msg_array, "Image is of invalid type!");
            }

            // File size Check
            $image_file_size = $_FILES['principal_photo']['size'];
            define('KB', 1048);
            if($image_file_size > 100*KB){
                $is_everything_ok = false;
                array_push($msg_array, "Image File exceeded maximum size of 100 KB");
            }

            // Image Dimensions Check(After all validation successful we can ensure that file is a valid image and now we check its dimensions)
            if($is_everything_ok){
                if(getimagesize($image)[0] != WIDTH || getimagesize($image)[1] != HEIGHT){
                    $is_everything_ok = false;
                    array_push($msg_array, "Image must be of dimensions " . WIDTH . " (W) x " . HEIGHT . " (H)");
                }
            }

            if (!$is_everything_ok) {
                echo "<div class=\"callout callout-warning\">";
                echo "<ul>";
                foreach ($msg_array as $msg) {
                    echo "<li>$msg</li>";
                }
                echo "</ul>";
                echo "<h5>Note : Read instructions before uploading principal photo.</h5>";
                echo "</div>";
            } else {
                // Start Updating Principal info here
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $upload_path = "../images/principal.jpg";
                    $name = mysqli_real_escape_string($clgdb->conn, $name);
                    $query = "";
                    $has_record = $clgdb->executeSql("SELECT * FROM tbl_principal;")->num_rows;
                    if($has_record){
                        $query = "UPDATE tbl_principal SET name=\"$name\" ;";
                    }else{
                        $query = "INSERT into tbl_principal (name, pic_path) VALUES (\"$name\", \"$upload_path\") ;";
                    }
                    $clgdb->executeSql($query);
                    if(mysqli_affected_rows($clgdb->conn) != -1){
                        move_uploaded_file($image, $upload_path);
                        echo "<div class=\"callout callout-success\"><p>Principal Info Changed!</p></div>";
                    }
                    $clgdb->disconnect();
                }
            }
        }

        // When Add Former Principal Form is submitted
        if(isset($_POST['formersubmit']) && isset($_POST['old_principal']) && isset($_POST['service_start']) && isset($_POST['service_end'])){
            $name = $_POST['old_principal'];
            $start_year = (int) $_POST['service_start'];
            $end_year = (int) $_POST['service_end'];

            $msg_array = array();
            $is_form_ok = true;
            //Validation
            if(strlen(trim($name)) == 0){
                $is_form_ok = false;
                array_push($msg_array, "Former principal name is empty");
            }

            if($start_year > ((int) date("Y")) or $start_year < 1900){
                $is_form_ok = false;
                array_push($msg_array, "Start Year is not in range (1900- ".date("Y").")");
            }
            if($end_year > ((int) date("Y")) or $end_year < 1900){
                $is_form_ok = false;
                array_push($msg_array, "End Year is not in range (1900- ".date("Y").")");
            }

            if(!$is_form_ok){
                echo "<div class=\"callout callout-warning\">";
                echo "<ul>";
                foreach ($msg_array as $msg) {
                    echo "<li>$msg</li>";
                }
                echo "</ul>";
                echo "</div>";
            }else{
                // Insert former principal record into database
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $name = mysqli_real_escape_string($clgdb->conn, $name);
                    $query = "INSERT INTO tbl_former_principals (name, service_start, service_end) VALUES(\"$name\", $start_year, $end_year) ; ";
                    $clgdb->executeSql($query);
                    if(mysqli_affected_rows($clgdb->conn) != -1){
                        echo "<div class=\"callout callout-success\"><p>Inserted former principal record!</p></div>";
                    }
                    $clgdb->disconnect();
                }
            }
        }
    }

    // Delete Former Principal Record
    if(isset($_GET['delete'])){
        $id = (int) $_GET['delete'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            $clgdb->executeSql("DELETE FROM tbl_former_principals WHERE id=$id ; ");
            $rows_affected_count = mysqli_affected_rows($clgdb->conn);
            if($rows_affected_count != 0 && $rows_affected_count != -1){
                echo "<div class=\"callout callout-danger\"><p>Former principal record deleted!</p></div>";
            }
            $clgdb->disconnect();
        }
    }
    ?>
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Principal Information</div></div>
                <div class="box-body">
                    <?php
                        // Query Principal Information
                        $principal_name = "";
                        $principal_photo = "";
                        $clgdb->connect();
                        if($clgdb->isConnected()){
                            $has_record = $clgdb->executeSql("SELECT * from tbl_principal;")->num_rows;
                            if($has_record){
                                $record = $clgdb->executeSql("SELECT name, pic_path FROM tbl_principal;");
                                while($row = $record->fetch_assoc()){
                                    $principal_name = $row['name'];
                                    $principal_photo = $row['pic_path'];
                                }
                                ?>
                                <div class="media">
                                    <div class="media-left">
                                        <img src="<?php echo $principal_photo."?t=".time();?>" class="media-object" alt="Principal Photo" style="height:120px;">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $principal_name;?></h4>
                                        <p>( Principal )</p>
                                    </div>
                                </div>
                                <?php
                            }else{
                                echo "<div style=\"color:#AAAAAA;font-size:14px;\"><i class=\"fa fa-info-circle\"></i> No Principal Information</div>";
                            }
                            $clgdb->disconnect();
                        }
                    ?>
                </div>
            </div>
        </div>
        <!--Change Principal Section-->
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Change Principal</div></div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="principal.php" enctype="multipart/form-data" onsubmit="return validate()" autocomplete="off">
                        <div class="form-group">
                            <label class="control-label col-md-2" for="name">Name</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="name" name="principal_name" maxlength="30" onkeypress="return validateName(event, this)" tabindex="1" placeholder="Enter Principal Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2" for="pic">Photo</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="pic" name="principal_photo" accept="image/jpeg" tabindex="2" required>
                                <button type="button" class="btn bg-blue btn-xs" data-toggle="modal" data-target="#instructionModal">See Instructions</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button type="submit" name="update" class="btn btn-success" tabindex="3">Update</button>
                            </div>
                        </div>
                    </form>
                    <div id="instructionModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="btn bg-red btn-sm pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                    <h4 class="modal-title">Instructions to upload principal photo</h4>
                                </div>
                                <div class="modal-body">
                                    Following instructions should be followed before uploading principal photo :-
                                    <ol>
                                        <li>Image type must be JPG/JPEG.</li>
                                        <li>Dimensions of the image should be 200(W) x 216(H).</li>
                                        <li>Image size should not exceed 100 KB.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Change Principal Section-->
    </div>
    <div class="row">
        <!--Add Former Principal Section-->
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Add Former Principal Record</div></div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="principal.php" onsubmit="return validatePrincipal()" autocomplete="off">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="old_principal_name">Principal Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="old_principal_name" name="old_principal" maxlength="100" tabindex="4" onkeypress="return validateName(event, this)" placeholder="Enter Principal Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-4" for="start_year">Service start year</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" id="start_year" name="service_start" maxlength="4" min="1900" max="<?php echo date("Y");?>" tabindex="5" placeholder="Enter Start Year" required>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="end_year">Service end year</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="end_year" name="service_end" maxlength="4" min="1900" max="<?php echo date("Y");?>" tabindex="6" placeholder="Enter End Year" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-success" tabindex="7" name="formersubmit">Insert</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Add Former Principal Section-->
        <!--Former Principal Records Section-->
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Former Principal Records</div></div>
                <div class="box-body">
                    <div style="min-height:100px;max-height:500px;overflow:auto;">
                        <ol>
                            <?php
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $query_records = "SELECT * FROM tbl_former_principals ORDER BY service_end DESC;";
                                $results = $clgdb->executeSql($query_records);
                                if(!$results->num_rows){
                                    echo "<div style=\"color:#AAAAAA;font-size:14px;\"><i class=\"fa fa-info-circle\"></i> No Record Found</div>";
                                }else{
                                    while($row = $results->fetch_assoc()){
                                        $name = $row['name'];
                                        $start = $row['service_start'];
                                        $end = $row['service_end'];
                                        $id = $row['id'];
                                        echo"
                                            <li><div style=\"font-size:14px;font-weight:bold;\">$name</div><small>( Service Start : $start | Service End : $end )</small><br><a class=\"btn bg-red btn-xs\" title=\"Delete Record\" href=\"?delete=$id\"><i class=\"fa fa-times\"></i></a></li>
                                            <br>
                                        ";
                                    }
                                }
                                $clgdb->disconnect();
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--End Former Principal Records Section-->
    </div>
</section>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>