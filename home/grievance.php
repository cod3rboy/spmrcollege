<?php
//Setting Page Title
$page_title = "Grievance Redressal";
//INCLUDE HEADER CODE
require("../templates/common/header.php");

// Flag for validation of form submitted
$form_data_valid = true;
// Store Error Messages
$messages_array = array();
// Check whether all fields are submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['email_id']) && isset($_POST['subject']) && isset($_POST['description'])){

    // Validation Process
    $name = $_POST["name"]; // Get Name
    $emailid = $_POST["email_id"]; // Get Email Id
    $subject = $_POST["subject"]; // Get Subject of Grievance
    $description = $_POST["description"]; // Get Grievance Description

    // Validate Name
    if(0 == strlen(trim($name))){
        $form_data_valid = false;
        array_push($messages_array, "Name cannot be empty");
    }
    // Validate Email ID
    if(0 == strlen(trim($emailid)) || !strpos($emailid, "@")){
        $form_data_valid = false;
        array_push($messages_array, "Email id is either empty or incorrect");
    }

    // Validate Subject
    if(0 == strlen(trim($subject))){
        $form_data_valid = false;
        array_push($messages_array, "Subject cannot be empty");
    }

    // Validate Description
    if(0 == strlen(trim($description))){
        $form_data_valid = false;
        array_push($messages_array, "Description cannot be empty");
    }

    // Now inserting into database if form is valid
    if($form_data_valid){
        $clgdb->connect();
        if($clgdb->isConnected()){
            $name = mysqli_real_escape_string($clgdb->conn, $name);
            $emailid = mysqli_real_escape_string($clgdb->conn, $emailid);
            $subject = mysqli_real_escape_string($clgdb->conn, $subject);
            $description = mysqli_real_escape_string($clgdb->conn, $description);
            $insert_feedback_query = "INSERT INTO tbl_feedback (name, email_id, title, description, is_read) VALUES (\"$name\", \"$emailid\", \"$subject\", \"$description\", 0);";
            $clgdb->executeSql($insert_feedback_query);
        }
    }
}
?>

<!--Form Validation Script-->
    <script>
    function formValidate(){
        // Validate Name
        var name = document.getElementById("name").value;
        if(name.trim().length == 0){
            window.alert("Name cannot be empty!");
            return false;
        }
        // Validate Email
        var email = document.getElementById("email").value;
        if(email.trim().length == 0){
            window.alert("Email cannot be empty");
            return false;
        }
        // Validate Subject
        var title = document.getElementById("subject").value;
        if(title.trim().length == 0){
            window.alert("Subject / Title cannot be empty!");
            return false;
        }
        // Validate Description
        var description = document.getElementById("desc").value;
        if(description.trim().length == 0){
            window.alert("Description cannot be empty!");
            return false;
        }

        // Return True when validation is successful
        return true;
    }
</script>
<!--Bootstrap Container-->
<div class="container">
    <!--Bootstrap Row-->
    <div class="row">
        <!--Bootstrap Column-->
        <div class="col-xs-12">
            <!--Page container-->
            <div class="page-container" id="scroll-content">
                <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / Grievance Redressal
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                    <!--Page Logo-->
                    <img class="img-responsive page-logo" alt="Bubble icon" src="../images/bubble.png">
                    <hr class="hr-divider">
                    <!--Bootstrap Row-->
                    <div class="row">
                        <!--Bootstrap Column-->
                        <div class="col-md-6 col-md-offset-3">
                            <?php
                                // Display Messages Here on top of Form after Form is submitted
                                if($_SERVER["REQUEST_METHOD"] == "POST"){
                                    if($form_data_valid){
                                        // When data is valid then display Grievance Submitted message
                                        echo "<div class=\"alert alert-success\">Your grievance has been submitted.</div>";
                                    }else{
                                        // When data validation is unsuccessful then display error messages
                                        echo "<div class=\"alert alert-danger\"><ul>";
                                        foreach($messages_array as $msg){
                                            echo "<li>$msg</li>";
                                        }
                                        echo "</ul></div>";
                                    }
                                }
                            ?>
                            <div class="bar-header">Fill and submit the following form</div>
                            <!--Grievance Form-->
                            <form class="page-content" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return formValidate();">
                                <!--Name Field-->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" maxlength="50" required>
                                </div>
                                <!--End Name Field-->
                                <!--Email Field-->
                                <div class="form-group">
                                    <label for="email">E-Mail Address</label>
                                    <input type="email" id="email" name="email_id" placeholder="Enter email address" maxlength="100" class="form-control" required>
                                </div>
                                <!--End Email Field-->
                                <!--Subject Field-->
                               <div class="form-group">
                                    <label for="subject">Subject / Title</label>
                                    <input type="text" id="subject" name="subject" placeholder="Enter title" maxlength="50" class="form-control" required>
                                </div>
                                <!--End Subject Field-->
                                <!--Description Field-->
                                  <div class="form-group">
                                    <label for="desc">Description</label>
                                      <textarea id="desc" name="description" maxlength="250" class="form-control" placeholder="Describe your grievance here..." rows="5" style="resize: none;" required></textarea>
                                  </div>
                                <!--End Description Field-->
                                <!--Submit Button-->
                                <div class="text-center"><input type="submit" value="Submit" class="btn btn-success"></div>
                           </form>
                            <!--End Grievance Form-->
                        </div>
                        <!--End Bootstrap Column-->
                    </div>
                    <!--End Bootstrap Row-->
                </div>
                <!--End Page Body-->
            </div>
            <!--End Page Container-->
        </div>
        <!--End Bootstrap Column-->
    </div>
    <!--End Bootstrap Row-->
</div>
<!--End Bootstrap Container-->

<?php
//INCLUDE FOOTER CODE
require("../templates/common/footer.php");
?>