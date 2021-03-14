<?php
// Set this variable to page title (No title if not set)
$page_title = "Admission Link";
// Include Admin Panel header
require('../templates/admin/header.php');
?>
<!--Script to update admission form-->
<script>
    function validate(){
        var link = document.getElementById("link").value.trim();
        if(link.search("http://") == -1 && link.search("https://") == -1){
            window.alert("Link must start with http:// or https://");
            return false;
        }

        if(link.search(" ") != -1){
            window.alert("Link must not contain any space!");
            return false;
        }
        var pattern = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        var regex = new RegExp(pattern);
        if(!link.match(regex)){
            window.alert("Link entered is not a valid URL!");
            return false;
        }

        return true;
    }

</script>
<!-- Main Content -->
<section class="content">
    <?php
    // When Admission Link Form Submitted
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['set_link']) && isset($_POST['admission_link'])){
            $link = $_POST['admission_link']; // Get entered Admission Link
            $link_valid = true;
            $messages = array();
            if(!substr_count($link,"http://")  && !substr_count($link,"https://")){
                $link_valid = false;
                array_push($messages, "Link must start with http:// or https://");
            }
            if(substr_count($link, " ")){
                $link_valid = false;
                array_push($messages, "Link must not contain any space!");
            }

            if(!$link_valid){ // Link Invalid
                echo "<div class=\"callout callout-danger\">";
                echo "<ul>";
                foreach($messages as $msg){
                    echo "<li>$msg</li>";
                }
                echo "</ul>";
                echo "</div>";
            }else{
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $link = mysqli_real_escape_string($clgdb->conn, $link);
                    $clgdb->executeSql("DELETE FROM tbl_admission_link;");
                    $clgdb->executeSql("INSERT INTO tbl_admission_link (link) VALUES(\"$link\") ;");
                    if(mysqli_affected_rows($clgdb->conn) != -1){
                        echo "<div class=\"callout callout-success\"><p>New admission link is set!</p></div>";
                    }
                    $clgdb->disconnect();
                }
            }
        }
    }
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-title">
                        Online Admission Link
                    </div>
                </div>
                <div class="box-body">
                        <!--Current Link-->
                        <label for="current-link">Current Link</label>
                        <input class="form-control" id="current-link" readonly value="<?php $clgdb->connect();if($clgdb->isConnected()){$result = $clgdb->executeSql("SELECT * FROM tbl_admission_link;");if($result->num_rows){$link = "#";while($row = $result->fetch_assoc()){$link = $row['link'];}echo $link;}else{echo "No Link";}$clgdb->disconnect();}?>">
                        <br>
                        <br>
                    <!--Link Input Form-->
                    <form method="post" action="admission.php" autocomplete="off" onsubmit="return validate()">
                        <div class="form-group">
                            <label for="link">Set New Admission Link</label>
                            <input type="text" class="form-control" id="link" name="admission_link" maxlength="500" tabindex="1" placeholder="( With http:// or https:// )" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="set_link" tabindex="2" >Set</button>
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