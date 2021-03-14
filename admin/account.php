<?php
// Set this variable to page title (No title if not set)
$page_title = "Account Settings";
// Include Admin Panel header
require('../templates/admin/header.php');
?>
    <!--Form Validation Script-->
    <script>
        function validateUsername() {
            var username = document.getElementById("new_username").value;
            if (username.trim().length == 0) {
                window.alert("Username cannot be empty");
                return false;
            }
        }

        function validatePassword() {
            var currpassword = document.getElementById("current_pass").value;
            var newpassword = document.getElementById("new_pass").value;
            var confirmpassword = document.getElementById("confirm_new_pass").value;

            if (currpassword.trim().length == 0) {
                window.alert("Current Password Cannot be empty!");
                return false;
            }
            if (newpassword.trim().length == 0) {
                window.alert("New password cannot be empty!");
                return false;
            }
            if (newpassword.trim().localeCompare(confirmpassword) != 0) {
                window.alert("New Password and Confirm Password did not match!");
                return false;
            }
        }

        function validateTextbox(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                } else if (e) {
                    var charCode = e.which;
                } else {
                    return true;
                }
                if (charCode != 32)
                    return true;
                else
                    return false;
            } catch (err) {
                alert(err.Description);
            }
        }
    </script>
    <!-- Main Content -->
    <section class="content">
        <!-- Change Username Row -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="box-title">Change Username</div>
                    </div>
                    <div class="box-body">
                        <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST" AND isset($_POST['NewUsername'])){ // When Change Username Form submitted
                            $new_username = $_POST['NewUsername'];
                            if(substr_count($new_username, " ")){
                                echo "<div class=\"callout callout-danger lead\">
                                            <h4>Username must not contain any space!</h4>
                                          </div>";
                            }else{
                                $clgdb->connect();
                                if($clgdb->isConnected()){
                                    $current_username = mysqli_real_escape_string($clgdb->conn, $_SESSION['user']);
                                    $new_username = mysqli_real_escape_string($clgdb->conn, $new_username);
                                    $query = "UPDATE tbl_admin SET username = \"$new_username\" WHERE username = \"$current_username\";";
                                    $result = $clgdb->executeSql($query);
                                    if($result){
                                        echo "<div class=\"callout callout-info lead\">
                                            <h4>Changes Saved!</h4>
                                          </div>";
                                        $_SESSION['user'] = $new_username;
                                    }
                                    $clgdb->disconnect();
                                }
                            }
                        }
                        ?>
                        <form class="form-inline" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validateUsername()">
                            <div class="form-group">
                                <label class="control-label" for="new_username">Username </label>
                                <input id="new_username" name="NewUsername" class="form-control" type="text" tabindex="1" placeholder="Enter new username" onkeypress="return validateTextbox(event, this);" maxlength="20" required>
                            </div>
                            <button class="btn btn-success form-control" tabindex="2" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Change Password Row -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="box-title">Change Password</div>
                    </div>
                    <div class="box-body">
                        <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST" AND isset($_POST['CurrentPassword']) AND isset($_POST['ConfirmNewPassword']) AND isset($_POST['NewPassword'])){
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $username = mysqli_real_escape_string($clgdb->conn, $_SESSION['user']);
                                $current_password = mysqli_real_escape_string($clgdb->conn, $_POST['CurrentPassword']);
                                $new_password = mysqli_real_escape_string($clgdb->conn, $_POST['NewPassword']);
                                $confirm_password = $_POST['ConfirmNewPassword'];

                                // Validate all inputs
                                $isValid = true;
                                $msgarray = array();
                                $query_password_hash = "SELECT * FROM tbl_admin WHERE username = \"$username\";";
                                $password_query_result = $clgdb->executeSql($query_password_hash);
                                $password_hash = "";
                                while($rec = $password_query_result->fetch_assoc()){
                                    $password_hash = $rec['password'];
                                }
                                if(!password_verify($current_password, $password_hash)){
                                    $isValid = false;
                                    array_push($msgarray, "Current password entered is incorrect!");
                                }


                                if($new_password !== $confirm_password){
                                    $isValid = false;
                                    array_push($msg_array,"New Password and Confirm Password did not match!");
                                }

                                if(!$isValid){ // If input is invalid
                                    echo "<div class=\"callout callout-danger lead\">";
                                    echo "<ul style=\"font-size:15px;\">";
                                    foreach($msgarray as $msg){
                                        echo "<li>$msg</li>";
                                    }
                                    echo "</ul></div>";
                                }else{ // If input is valid
                                    // Change Password query here
                                    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                                    $pass_update_query = "UPDATE tbl_admin SET password = \"$new_password_hash\" WHERE username = \"$username\";";
                                    $result = $clgdb->executeSql($pass_update_query);
                                    if($result) {
                                        echo "<div class=\"callout callout-info lead\">
                                                <h4>Password Changed!</h4>
                                           </div>";
                                    }
                                }
                                $clgdb->disconnect();
                            }
                        }
                        ?>
                        <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validatePassword()">
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3 col-lg-2" for="current_pass">Current Password</label>
                                <div class="col-sm-6">
                                    <input id="current_pass" name="CurrentPassword" class="form-control" type="password" tabindex="3" placeholder="Enter Current Password"  maxlength="20" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3 col-lg-2" for="new_pass">New Password</label>
                                <div class="col-sm-6">
                                    <input id="new_pass" name="NewPassword" class="form-control" type="password" tabindex="4" placeholder="Enter New Password"  maxlength="20" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3 col-lg-2" for="confirm_new_pass">Confirm Password</label>
                                <div class="col-sm-6">
                                    <input id="confirm_new_pass" name="ConfirmNewPassword" class="form-control" type="password" tabindex="5" placeholder="Confirm New Password"  maxlength="20" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-sm-offset-4 col-md-offset-3 col-lg-offset-2">
                                    <button class="btn btn-success form-control" type="submit" tabindex="6">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>