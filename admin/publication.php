<?php
// Set this variable to page title (No title if not set)
$page_title = "Publication";
// Include Admin Panel header
require('../templates/admin/header.php');

// Define Zero Index
define("ZERO_INDEX", 0);
define("NEWSLETTER", 101);
define("PROSPECTUS", 102);
?>
    <script>
        function validateTitle(e, t){
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode >= 48 && charCode <= 57) || charCode==32 || (charCode==46))
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }
        function validate(){
            var title = document.getElementById("title").value.trim();
            if(title.length == 0){
                window.alert("Title is empty!");
                return false;
            }
            var category = parseInt(document.getElementById("category").value);
            if(category == <?php echo ZERO_INDEX; ?>){
                window.alert("Please select a category.");
                return false;
            }
            return true;
        }
    </script>
<!-- Main Content -->
<section class="content">
    <?php
    require('utilities.php');
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['upload']) && isset($_FILES['upload_doc']) && isset($_POST['file_title']) && isset($_POST['category'])) {
            // Select file name (in the filesystem)
            $file_name = $_FILES['upload_doc']['name'];
            // File name in the server temp directory after file uploaded
            $source_file = $_FILES['upload_doc']['tmp_name'];
            // File title entered by user
            $file_title = $_POST['file_title'];
            // Get the type of the file
            $file_type = strtolower($_FILES['upload_doc']['type']);
            // Get category of the file
            $file_category = (int) $_POST['category'];
            /* File Format Array
                PDF : application/pdf
                DOCX : application/vnd.openxmlformats-officedocument.wordprocessingml.document
            */
            $file_formats = array(
                "application/pdf",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            );

            $is_everything_ok = true;
            $msg_array = array();

            // File Type Validation
            if (!in_array($file_type, $file_formats)) {
                $is_everything_ok = false;
                array_push($msg_array, "File is of invalid type!");
            }

            // File size Check
            $file_size = $_FILES['upload_doc']['size'];
            define('MB', 1048576);
            if($file_size > 7*MB){
                $is_everything_ok = false;
                array_push($msg_array, "File exceeded maximum size of 7 MB");
            }

            // File name validation
            // Regex - start with any letter or number or space(file name) then dot(separator) then end with any letter(extension)
            $regex = "/^[0-9a-zA-Z ]+[.][a-zA-Z]+$/";
            if(!preg_match($regex, $file_name)){
                $is_everything_ok = false;
                array_push($msg_array, "Selected file has an invalid name");
            }

            // File Category Validation
            if($file_category != PROSPECTUS && $file_category != NEWSLETTER){
                $is_everything_ok = false;
                if($file_category == ZERO_INDEX){
                    array_push($msg_array, "Please Select a File Category!");
                }else{
                    array_push($msg_array, "File category is invalid!");
                }
            }

            if (!$is_everything_ok) {
                echo "<div class=\"callout callout-warning\">";
                echo "<ul>";
                foreach ($msg_array as $msg) {
                    echo "<li>$msg</li>";
                }
                echo "</ul>";
                echo "<h5>Note : Read instructions before uploading file.</h5>";
                echo "</div>";
            } else {
                // Start Uploading file here
                $clgdb->connect();
                if ($clgdb->isConnected()) {
                    $upload_directory = ($file_category == PROSPECTUS) ? "../publication/prospectus/" : "../publication/newsletter/";
                    if(!file_exists($upload_directory)) mkdir($upload_directory, 0777, true);
                    $name_array = explode('.', $file_name);
                    $md5_name = md5($name_array[0]). random_str(4, "123456789abcdefghijklmnopqrstuvwxyz"); // use 4-char salt to avoid same name conflict
                    $enc_file_name = $md5_name . "." . $name_array[1];
                    $upload_file = $upload_directory . $enc_file_name;
                    $file_title = mysqli_real_escape_string($clgdb->conn, $file_title);
                    $insert_query = "";
                    if($file_category == PROSPECTUS){
                        $insert_query = "INSERT INTO tbl_prospectus (title, link) VALUES ('$file_title', '$upload_file');";
                    }else{
                        $insert_query = "INSERT INTO tbl_newsletter (title, link) VALUES ('$file_title', '$upload_file');";
                    }
                    $clgdb->executeSql($insert_query);
                    if(mysqli_affected_rows($clgdb->conn) != -1){ // If database insertion is successful
                        //Now Copy File to upload directory and insert a database entry
                        move_uploaded_file($source_file, $upload_file);
                        echo "<div class=\"callout callout-success\"><p>File Uploaded Successfully!</p></div>";
                    }else{
                        echo "<div class=\"callout callout-danger\"><p>Failed to upload file</p></div>";
                    }
                    $clgdb->disconnect();
                }
            }
        }
    }


    // Delete Prospectus
    if(isset($_GET['delete_prospectus'])){
        $file_link = "";
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id = (int) $_GET['delete_prospectus'];
            $result = $clgdb->executeSql("SELECT link FROM tbl_prospectus WHERE id=$id ;");
            if($result && $result->num_rows){
                while($row = $result->fetch_assoc()){
                    $file_link = $row['link'];
                }
                $clgdb->executeSql("DELETE FROM tbl_prospectus WHERE id=$id ;");
                if(mysqli_affected_rows($clgdb->conn) != -1){
                    if(file_exists($file_link)){
                        unlink($file_link);
                    }
                    echo "<div class=\"callout callout-danger\"><p>Prospectus Deleted!</p></div>";
                }
            }
            $clgdb->disconnect();
        }
    }

    // Delete News Letter
    if(isset($_GET['delete_newsletter'])){
        $file_link = "";
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id = (int) $_GET['delete_newsletter'];
            $result = $clgdb->executeSql("SELECT link FROM tbl_newsletter WHERE id=$id ;");
            if($result && $result->num_rows){
                while($row = $result->fetch_assoc()){
                    $file_link = $row['link'];
                }
                $clgdb->executeSql("DELETE FROM tbl_newsletter WHERE id=$id ;");
                if(mysqli_affected_rows($clgdb->conn) != -1){
                    if(file_exists($file_link)){
                        unlink($file_link);
                    }
                    echo "<div class=\"callout callout-danger\"><p>News Letter Deleted!</p></div>";
                }
            }
            $clgdb->disconnect();
        }
    }
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Upload a Publication</div></div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" onsubmit="return validate()" autocomplete="off">
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label" for="title">File Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="title" name="file_title" maxlength="150" tabindex="1" placeholder="Enter File Title" onkeypress="return validateTitle(event, this)" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label" for="category">Category</label>
                            <div class="col-sm-8 col-md-4">
                                <select class="form-control" id="category" name="category" tabindex="2">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a Category</option>
                                    <option value="<?php echo PROSPECTUS; ?>">Prospectus</option>
                                    <option value="<?php echo NEWSLETTER; ?>">News Letter</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label" for="upload_file">Upload File</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="upload_file" name="upload_doc" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf" tabindex="3" required>
                                <button type="button" class="btn bg-blue btn-xs" data-toggle="modal" data-target="#instructModal">See Instructions</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3 col-md-offset-2">
                                <button type="submit" name="upload" class="btn btn-success" tabindex="4">Upload</button>
                            </div>
                        </div>
                    </form>
                    <div id="instructModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn bg-red btn-sm pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                    <h4>Instructions to upload file</h4>
                                </div>
                                <div class="modal-body">
                                    <h5>Following Instructions must be followed while uploading a file :-</h5>
                                    <ol>
                                        <li>Only PDF and DOCX file formats are allowed.</li>
                                        <li>File name should only contain letters and numbers.</li>
                                        <li>Maximum File size allowed is 7 MB.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Uploaded Prospectuses</div></div>
                <div class="box-body">
                    <?php
                    $clgdb->connect();
                    if($clgdb->isConnected()){
                        $results = $clgdb->executeSql("SELECT id, title, link, UNIX_TIMESTAMP(time_stamp) AS upload_timestamp FROM tbl_prospectus ORDER BY time_stamp DESC;");
                        if($results && $results->num_rows){
                            echo "<div style=\"max-height:300px; overflow:auto; overflow-x: hidden;\">";
                            echo "<ol>";
                            while($row = $results->fetch_assoc()){
                                $file_id = $row['id'];
                                $file_title = $row['title'];
                                $file_link = $row['link'];
                                $upload_date = date("d-M-Y h:i A", $row['upload_timestamp']);
                                echo "
                            <li>
                                <div style=\"font-size:14px;font-weight:bold;\">$file_title</div>
                                <small>$upload_date</small><br>
                                <a class=\"btn bg-green btn-xs\" target=\"_blank\" href=\"$file_link\" title=\"Download\"><i class=\"fa fa-download\"></i></a>
                                <a class=\"btn bg-red btn-xs\" href=\"?delete_prospectus=$file_id\" title=\"Delete\"><i class=\"fa fa-times\"></i></a>
                            </li>";
                            }
                            echo "</ol>";
                            echo "</div>";
                        }else{
                            echo "<div style=\"font-size:16px;color:#AAAAAA;\"><i class=\"fa fa-info-circle\"></i> No Prospectus Uploaded!</div>";
                        }
                        $clgdb->disconnect();
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Uploaded News Letters</div></div>
                <div class="box-body">
                    <?php
                    $clgdb->connect();
                    if($clgdb->isConnected()){
                        $results = $clgdb->executeSql("SELECT id, title, link, UNIX_TIMESTAMP(time_stamp) AS upload_timestamp FROM tbl_newsletter ORDER BY time_stamp DESC;");
                        if($results && $results->num_rows){
                            echo "<div style=\"max-height:300px; overflow:auto; overflow-x: hidden;\">";
                            echo "<ol>";
                            while($row = $results->fetch_assoc()){
                                $file_id = $row['id'];
                                $file_title = $row['title'];
                                $file_link = $row['link'];
                                $upload_date = date("d-M-Y h:i A", $row['upload_timestamp']);
                                echo "
                            <li>
                                <div style=\"font-size:14px;font-weight:bold;\">$file_title</div>
                                <small>$upload_date</small><br>
                                <a class=\"btn bg-green btn-xs\" target=\"_blank\" href=\"$file_link\" title=\"Download\"><i class=\"fa fa-download\"></i></a>
                                <a class=\"btn bg-red btn-xs\" href=\"?delete_newsletter=$file_id\" title=\"Delete\"><i class=\"fa fa-times\"></i></a>
                            </li>";
                            }
                            echo "</ol>";
                            echo "</div>";
                        }else{
                            echo "<div style=\"font-size:16px;color:#AAAAAA;\"><i class=\"fa fa-info-circle\"></i> No News Letter Uploaded!</div>";
                        }
                        $clgdb->disconnect();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>