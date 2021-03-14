<?php
// Set this variable to page title (No title if not set)
$page_title = "Faculty";
// Include Admin Panel header
require('../templates/admin/header.php');

// Zero Index Value
define("ZERO_INDEX", 0);
// Staff Categories
define("GAZETTED_INDEX", 101);
define("NON_GAZETTED_INDEX", 102);
define("DEPUT_INDEX", 103);
$staff_category = array(
    GAZETTED_INDEX => "Gazetted",
    NON_GAZETTED_INDEX => "Non-Gazetted",
    DEPUT_INDEX => "Deputation"
);
?>
<script>
    function validateNewDeptForm(){
        var dept_name = document.getElementById("new_dept").value;
        if(dept_name.trim().length == 0){
            window.alert("Department name is empty!");
            return false;
        }
        return true;
    }
    function validateNewStaffForm(){
        var staffName = document.getElementById("staff_name").value;
        if(staffName.trim().length == 0){
            window.alert("Staff name is empty!");
            return false;
        }
        var categoryIndex = parseInt(document.getElementById("staff_category").value);
        if(categoryIndex == <?php echo ZERO_INDEX;?>){
            window.alert("Please select a staff category!");
            return false;
        }
        var departmentIndex = parseInt(document.getElementById("staff_dept").value);
        if(categoryIndex == <?php echo GAZETTED_INDEX; ?> && departmentIndex == <?php echo ZERO_INDEX;?>){
            window.alert("Please select a department!");
            return false;
        }
        var designation = document.getElementById("staff_designation").value;
        if(designation.trim().length == 0){
            window.alert("Designation is empty!");
            return false;
        }
        return true;
    }
    function validateTextbox(e, t){
        try {
            if (window.event) {
                var charCode = window.event.keyCode;
            }
            else if (e) {
                var charCode = e.which;
            }
            else { return true; }
            if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode==32 || (charCode==46))
                return true;
            else
                return false;
        }
        catch (err) {
            alert(err.Description);
        }
    }
    function toggleDepartment(){
        var selectedCategory = parseInt(document.getElementById("staff_category").value);
        var departmentBox = document.getElementById("dept_form_group");
        if(selectedCategory == <?php echo GAZETTED_INDEX; ?>){
            departmentBox.style.display = "block";
        }else{
            departmentBox.style.display = "none";
        }
    }
    function validateGetStaff(){
        var selectedCategory = parseInt(document.getElementById("category").value);
        if(selectedCategory == <?php echo ZERO_INDEX;?>){
            window.alert("Please select a staff category!");
            return false;
        }
        var selectedDepartment = parseInt(document.getElementById("department").value);
        if(selectedCategory == <?php echo GAZETTED_INDEX;?> && selectedDepartment == <?php echo ZERO_INDEX; ?>){
            window.alert("Please select a department!");
            return false;
        }
        return true;
    }
    function toggleDept(){
        var selectedCategory = parseInt(document.getElementById("category").value);
        var departmentBox = document.getElementById("form_department_group");
        if(selectedCategory == <?php echo GAZETTED_INDEX; ?>){
            departmentBox.style.display = "block";
        }else{
            departmentBox.style.display = "none";
        }
    }
</script>
<!-- Main Content -->
<section class="content">
    <?php
    require("utilities.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        // Add New Department
        if(isset($_POST['add_dept']) && isset($_POST['new_department'])){
            $new_dept_name = $_POST['new_department'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $new_dept_name = mysqli_real_escape_string($clgdb->conn, $new_dept_name);
                $clgdb->executeSql("INSERT INTO tbl_department (dept_name) VALUES (\"$new_dept_name\") ;");
                if(mysqli_affected_rows($clgdb->conn) != -1){
                    echo "<div class=\"callout callout-success\"><p>New Department Added!</p></div>";
                }
                $clgdb->disconnect();
            }
        }

        // Add New Staff Member
        if(isset($_POST['add_staff']) && isset($_POST['staff_name']) && isset($_POST['staff_category']) && isset($_POST['staff_dept']) && isset($_POST['staff_designation']) && isset($_FILES['staff_photo'])){
            $staff_name = $_POST['staff_name'];
            $staff_selected_category = (int) $_POST['staff_category'];
            $staff_department = (int) $_POST['staff_dept'];
            $staff_designation = $_POST['staff_designation'];
            $source_file = $_FILES['staff_photo']['tmp_name'];
            $staff_photo = $_FILES['staff_photo']['name'];
            $is_photo_uploaded = (strlen(trim($staff_photo)) != 0) ? true : false;
            // Validation
            $is_valid = true;
            $messages = array();

            // Photograph Validation
            if($is_photo_uploaded){
                $staff_photo_type = strtolower($_FILES['staff_photo']['type']);
                $staff_photo_size = $_FILES['staff_photo']['size'];
                define("PHOTO_WIDTH", 120);
                define("PHOTO_HEIGHT", 150);
                $image_format= array("image/jpeg");
                define("MB", (1024*1024));

                // Photo Type
                if(!in_array($staff_photo_type,$image_format)){
                    $is_valid = false;
                    array_push($messages, "Invalid Photograph Format!");
                }

                // Photo Size
                if($staff_photo_size > MB){
                    $is_valid = false;
                    array_push($messages, "Maximum photograph size exceeded!");
                }

                // File name validation
                // Regex - start with any letter or number or space(file name) then dot(separator) then end with any letter(extension)
                $regex = "/^[0-9a-zA-Z ]+[.][a-zA-Z]+$/";
                if(!preg_match($regex, $staff_photo)){
                    $is_valid = false;
                    array_push($messages, "Selected image file has an invalid name!");
                }

                // Image Dimensions and Name check (After all validation successful we can ensure that file is a valid image and now we check its dimensions)
                if($is_valid){
                    if(getimagesize($source_file)[0] != PHOTO_WIDTH || getimagesize($source_file)[1] != PHOTO_HEIGHT){
                        $is_valid = false;
                        array_push($messages, "Image must be of dimensions ".PHOTO_WIDTH." (W) x ".PHOTO_HEIGHT." (H)");
                    }
                }
            }
            // Validate Selected staff category
            if($staff_selected_category == ZERO_INDEX){
                $is_valid = false;
                array_push($messages, "Please select a staff category!");
            }
            elseif(!key_exists($staff_selected_category, $staff_category)){
                $is_valid = false;
                array_push($messages, "Selected staff category is invalid!");
            }else{
                if($staff_selected_category == GAZETTED_INDEX){
                    if($staff_department == ZERO_INDEX){
                        $is_valid = false;
                        array_push($messages, "Please select a department!");
                    }else{
                        $clgdb->connect();
                        if($clgdb->isConnected()){
                            $valid_dept = $clgdb->executeSql("SELECT * FROM tbl_department WHERE id = $staff_department ;")->num_rows;
                            if(!$valid_dept){
                                $is_valid = false;
                                array_push($messages, "Selected department is invalid!");
                            }
                            $clgdb->disconnect();
                        }
                    }
                }
            }

            if(!$is_valid){
                echo "<div class=\"callout callout-warning\">";
                echo "<ul>";
                foreach ($messages as $msg) {
                    echo "<li>$msg</li>";
                }
                echo "</ul>";
                echo "<h5>Note : Read instructions before uploading staff photograph.</h5>";
                echo "</div>";
            }else{
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $staff_name = mysqli_real_escape_string($clgdb->conn, $staff_name);
                    $staff_designation = mysqli_real_escape_string($clgdb->conn, $staff_designation);
                    $staff_photo_path = "";
                    if(!$is_photo_uploaded) {
                        $staff_photo_path = "../images/nophoto.png";
                    }else{
                        $upload_dir = "../faculty_photos/";
                        if(!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
                        $name_array = explode(".", $staff_photo);
                        $salt = random_str(6, "0123456789abcdefghijklmnopqrstuvwxyz");
                        $enc_photo_name = md5($name_array[0]).$salt.".".$name_array[1];
                        $staff_photo_path = $upload_dir.$enc_photo_name;
                    }
                    $query = "";
                    switch($staff_selected_category){
                        case NON_GAZETTED_INDEX:
                            $query = "INSERT INTO tbl_nongaz_staff (staff_name, designation, photo_path) VALUES(\"$staff_name\", \"$staff_designation\", \"$staff_photo_path\");";
                            break;
                        case DEPUT_INDEX:
                            $query = "INSERT INTO tbl_deput_staff (staff_name, designation, photo_path) VALUES(\"$staff_name\", \"$staff_designation\", \"$staff_photo_path\");";
                            break;
                        case GAZETTED_INDEX:
                            $query = "INSERT INTO tbl_gaz_staff (staff_name, designation, dept_id, photo_path) VALUES( \"$staff_name\", \"$staff_designation\", $staff_department , \"$staff_photo_path\");";
                            break;
                    }
                    $clgdb->executeSql($query);
                    if(mysqli_affected_rows($clgdb->conn) != -1){
                        if($is_photo_uploaded){
                            move_uploaded_file($source_file, $staff_photo_path);
                        }
                        echo "<div class=\"callout callout-success\"><p>New Staff Member Added!</p></div>";
                    }
                    $clgdb->disconnect();
                }
            }
        }
    }

    // Delete existing department
    if(isset($_GET['del_dept'])){
        $id = (int) $_GET['del_dept'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            // Check foreign key constraint first
            $has_used = $clgdb->executeSql("SELECT * FROM tbl_gaz_staff WHERE dept_id=$id ;")->num_rows;
            if(!$has_used){
                $clgdb->executeSql("DELETE FROM tbl_department WHERE id=$id");
                $rows_affected = mysqli_affected_rows($clgdb->conn);
                if($rows_affected != -1 && $rows_affected != 0){
                    echo "<div class=\"callout callout-danger\"><p>Department Deleted!</p></div>";
                }
            }else{
                // Display Constraint Error
                echo "<div class=\"callout callout-warning\"><p>Cannot delete department!</p><p>Delete all gazetted staff members for this department and then try again!</p></div>";

            }
            $clgdb->disconnect();
        }
    }

    // Delete Staff
    if(isset($_GET['del_staff']) && isset($_GET['cat'])){
        $staff_id = (int) $_GET['del_staff'];
        $category = (int) $_GET['cat'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            $table_name = "";
            switch ($category){
                case GAZETTED_INDEX:
                    $table_name = "tbl_gaz_staff";
                    break;
                case NON_GAZETTED_INDEX:
                    $table_name = "tbl_nongaz_staff";
                    break;
                case DEPUT_INDEX:
                    $table_name = "tbl_deput_staff";
                    break;
            }
            $staff_photo_path = "";
            $result = $clgdb->executeSql("SELECT photo_path FROM $table_name WHERE id=$staff_id ;");
            if($result && $result->num_rows){
                while($row = $result->fetch_assoc()){
                    $staff_photo_path = $row['photo_path'];
                }
                $clgdb->executeSql("DELETE FROM $table_name WHERE id=$staff_id ;");
                $affected_rows = mysqli_affected_rows($clgdb->conn);
                if($affected_rows != -1 && $affected_rows != 0){
                    if(!substr_count($staff_photo_path, "nophoto.png")){
                        if(file_exists($staff_photo_path)) unlink($staff_photo_path);
                    }
                    echo "<div class=\"callout callout-danger\"><p>Staff Deleted!</p></div>";
                }
            }
            $clgdb->disconnect();
        }
    }
    // Departments Array
    $departments = array();
    $clgdb->connect();
    if($clgdb->isConnected()){
        $results = $clgdb->executeSql("SELECT * FROM tbl_department;");
        if($results && $results->num_rows){
            while($row = $results->fetch_assoc()){
                $dept_id = $row['id'];
                $dept_name = $row['dept_name'];
                $departments["$dept_id"] = $dept_name;
            }
        }
        $clgdb->disconnect();
    }
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Get College Staff</div></div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="faculty.php" autocomplete="off" onsubmit="return validateGetStaff()">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="category">Staff Category</label>
                            <div class="col-md-5">
                                <select class="form-control" name="category" id="category" tabindex="9" onchange="toggleDept()">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select Staff Category</option>
                                    <?php
                                    foreach($staff_category as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="form_department_group">
                            <label class="control-label col-md-3" for="department">Department</label>
                            <div class="col-md-5">
                                <select class="form-control" name="department" id="department" tabindex="10">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a Department</option>
                                    <?php
                                    foreach($departments as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-5 col-md-offset-3">
                                <button class="btn btn-success" type="submit" name="get_staff" tabindex="11">Get</button>
                            </div>
                        </div>
                    </form>
                    <script> toggleDept(); </script>
                </div>
            </div>
        </div>
    </div>
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['get_staff'])){
            $category = (int) $_POST['category'];
            $department = (int) $_POST['department'];
            // Validation
            $is_valid = true;
            $messages = array();
            // Validate Selected staff category and department
            if($category == ZERO_INDEX){
                $is_valid = false;
                array_push($messages, "Please select a staff category!");
            }
            elseif(!key_exists($category, $staff_category)){
                $is_valid = false;
                array_push($messages, "Selected staff category is invalid!");
            }else{
                if($category == GAZETTED_INDEX){
                    if($department == ZERO_INDEX){
                        $is_valid = false;
                        array_push($messages, "Please select a department!");
                    }else{
                        $clgdb->connect();
                        if($clgdb->isConnected()){
                            $valid_dept = $clgdb->executeSql("SELECT * FROM tbl_department WHERE id = $department ;")->num_rows;
                            if(!$valid_dept){
                                $is_valid = false;
                                array_push($messages, "Selected department is invalid!");
                            }
                            $clgdb->disconnect();
                        }
                    }
                }
            }

            if(!$is_valid){
                echo "<div class=\"callout callout-warning\">";
                echo "<ul>";
                foreach ($messages as $msg) {
                    echo "<li>$msg</li>";
                }
                echo "</ul>";
                echo "</div>";
            }else{
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $query = "";
                    switch($category){
                        case DEPUT_INDEX:
                            $query = "SELECT * FROM tbl_deput_staff ORDER BY staff_name ASC;";
                            break;
                        case NON_GAZETTED_INDEX:
                            $query = "SELECT * FROM tbl_nongaz_staff ORDER BY staff_name ASC;";
                            break;
                        case GAZETTED_INDEX:
                            $query = "SELECT * FROM tbl_gaz_staff WHERE dept_id = $department ORDER BY staff_name ASC;";
                            break;
                    }
                    $results = $clgdb->executeSql($query);
                    if($results && $results->num_rows){
                        ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header"><div class="box-title">Results</div></div>
                                    <div class="box-body">
                                        <div style="max-height:300px;overflow: auto; overflow-x: hidden;">
                                            <?php
                                            while($row = $results->fetch_assoc()){
                                                $id = $row['id'];
                                                $name = $row['staff_name'];
                                                $designation = $row['designation'];
                                                $photo_path = $row['photo_path'];
                                                ?>
                                                <div class="col-md-4">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <div class="media-heading" style="font-size:16px;">
                                                                <strong><?php echo $name; ?></strong>
                                                            </div>
                                                            <p>
                                                                <small>Designation : <?php echo $designation; ?></small><br>
                                                                <a class="btn bg-blue btn-xs" title="View Photograph" data-toggle="modal" data-target="#staffModal<?php echo $id;?>"><i class="fa fa-user"></i></a>
                                                                <a class="btn bg-red btn-xs" title="Delete Staff" href="?del_staff=<?php echo $id; ?>&cat=<?php echo $category; ?>"><i class="fa fa-times"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="staffModal<?php echo $id; ?>" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn bg-red btn-xs pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                                                <div class="modal-title"><div style="font-size:16px;font-weight:bold;">Photograph of <?php echo $name; ?></div></div>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img class="img-responsive" style="display:block; margin:0 auto;" src="<?php echo $photo_path; ?>" alt="Photograph of <?php echo $name;?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }else{
                        echo "<div style=\"text-align:center;font-size:16px;color:#AAAAAA;\"><i class=\"fa fa-info-circle\"></i> No Results!</div><br>";
                    }
                    $clgdb->disconnect();
                }
            }
        }
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Departments</div></div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="faculty.php" autocomplete="off" onsubmit="return validateNewDeptForm()">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="new_dept">New Department</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="new_department" id="new_dept"  maxlength="50" tabindex="1" onkeypress="return validateTextbox(event, this)" placeholder="Enter Department Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" name="add_dept" class="btn btn-success" tabindex="2">Add</button>
                            </div>
                        </div>
                    </form>
                    <?php
                    $clgdb->connect();
                    if($clgdb->isConnected()){
                        $results = $clgdb->executeSql("SELECT * FROM tbl_department;");
                        if($results && $results->num_rows){
                            echo"<strong>Departments Added</strong>";
                            echo "<div style=\"max-height: 100px;overflow:auto;overflow-x: hidden;\" >";
                            echo "<ol>";
                            while($row = $results->fetch_assoc()){
                                $dept_name = $row['dept_name'];
                                $dept_id = $row['id'];
                                echo "<li><a class=\"btn bg-red btn-xs\" title=\"Delete Department\" href=\"?del_dept=$dept_id\"><i class=\"fa fa-times\"></i></a> $dept_name</li>";
                            }
                            echo "</ol>";
                            echo "</div>";
                        }else{
                            echo "<div style=\"font-size:16px;color:#AAAAAA;\"><i class=\"fa fa-info-circle\"></i> No departments added!</div>";
                        }
                        $clgdb->disconnect();
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Add New Staff</div></div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="faculty.php" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateNewStaffForm()">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="staff_name">Name</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="staff_name" id="staff_name" maxlength="50" tabindex="3" onkeypress="return validateTextbox(event, this)" placeholder="Enter Staff Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="staff_category">Category</label>
                            <div class="col-md-10">
                                <select class="form-control" name="staff_category" id="staff_category" tabindex="4" onchange="toggleDepartment()">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a category</option>
                                    <?php
                                    foreach($staff_category as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="dept_form_group">
                            <label class="col-md-2 control-label" for="staff_dept">Department</label>
                            <div class="col-md-10">
                                <select class="form-control" name="staff_dept" id="staff_dept" tabindex="5">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a Department</option>
                                    <?php
                                    foreach($departments as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="staff_designation">Designation</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="staff_designation" id="staff_designation" maxlength="50" tabindex="6" onkeypress="return validateTextbox(event, this)" placeholder="Enter Staff Designation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="staff_photo">Photograph (Optional)</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="staff_photo" name="staff_photo" accept="image/jpeg" tabindex="7">
                                <button type="button" class="btn bg-blue btn-xs" data-toggle="modal" data-target="#instructionModal">See Instructions</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button type="submit" class="btn btn-success" name="add_staff" tabindex="8">Add</button>
                            </div>
                        </div>
                    </form>
                    <script> toggleDepartment(); </script>
                    <div id="instructionModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn bg-red btn-xs pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                    <h4>Instructions to upload staff photograph</h4>
                                </div>
                                <div class="modal-body">
                                    <h5>Following Instructions must be followed while uploading a staff photograph :-</h5>
                                    <ol>
                                        <li>Only JPEG and JPG image files are allowed.</li>
                                        <li>File name should only contain letters and numbers.</li>
                                        <li>Maximum File size allowed is 1 MB.</li>
                                        <li>Dimensions of the image must be 120(W) x 150(H).</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>