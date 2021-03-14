<?php
    // Admin Login Web page

    // Start the session
    session_start();
    // Import database connectivity file
    require('../database.php');
    // Import Utilities File
    require('utilities.php');
    // Destroy and Restart Session if user visit this page after logged in
    // and force user to login again
    if(isset($_SESSION['user'])){
        session_destroy();
        session_start();
    }

    // Set the captcha text before submitting form
    if($_SERVER['REQUEST_METHOD'] != "POST"){
        $_SESSION['captcha_text'] = random_str(7);
    }

    // Attempt to login after form submitted
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['login-submit']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['captcha'])){
            // Form Valid Flag
            $formValid = true;
            // Username and Password
            $username = $_POST['username'];
            $password = $_POST['password'];
            $captcha = $_POST['captcha'];
            // Validate the values
            $error_messages = array();
            if(strlen(trim($username)) == 0){
                $formValid = false;
                array_push($error_messages, "Username is Empty");
            }
            if(strlen(trim($password)) == 0){
                $formValid = false;
                array_push($error_messages, "Password is Empty");
            }
            if($captcha != $_SESSION['captcha_text']){
                $formValid = false;
                array_push($error_messages, "Wrong Captcha Text Entered");
            }
            // Change Captcha if the login page is again displayed
            $_SESSION['captcha_text'] = random_str(7);
            if($formValid){
                // Now verify the username and password in database
                $clgdb = new CollegeDatabase();
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $username = mysqli_real_escape_string($clgdb->conn, $username);
                    $query_username = "Select * from tbl_admin where username = \"$username\";";
                    $user_result = $clgdb->executeSql("$query_username");
                    if(!$user_result->num_rows){
                        array_push($error_messages, "Username is not valid");
                    }else{
                        $hashed_password = "";
                        while($record = $user_result->fetch_assoc()){
                            $hashed_password = $record['password'];
                        }
                        if(!password_verify($password, $hashed_password)){
                            array_push($error_messages, "Password is wrong");
                        }else{
                            // Login is Successful
                            // Log Login Attempt in database and create session variable
                            // and redirect to dashboard
                            $client_ip_address = $_SERVER["REMOTE_ADDR"];
                            $login_query = "INSERT INTO tbl_admin_log (ip_address) VALUES(\"$client_ip_address\");";
                            $clgdb->executeSql($login_query);
                            $_SESSION['user'] = $username;
                            $clgdb->disconnect();
                            header('Location: dashboard.php');
                        }
                    }
                    $clgdb->disconnect();
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/font-awesome.css">
    <!--Theme File-->
    <link rel="stylesheet" href="../css/admin/logintheme.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Form Validation Script-->
    <script type="text/javascript">
        function validateLoginForm(){
            var username = document.forms['login-form']['username'].value;
            var password = document.forms['login-form']['password'].value;
            var isFormValid = true;
            var msgs = [];
            if(username.trim().length == 0){
                msgs.push("Username is Empty");
                isFormValid = false;
            }

            if(!isFormValid) {
                var errorList = document.getElementById("errorlist");
                var errorAlert = "<div class=\"alert alert-info\"><ul>";
                // display messages
                for (var i = 0; i < msgs.length; i++) {
                    errorAlert +=  ("<li>" + msgs[i] + "</li>");
                }
                errorAlert += "</ul></div>";
                errorList.innerHTML = errorAlert;
            }
            return isFormValid;
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
                if (charCode != 32)
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }
        function validateCaptcha(e, t){
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode >= 48 && charCode <= 57) || (charCode==13))
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }
    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div style="font-size:50px;"><i class="fa fa-tachometer"></i></div>
                    <div style="font-size:30px;letter-spacing:3px;">ADMIN LOGIN</div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="errorlist">
                                <!--Generate by PHP when validation fails-->
                                <?php
                                    if(isset($error_messages)){
                                        echo "<div class=\"alert alert-info\"><ul>";
                                        foreach($error_messages as $message){
                                            echo "<li>$message</li>";
                                        }
                                        echo "</ul></div>";
                                    }
                                ?>
                            </div>
                            <br>
                            <br>
                            <form class="form-horizontal" id="login-form" onsubmit="return validateLoginForm()" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" role="form" style="display: block;" autocomplete="off">
                                <div class="form-group">
                                    <label class="control-label col-xs-1 input-label" for="username"><i class="fa fa-user"></i></label>
                                    <div class="col-xs-10">
                                        <input type="text" name="username" id="username" tabindex="1" maxlength="70" class="col-xs-10 form-control" placeholder="Enter Username" value="" onkeypress="return validateTextbox(event, this);" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-1 input-label" for="password"><i class="fa fa-lock"></i></label>
                                    <div class="col-xs-10">
                                        <input type="password" name="password" id="password" tabindex="2" maxlength="70" class="form-control" placeholder="Enter Password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" for="captcha">
                                        <h4><i class="fa fa-eye"></i> Captcha! <small>Not a robot ?</small></h4>
                                        <img src="captcha.php"> <span style="font-size:20px;"><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><i class="fa fa-refresh"></i></a></span>
                                    </label>
                                    <div class="col-xs-10 col-sm-8 col-md-6">
                                        <input type="text" name="captcha" id="captcha" tabindex="3" class="form-control" onkeypress="return validateCaptcha(event, this);" placeholder="Enter Above Text" required>
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group pull-right">
                                    <button class="form-control btn btn-login" type="submit" role="button" name="login-submit" id="login-submit" tabindex="4">LOG IN <i class="fa fa-sign-in"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>
<!-- jQuery 2.2.3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>
