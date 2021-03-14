<?php
// Set this variable to page title (No title if not set)
$page_title = "Downloads";
// Include Admin Panel header
require('../templates/admin/header.php');
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
        return true;
    }
</script>

<section class="content">
    <?php
    require('utilities.php');
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['upload']) && isset($_POST['file_desc']) && isset($_FILES['upload_doc']['tmp_name'])) {
            // Select file name (in the filesystem)
            $file_name = $_FILES['upload_doc']['name'];
            // File name in the server temp directory after file uploaded
            $source_file = $_FILES['upload_doc']['tmp_name'];
            // File description entered by user
            $file_description = $_POST['file_desc'];
            // Get the type of the file
            $file_type =  $_FILES['upload_doc']['type'];
            /* File Format Array
                PDF : application/pdf
                DOCX : application/vnd.openxmlformats-officedocument.wordprocessingml.document
                JPG : image/jpeg
                JPEG : image/jpeg
            */
            $file_formats = array(
                "application/pdf",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                "image/jpeg"
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
            if($file_size > 4*MB){
                $is_everything_ok = false;
                array_push($msg_array, "File exceeded maximum size of 4MB");
            }

            // File name validation
            // Regex - start with any letter or number or space(file name) then dot(separator) then end with any letter(extension)
            $regex = "/^[0-9a-zA-Z ]+[.][a-zA-Z]+$/";
            if(!preg_match($regex, $file_name)){
                $is_everything_ok = false;
                array_push($msg_array, "Selected file has an invalid name");
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
                    $upload_directory = "../files/";
                    if(!file_exists("../files/")) mkdir("../files/",0777, true);
                    $name_array = explode('.', $file_name);
                    $md5_name = md5($name_array[0]). random_str(4, "123456789abcdefghijklmnopqrstuvwxyz"); // use 4-char salt to avoid same name conflict
                    $enc_file_name = $md5_name . "." . strtolower($name_array[1]);
                    $upload_file = $upload_directory . $enc_file_name;
                    $file_description = mysqli_real_escape_string($clgdb->conn, $file_description);
                    $insert_query = "INSERT INTO tbl_download (filename, filedesc, link) VALUES ('$enc_file_name', '$file_description', '$upload_file');";
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

    // Delete a file from download list
    if(isset($_GET['delete'])){
        $file_link = "";
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id = (int) $_GET['delete'];
            $result = $clgdb->executeSql("SELECT link FROM tbl_download WHERE id=$id ;");
            if($result && $result->num_rows){
                while($row = $result->fetch_assoc()){
                    $file_link = $row['link'];
                }
                $clgdb->executeSql("DELETE FROM tbl_download WHERE id = $id ;");
                $affected_rows = mysqli_affected_rows($clgdb->conn);
                if($affected_rows != -1 && $affected_rows != 0){
                    if(file_exists($file_link)){
                        unlink($file_link);
                    }
                    echo "<div class=\"callout callout-danger\"><p>File Deleted!</p></div>";
                }
            }
            $clgdb->disconnect();
        }
    }
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box box-header">
                    <div class="box-title">Upload a Document</div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" onsubmit="return validate()" autocomplete="off">
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label" for="title">File Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="title" name="file_desc" maxlength="150" tabindex="1" placeholder="Enter File Title" onkeypress="return validateTitle(event, this)" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label" for="upload_file">Upload File</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="upload_file" name="upload_doc" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/jpeg" tabindex="2" required>
                                <button type="button" class="btn bg-blue btn-xs" data-toggle="modal" data-target="#instructModal">See Instructions</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3 col-md-offset-2">
                                <button type="submit" name="upload" class="btn btn-success" tabindex="3">Upload</button>
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
                                        <li>Only PDF, DOCX, JPEG and JPG file formats are allowed.</li>
                                        <li>File name should only contain letters and numbers.</li>
                                        <li>Maximum File size allowed is 4 MB.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-title">All Uploaded Files</div>
                </div>
                <div class="box-body">
                    <?php
                    // Declaring Pagination variable
                    // Tracks current page number initially set to first page
                    $current_page = 1;
                    // Stores no of records to display per page
                    $per_page = 10;
                    // Stores total no of pages required to display all records
                    $total_pages = 1;
                    // Defining Button State Constants
                    define('BUTTON_ON', 1);
                    define('BUTTON_OFF', 2);
                    // Declaring booleans to store the next / prev buttons state
                    // Both initially set to off state
                    $next_btn_state = BUTTON_OFF;
                    $prev_btn_state = BUTTON_OFF;
                    $clgdb->connect();
                    if($clgdb->isConnected()) { // If connected to database
                        // Query String to get total records in the downloads table
                        $total_rec_query = "SELECT * FROM tbl_download;";
                        // Execute query and get no of rows
                        $total_rec = $clgdb->executeSql($total_rec_query)->num_rows;
                        if ($total_rec == 0) { //If there is no row i.e. no record found
                            //Display No Records Found
                            $msg_string = "<h5>No file uploaded yet!</h5>";
                            echo $msg_string;
                        } else { //If there are records in the downloads table
                            //Calculate no of pages required to display all records
                            $total_pages = ceil($total_rec / $per_page);
                            if (isset($_GET['page'])) { // If Get variable exists
                                $page_value = (int)$_GET['page']; // Get value from variable
                                if ($page_value > $total_pages || $page_value < 1) { // If value is invalid
                                    $current_page = 1;
                                } else { // if value is valid
                                    $current_page = $page_value;
                                }
                            }
                            // Calculate offset
                            // Offset = previous page * per page limit
                            $offset = ($current_page - 1) * $per_page;
                            // SQL Query to load download items from database with limit and offset
                            $query = "SELECT id, filedesc, link, UNIX_TIMESTAMP(time_stamp) AS dated FROM tbl_download ORDER BY time_stamp DESC LIMIT $per_page OFFSET $offset;";
                            // Execute Query
                            $results = $clgdb->executeSql($query);
                            echo "<ol>";
                            while ($tupple = $results->fetch_assoc()) {
                                $id = $tupple['id']; // file Id
                                $file_desc = $tupple['filedesc']; // file description
                                $link =  $tupple['link']; // file Link
                                $time_stamp = $tupple['dated']; // upload Timestamp
                                $formatted_date = date("d-M-Y", $time_stamp);
                                $formatted_time = date("h:i A", $time_stamp);
                                $formatted_time_stamp = "Dated : $formatted_date at $formatted_time";
                                echo "
                            <li>
                                <div style=\"font-size:14px;font-weight:bold;\">$file_desc</div>
                                <small>$formatted_time_stamp</small><br>
                                <a class=\"btn bg-green btn-xs\" target=\"_blank\" href=\"$link\" title=\"Download\"><i class=\"fa fa-download\"></i></a>
                                <a class=\"btn bg-red btn-xs\" href=\"?delete=$id\" title=\"Delete\"><i class=\"fa fa-times\"></i></a>
                            </li>";
                            }
                            echo "</ol>";
                            // Setting Next and Prev Button States
                            $next_btn_state = ($total_pages > 1 && $current_page < $total_pages) ? BUTTON_ON : BUTTON_OFF;
                            $prev_btn_state = ($total_pages > 1 && $current_page > 1) ? BUTTON_ON : BUTTON_OFF;
                            // Set Next and Prev Button Properties based on state
                            $prev_btn_properties = ($prev_btn_state == BUTTON_ON) ? "class=\"btn bg-gray btn-sm\" href=\"?page=".($current_page-1)."\"": "hidden";
                            $next_btn_properties = ($next_btn_state == BUTTON_ON) ? "class=\"btn bg-gray btn-sm\" href=\"?page=".($current_page+1)."\"" : "hidden";
                            echo "<div class=\"pull-right\">";
                            echo "<a $prev_btn_properties><i class=\"fa fa-chevron-left\"></i></a>";
                            echo "<span style=\"margin-left:5px;margin-right:5px;\">Page $current_page - $total_pages</span>";
                            echo "<a $next_btn_properties><i class=\"fa fa-chevron-right\"></i></a>";
                            echo "</div>";
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