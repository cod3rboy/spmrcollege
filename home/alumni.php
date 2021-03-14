<?php
// Setting page title
$page_title = "Our Alumni";
//Include Header Code
require('../templates/common/header.php');

// PHP trigger to show registration form modal
// By default registration form is not displayed
$show_registration_modal = false;
// Image dimensions need to upload photograph while alumni registration
$img_width = 120;
$img_height = 150;
// Defining minimum and maximum year constants (For Batch Year Validation)
$min_batch_year = 1950;
$max_batch_year = (int) date("Y");
//Defining Zero Index constant (For registration ComboBox)
define('ZERO_INDEX', "0");
//Declaring Associative Array for Stream Combo Box (Drop Down)
$stream_arr = array(
    "bcom" => "B.Com.",
    "bcomhons" => "B.Com. Hons.",
    "bca" => "B.C.A.",
    "bba" => "B.B.A.",
    "mcom" => "M.Com.",
    "pgdbm" => "PGDBM"
);
?>
<script>
    // Name Validation Function
    function validateName(e, t){
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
    // Number Validation Function
    function validateNumber(e, t){
        try {
            if (window.event) {
                var charCode = window.event.keyCode;
            }
            else if (e) {
                var charCode = e.which;
            }
            else { return true; }
            if (charCode >= 48 && charCode <= 57)
                return true;
            else
                return false;
        }
        catch (err) {
            alert(err.Description);
        }
    }
    // Alumni Form Validation Function
    function validateAlumniForm(){
        var name = document.getElementById("name").value;
        if(name.trim().length == 0){
            window.alert("Name cannot be empty");
            return false;
        }
        var stream = document.getElementById("stream").value;
        if(stream == <?php echo ZERO_INDEX; ?>){
            window.alert("Please select a stream");
            return false;
        }
        var batch_year = parseInt(document.getElementById("batch").value);
        if(batch_year > <?php echo $max_batch_year;?> || batch_year < <?php echo $min_batch_year; ?>){
            window.alert("Batch year should be between <?php echo $min_batch_year; ?> and <?php echo $max_batch_year; ?>");
            return false;
        }
        var contactNumber = document.getElementById("contact-number").value;
        if(contactNumber.trim().length != 10){
            window.alert("Please enter a valid contact number.");
            return false;
        }
        var address = document.getElementById("address").value;
        if(address.trim().length == 0){
            window.alert("Please enter your address");
            return false;
        }
        return true;
    }
    // Photo Upload Instruction Function
    function photoUploadInstruct(){
        window.alert("Photo Upload Instructions :-" +
            "\n1. Only JPG/JPEG images are allowed." +
            "\n2. Image size should not exceed 500 KB." +
            "\n3. Image must have dimensions 120 (W) x 150 (H)");
    }
</script>
<!--Bootstrap Container-->
<div class="container">
    <!--Bootstrap Row-->
    <div class="row">
        <!--Bootstrap Column-->
        <div class="col-xs-12">
            <!--Page Content Container-->
            <div class="page-container" id="scroll-content">
                <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / Our Alumni
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Page Logo-->
                    <img class="img-responsive page-logo" alt="graduates image" src="../images/grads.png">
                    <hr class="hr-divider">
                    <!--Bootstrap Row-->
                    <div class="row">
                        <!--Our Alumni Title Column-->
                        <div class="col-xs-6">
                            <div class="lg-heading"><i class="fa fa-users hidden-xs"  aria-hidden="true"></i> Our Alumni</div>
                        </div>
                        <!--Register Button Column-->
                        <div class="col-xs-6 col-sm-3 col-lg-2 pull-right">
                            <div class="lg-heading"><a class="green-btn" data-toggle="modal" data-target="#registerModal" href="#"><i class="fa fa-user-plus " aria-hidden="true"></i> Register</a></div>
                        </div>
                        <!--Bootstrap Dialog for Alumni Registration-->
                        <div id="registerModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <!--Close Button-->
                                        <button type="button" data-dismiss="modal" class="close" onclick="window.location.href='alumni.php';">Close <i class="fa fa-close" aria-hidden="true"></i></button>
                                        <!--Dialog Title-->
                                        <h4 class="modal-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Alumni Registration</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info">Fields without <strong>(*)</strong> sign are optional.</div>
                                        <?php
                                        // Import Utilities File
                                        require("../admin/utilities.php");
                                        if(isset($_POST['submitted']) && isset($_POST['name']) && isset($_POST['stream']) && isset($_POST['batch']) && isset($_POST['empstatus']) && isset($_POST['contact']) && isset($_POST['emailaddress']) && isset($_POST['address']) && isset($_FILES['photograph'])) { // When registration form is submitted
                                            // Set modal trigger
                                            $show_registration_modal = true;
                                            // Get registration form data
                                            $reg_name = $_POST['name']; // Person Name
                                            $reg_stream = $_POST['stream']; // Stream Selected (key)
                                            $batch_year = (int) $_POST['batch']; // Batch Year
                                            $emp_status = $_POST['empstatus']; // Employment status can be empty
                                            $contact_no = $_POST['contact']; // Contact Number
                                            $email = $_POST['emailaddress']; // Email address can be empty
                                            $address = $_POST['address']; // Residential Address
                                            $photograph_path = $_FILES['photograph']['tmp_name']; // Photograph can be empty

                                            // This Flag indicates whether form data is valid or invalid
                                            // Initially it is set to true ( Assuming Form data is valid)
                                            $form_valid_data = true;

                                            // Information and Error Messages array
                                            $messages = array();
                                            /*ERROR MESSAGES Mechanism
                                                At each test point there is either an error message or not
                                                At the end of all test points this array will hold all messages
                                                that will be displayed to the user.
                                            */
                                            // All Error Messages

                                            // Data Validation Test Points
                                            // Test name input
                                            if(0 == strlen(trim($reg_name))){
                                                // oops user has entered an empty name
                                                $form_valid_data = false;
                                                array_push($messages, "Name cannot be empty");
                                            }
                                            // Test stream Input
                                            if($reg_stream === ZERO_INDEX){
                                                // User did not select a value from stream combo box
                                                $form_valid_data = false;
                                                array_push($messages, "Please select a stream");
                                            }else if (!array_key_exists($reg_stream, $stream_arr)){
                                                // User selected an invalid value
                                                $form_valid_data = false;
                                                array_push($messages, "Invalid stream is selected");
                                            }
                                            // Test Batch Year Input
                                            if($batch_year > $max_batch_year){
                                                // Batch Year value exceeds max batch year
                                                $form_valid_data = false;
                                                array_push($messages, "Batch year cannot exceed ".$max_batch_year);
                                            }else if($batch_year < $min_batch_year){
                                                // Batch Year value is less than min batch year
                                                $form_valid_data = false;
                                                array_push($messages, "Batch Year cannot be less than ".$min_batch_year);
                                            }

                                            // Check Employment Status value
                                            if(0 == strlen(trim($emp_status))){
                                                // Set default employment status value
                                                $emp_status = "N/A";
                                            }
                                            // Test Contact Number
                                            if(10 > strlen(trim($contact_no)) || 10 < strlen(trim($contact_no))){
                                                // Invalid Contact Number
                                                $form_valid_data = false;
                                                array_push($messages, "Number of digits in contact number is not 10");
                                            }
                                            // Check Email Address Value
                                            if(0 == strlen(trim($email))){
                                                // If email address is not entered
                                                $email = "N/A";
                                            }else if (strpos($email, '@') == false){
                                                // Invalid Email Address
                                                $form_valid_data= false;
                                                array_push($messages, "Email address entered is invalid");
                                            }
                                            // Test Address
                                            if(0 == strlen(trim($address))){
                                                // User did not entered email address
                                                $form_valid_data = false;
                                                array_push($messages, "Address cannot be empty");
                                            }
                                            // Test File
                                            if(empty($_FILES['photograph']['name'])){
                                                // When user did not uploaded a photo
                                                // Set the default photo to no photo
                                                $photograph_path = "../images/nophoto.png";
                                            }else{
                                                // Check file type and dimensions and Set the photo path to selected file path
                                                $mime_type = strtolower($_FILES['photograph']['type']);
                                                if($mime_type !== "image/jpg" && $mime_type !== "image/jpeg"){ //check file type
                                                    $form_valid_data = false;
                                                    array_push($messages, "Selected file is not jpg or jpeg image");
                                                }else if((getimagesize($photograph_path)[0] != $img_width) || (getimagesize($photograph_path)[1] != $img_height)){ // Check dimensions
                                                    $form_valid_data = false;
                                                    array_push($messages, "Image must be of dimensions $img_width(W) x $img_height(H)");
                                                }else if($_FILES['photograph']['size'] > (1024*500)){
                                                    $form_valid_data = false;
                                                    array_push($messages, "Exceeded maximum image size of 500 KB");
                                                }

                                            }


                                            if(!$form_valid_data){
                                                // If form data is invalid then display error messages
                                                echo "<div class=\"alert alert-danger\">";
                                                echo "<ul>";
                                                for($i=0; $i<count($messages); $i++){
                                                    echo "<li>$messages[$i]</li>";
                                                }
                                                echo "</ul>";
                                                echo "</div>";
                                            }else{
                                                // Form data is valid
                                                // Upload Photo if there is any
                                                if(!empty($img_name = $_FILES['photograph']['name'])){
                                                    $img_name = explode('.', $img_name);
                                                    $img_name = md5($img_name[0]).random_str(4, "0123456789abcdefghijklmnopqrstuvwxyz").".".$img_name[1];
                                                    $target_path = '../alumni_photos/'.$img_name;
                                                    move_uploaded_file($photograph_path, $target_path);
                                                    $photograph_path = $target_path;
                                                }else{
                                                    $photograph_path = "../images/nophoto.png";
                                                }
                                                $clgdb->connect();
                                                if($clgdb->isConnected()){
                                                    // Insert data into database
                                                    // Insert Alumni Details Query
                                                    // MySql Filtering
                                                    $reg_name = mysqli_real_escape_string($clgdb->conn, $reg_name);
                                                    $batch_year = mysqli_real_escape_string($clgdb->conn, $batch_year);
                                                    $address = mysqli_real_escape_string($clgdb->conn, $address);
                                                    $contact_no = mysqli_real_escape_string($clgdb->conn, $contact_no);
                                                    $emp_status = mysqli_real_escape_string($clgdb->conn, $emp_status);
                                                    $email = mysqli_real_escape_string($clgdb->conn, $email);
                                                    $insert_query = "INSERT INTO tbl_alumni (name, stream, batch_year, address, contact_no, is_verified, current_status, email_id, photo_path)"
                                                        ." VALUES (\"$reg_name\", \"$stream_arr[$reg_stream]\", $batch_year, \"$address\", \"$contact_no\", 0, \"$emp_status\", \"$email\", \"$photograph_path\");";
                                                    $clgdb->executeSql($insert_query);
                                                    echo "<div class=\"alert alert-success\">Details are submitted successfully</div>";
                                                    $clgdb->disconnect();
                                                }else{
                                                    // Cannot Connect to the database for some reason
                                                    // Handle it here
                                                    echo "<div class=\"alert alert-danger\">Problem occurred while submitting details</div>";
                                                }
                                            }
                                        }
                                        ?>
                                        <!--Alumni Registration Form-->
                                        <form role="form" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" onsubmit="return validateAlumniForm();">
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="name" style="text-align:left;"><span style="font-family:serif;color:dodgerblue;">(*)</span> Name : </label>
                                                <div class="col-sm-7"><input type="text" id="name" name="name" class="form-control"  maxlength="50" onkeypress="return validateName(event, this);" placeholder="Enter name" required></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="stream" style="text-align:left;"><span style="font-family:serif;color:dodgerblue;">(*)</span> Stream : </label>
                                                <div class="col-sm-7">
                                                    <select id="stream" class="form-control" name="stream">
                                                        <option value="<?php echo ZERO_INDEX;?>">Select Stream</option>
                                                        <?php
                                                            // Generate Option Tags for each stream
                                                            foreach ($stream_arr as $key => $value){
                                                                echo "<option value=\"$key\">$value</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="batch" style="text-align:left;"><span style="font-family:serif;color:dodgerblue;">(*)</span> Batch Year : </label>
                                                <div class="col-sm-7"><input type="text" id="batch" class="form-control" name="batch" onkeypress="return validateNumber(event, this)" placeholder="Enter batch year" maxlength="4" required></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="status" style="text-align:left;">Employment Status : </label>
                                                <div class="col-sm-7"><input type="text" id="status" class="form-control" maxlength="100" name="empstatus" placeholder="Enter your employment status"><small>(Empty if not Employed)</small></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="contact-number" style="text-align:left;"><span style="font-family:serif;color:dodgerblue;">(*)</span> Contact No. : </label>
                                                <div class="col-sm-7"><input type="text" id="contact-number" class="form-control" maxlength="10" name="contact" onkeypress="return validateNumber(event, this)" placeholder="Enter contact number" required></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="email-id" style="text-align:left;">Email : </label>
                                                <div class="col-sm-7"><input type="email" id="email-id" class="form-control" maxlength="100" name="emailaddress" placeholder="Enter email address"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="address" style="text-align:left;"><span style="font-family:serif;color:dodgerblue;">(*)</span> Address : </label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" style="resize: none;" id="address" maxlength="200" name="address" placeholder="Enter Address" rows="4" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="upload-photo"  style="text-align:left;">Photograph : </label>
                                                <div class="col-sm-7">
                                                    <input type="file" class="form-control" name="photograph" id="upload-photo">
                                                    <button type="button" class="btn btn-primary btn-xs" onclick="photoUploadInstruct();">See Instructions</button>
                                                </div>
                                            </div>
                                            <button type="submit" name="submitted" class="form-control btn btn-success">Register <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                                        </form>
                                        <!--End Alumni Registration Form-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Bootstrap Row-->
                    <hr>
                    <!--Bootstrap Row-->
                    <div class="row">
                        <?php
                            // Generate Alumni Records Cards in 1:1 Column Ratio in Big Screen and Display in Stack in Small Screen
                            $total_recs_query = "SELECT * FROM tbl_alumni WHERE is_verified=1;";
                            // Connect to Database
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                // Get Total Number of verified Alumni Records
                                $total_recs = $clgdb->executeSql($total_recs_query)->num_rows;
                                if($total_recs == 0){ // If there is no record
                                    // Display No Records
                                    echo "<div class=\"col-xs-12\">
                                          <div class=\"page-content\">
                                              <div class=\"lg-heading\" style=\"color:#AAAAAA;text-align:center;\">
                                               No Record Found!
                                               </div>
                                            </div>
                                       </div>";
                                }else{
                                    // Setup a Pagination

                                    // Constants to represent on off state of next / prev buttons
                                    define("BUTTON_ON", 1);
                                    define("BUTTON_OFF", 0);
                                    // Variables to handle on/off of prev / next buttons
                                    //Initially Both Buttons are off and are set when there
                                    // is some record in the gallery table
                                    $prev_btn_state = BUTTON_OFF;
                                    $next_btn_state = BUTTON_OFF;
                                    //  Do pagination
                                    $per_page = 8; // Max Records per page
                                    $total_pages = ceil($total_recs / $per_page); // Calculate Required pages to display all records
                                    $current_page = 1; // Keeps track of Current Page
                                    if(isset($_GET['page'])){ // If Page Variable is set
                                        $page_value = (int) $_GET['page']; // Get the page number
                                        if($page_value > $total_pages || $page_value < 1){ // Check Whether page number is valid
                                            $current_page = 1; // Set to first page if page number is invalid
                                        }else{
                                            $current_page = $page_value; // Set to the page number
                                        }
                                    }
                                    // Calculate Offset from which we need to start fetching records
                                    $offset = ($current_page - 1) * $per_page;
                                    // Query to get limited records from the Database in the Desc order by batch year and nested Asc order by Name.
                                    $verified_recs_query = "SELECT * FROM tbl_alumni WHERE is_verified=1 ORDER BY batch_year DESC, name ASC  LIMIT $per_page OFFSET $offset;";
                                    $results = $clgdb->executeSql($verified_recs_query);
                                    while($row = $results->fetch_assoc()){
                                        $name = $row['name'];
                                        $stream = $row['stream'];
                                        $batch = $row['batch_year'];
                                        $res_address = $row['address'];
                                        $contact = $row['contact_no'];
                                        $current_status = $row['current_status'];
                                        $email_id = $row['email_id'];
                                        $photo_path = $row['photo_path'];
                                        // Generate a Alumni Record Card Panel (6 Size Column on big screen)
                                        echo "
                                           <div class=\"col-md-6\">
                                                <div class=\"person-info-panel\">
                                                    <div class=\"media\">
                                                        <div class=\"media-left\">
                                                            <img src=\"$photo_path\" alt=\"Alumni Contact Picture\" class=\"media-object profile-pic\">
                                                        </div>
                                                        <div class=\"media-body\">
                                                            <div class=\"media-heading\">
                                                                <strong>$name</strong>
                                                            </div>
                                                            <div class=\"info-panel-text\"><strong>Stream : </strong>$stream ($batch)</div>
                                                            <div class=\"info-panel-text\"><strong>Status : </strong>$current_status</div>
                                                            <div class=\"info-panel-text\"><strong>Contact : </strong>+91-$contact</div>
                                                            <div class=\"info-panel-text\"><strong>Email : </strong>$email_id</div>
                                                            <div class=\"info-panel-text\"><strong>Address : </strong>$res_address</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            ";
                                    }
                                    // Set Next previous buttons state
                                    $next_btn_state = ($current_page >=1 and $current_page < $total_pages) ? BUTTON_ON : BUTTON_OFF;
                                    $prev_btn_state = ($current_page > 1 and $current_page <= $total_pages) ? BUTTON_ON : BUTTON_OFF;

                                    // Set Next / Prev Buttons properties based on Button State
                                    $prev_btn_properties = ($prev_btn_state == BUTTON_ON) ? "class=\"pagination-btn\" href=\"alumni.php?page=".($current_page-1)."\"": "class=\"pagination-btn-disabled\"";
                                    $next_btn_properties = ($next_btn_state == BUTTON_ON) ? "class=\"pagination-btn\" href=\"alumni.php?page=".($current_page+1)."\"" : "class=\"pagination-btn-disabled\"";

                                    // Display Page status and Prev/Next Buttons
                                    echo"<div class=\"row\">
                                            <div class=\"col-xs-12 md-heading text-center\">Page $current_page of $total_pages<br><br></div>
                                         </div>
                                         <div class=\"row\">
                                            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 col-sm-offset-2 col-md-offset-3 col-lg-offset-4\">
                                                <a $prev_btn_properties>
                                                    <i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i> Prev
                                                </a>
                                                
                                            </div>
                                            <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2\">
                                                <a $next_btn_properties>
                                                    Next <i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i>
                                                </a>
                                            </div>
                                     </div>";
                                }
                                // Disconnect from database
                                $clgdb->disconnect();
                            }
                        ?>
                    </div>
                    <!--End Bootstrap Row-->
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
<?php
// Trigger registration modal here
if($show_registration_modal){
    echo '<script>$(\'#registerModal\').modal(\'show\');</script>';
}
//Include Footer Code
require('../templates/common/footer.php');
?>
