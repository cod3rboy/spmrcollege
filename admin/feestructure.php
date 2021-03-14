<?php
// Set this variable to page title (No title if not set)
$page_title = "Fee Structure";
// Include Admin Panel header
require('../templates/admin/header.php');
define("ZERO_INDEX", 0);

$courses = array();
$courses_sem = array(
    1 => "Sem I-II",
    2 => "Sem III-IV",
    3 => "Sem V-VI"
);
?>
<script>
    function newCourseFormValidate(){
        var courseName = document.getElementById("new_course_name").value;
        if(courseName.trim().length == 0){
            window.alert("New course name is empty!");
            return false;
        }
        return true;
    }

    function validateFee(e, t){
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

    function feeStructureValidate(){
        var course = parseInt(document.getElementById("course_select").value);
        var sem = parseInt(document.getElementById("sem_select").value);
        var fee = parseInt(document.getElementById("fee_amount").value);

        if(course == <?php echo ZERO_INDEX ;?>){
            window.alert("Please select a course!");
            return false;
        }

        if(sem == <?php echo ZERO_INDEX ;?>){
            window.alert("Please select a semester!");
            return false;
        }
        if(fee < 0 || fee.trim().length == 0){
            window.alert("Fee amount is invalid!");
            return false;
        }
        return true;
    }

    function getFeeValidate(){
        var course = parseInt(document.getElementById("course").value);
        var sem = parseInt(document.getElementById("year").value);

        if(course == <?php echo ZERO_INDEX ;?>){
            window.alert("Please select a course!");
            return false;
        }

        if(sem == <?php echo ZERO_INDEX ;?>){
            window.alert("Please select a semester!");
            return false;
        }
        return true;
    }

</script>

<!--Main Content-->
<section class="content">
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['add_course']) && isset($_POST['new_course_name'])){
            $new_course_name = $_POST['new_course_name'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $new_course_name = mysqli_real_escape_string($clgdb->conn, $new_course_name);
                $clgdb->executeSql("INSERT INTO tbl_courses (course_name) VALUES (\"$new_course_name\") ;");
                if(mysqli_affected_rows($clgdb->conn) != -1){
                    echo "<div class=\"callout callout-success\"><p>New Course Added!</p></div>";
                }
                $clgdb->disconnect();
            }
        }
        if(isset($_POST['add_fee']) && isset($_POST['course_select']) && isset($_POST['sem_select']) && isset($_POST['fee_amount'])){
            $course = (int) $_POST['course_select'];
            $sem = (int) $_POST['sem_select'];
            $fee_amount = (int) $_POST['fee_amount'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $clgdb->executeSql("DELETE FROM tbl_feestructure WHERE courseid=$course AND courseyear=$sem ;");
                $clgdb->executeSql("INSERT INTO tbl_feestructure (courseid, courseyear, fee) VALUES($course, $sem, $fee_amount);");
                if(mysqli_affected_rows($clgdb->conn) != -1){
                    echo "<div class=\"callout callout-success\"><p>Fee structure saved!</p></div>";
                }
                $clgdb->disconnect();
            }
        }
    }

    if(isset($_GET['del_course'])){
        $id = (int) $_GET['del_course'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            // Check foreign key constraint first
            $has_used = $clgdb->executeSql("SELECT * FROM tbl_feestructure WHERE courseid=$id ;")->num_rows;
            if(!$has_used){
                $clgdb->executeSql("DELETE FROM tbl_courses WHERE id=$id ;");
                $rows_affected = mysqli_affected_rows($clgdb->conn);
                if($rows_affected != -1 && $rows_affected != 0){
                    echo "<div class=\"callout callout-danger\"><p>Course Deleted!</p></div>";
                }

            }else{
                // Display Constraint Error
                echo "<div class=\"callout callout-warning\"><p>Cannot delete course!</p><p>Delete fee structure for this course and then try again!</p></div>";
            }
            $clgdb->disconnect();
        }
    }

    $clgdb->connect();
    if($clgdb->isConnected()){
        $results = $clgdb->executeSql("SELECT id , course_name FROM tbl_courses ;");
        if($results && $results->num_rows){
            while($row = $results->fetch_assoc()){
                $id = (int) $row['id'];
                $course_name = $row['course_name'];
                $courses["$id"] = $course_name;
            }
        }
        $clgdb->disconnect();
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Add a new course</div></div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="feestructure.php" autocomplete="off" onsubmit="return newCourseFormValidate()">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="new_course_name">Course Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="new_course_name" name="new_course_name" maxlength="20" tabindex="1" placeholder="Enter course name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" class="btn btn-success" name="add_course" tabindex="2">Add</button>
                            </div>
                        </div>
                    </form>
                            <?php
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $results = $clgdb->executeSql("SELECT * FROM tbl_courses ;");
                                if($results && $results->num_rows){
                                    echo"<strong>Courses Added</strong>";
                                    echo "<div style=\"max-height: 100px;overflow:auto;overflow-x: hidden;\" >";
                                    echo "<ol>";
                                    while($row = $results->fetch_assoc()){
                                        $course_name = $row['course_name'];
                                        $course_id = $row['id'];
                                        echo "<li><a class=\"btn bg-red btn-xs\" title=\"Delete Course\" href=\"?del_course=$course_id\"><i class=\"fa fa-times\"></i></a> $course_name</li>";
                                    }
                                    echo "</ol>";
                                    echo "</div>";
                                }else{
                                    echo "<div style=\"font-size:16px;color:#AAAAAA;\"><i class=\"fa fa-info-circle\"></i> No courses added !</div>";
                                }
                                $clgdb->disconnect();
                            }
                            ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Add / Change Fee Structure</div></div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="feestructure.php" autocomplete="off" onsubmit="return feeStructureValidate()">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="course_select">Course</label>
                            <div class="col-md-9">
                                <select class="form-control" id="course_select" name="course_select" tabindex="3">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a course</option>
                                    <?php
                                    foreach($courses as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="sem_select">Semester</label>
                            <div class="col-md-9">
                                <select class="form-control" id="sem_select" name="sem_select" tabindex="4">
                                    <option value="<?php echo ZERO_INDEX;?>">Select Semester</option>
                                    <?php
                                    foreach($courses_sem as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="fee_amount">Fee</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="fee_amount" name="fee_amount" tabindex="5" placeholder="Enter Fee Amount" onkeypress="return validateFee(event, this);" maxlength="10" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" class="btn btn-success" tabindex="6" name="add_fee">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Get Fee Structure</div></div>
                <div class="box-body">
                    <form class="form-inline" method="post" action="feestructure.php" autocomplete="off" onsubmit="return getFeeValidate()">
                        <div class="form-group">
                            <label for="course">Course</label>
                            <select id="course" class="form-control" name="course_name" tabindex="7" required>
                                <option value="<?php echo ZERO_INDEX; ?>">Select a course</option>
                                <?php
                                foreach($courses as $key=>$value){
                                    echo "<option value=\"$key\">$value</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">Semester</label>
                            <select id="year" class="form-control" name="course_year" tabindex="8" required>
                                <option value="<?php echo ZERO_INDEX;?>">Select Semester</option>
                                <?php
                                foreach($courses_sem as $key=>$value){
                                    echo "<option value=\"$key\">$value</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="getFee" class="btn btn-success" tabindex="9">Get</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    function getFeeStructure($course_id, $semester) {
        global $clgdb;
        global $courses;
        global $courses_sem;
        $clgdb->connect();
        if($clgdb->isConnected()){
            $course_id = (int) $course_id;
            $semester = (int) $semester;
            $query = "SELECT * FROM tbl_feestructure WHERE courseid = $course_id AND courseyear=$semester ;";
            $results = $clgdb->executeSql($query);
            if($results && $results->num_rows){
                while($row = $results->fetch_assoc()){
                    $courseid = $row["courseid"];
                    $year = $row['courseyear'];
                    $fee = $row['fee'];?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header"><div class="box-title">Results</div></div>
                                <div class="box-body">
                                    <div style="font-size:16px;font-weight:bold;"><?php echo $courses["$courseid"] ." ( " . $courses_sem["$year"] . " ) " ?></div>
                                    Fee : Rs <?php echo $fee;?><br>
                                    <a class="btn bg-red btn-xs" title="Delete Fee Structure" href="<?php echo"?del_id=$course_id&del_yr=$year"?>"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }else{
                echo "<div style=\"text-align:center;font-size:16px;color:#AAAAAA;\"><i class=\"fa fa-info-circle\"></i> No Results!</div>";
            }
            $clgdb->disconnect();
        }
    }
    ?>

    <?php
        if(isset($_GET['del_id']) && isset($_GET['del_yr'])){
            $delete_id = (int) $_GET['del_id'];
            $delete_yr = (int) $_GET['del_yr'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $clgdb->executeSql("DELETE FROM tbl_feestructure WHERE courseid=$delete_id AND courseyear=$delete_yr ;");
                $affected_rows = mysqli_affected_rows($clgdb->conn);
                if($affected_rows != 0 && $affected_rows != -1){
                    echo "<div class=\"callout callout-danger\"><p>Fee structure deleted!</p></div>";
                }
                $clgdb->disconnect();
            }
        }
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['getFee']) && isset($_POST['course_name']) && isset($_POST['course_year'])){
                $course_name = (int) $_POST['course_name'];
                $course_year = (int) $_POST['course_year'];
                getFeeStructure($course_name, $course_year);
            }
        }
    ?>
</section>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>