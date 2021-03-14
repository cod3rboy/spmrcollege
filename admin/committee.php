<?php
// Set this variable to page title (No title if not set)
$page_title = "Committee";
// Include Admin Panel header
require('../templates/admin/header.php');
// Zero Index
define("ZERO_INDEX", 0);
?>
<script>
    function validateForm(id){
        var elements = document.getElementById(id).elements;
        var value;
        for(var i=0, element; element = elements[i++];){
            if(element.tagName === 'SELECT' && element.name.toLowerCase() != 'role_option'){
                try{
                    value = parseInt(element.value);
                    if(value == <?php echo ZERO_INDEX; ?>){
                        window.alert("Please choose an option from " + element.title + "!");
                        return false;
                    }
                }catch(err){
                    window.alert(element.title + " has invalid value!");
                    return false;
                }

            }else if(element.tagName === 'INPUT' && element.type === 'text'){
                value = element.value;
                if(value.trim().length == 0){
                    window.alert(element.title + " is empty!");
                    return false;
                }
            }
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
</script>
<!-- Main Content -->
<section class="content">
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['add_committee']) && isset($_POST['committee'])){
            $committee_name = $_POST['committee'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $committee_name = mysqli_real_escape_string($clgdb->conn, $committee_name);
                $clgdb->executeSql("INSERT INTO tbl_committee (committee_name) VALUES (\"$committee_name\");");
                if(mysqli_affected_rows($clgdb->conn) != -1){
                    echo "<div class=\"callout callout-success\">New Committee Added!</div>";
                }
                $clgdb->disconnect();
            }
        }

        if(isset($_POST['add_role']) && isset($_POST['role'])){
            $role_name = $_POST['role'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $role_name = mysqli_real_escape_string($clgdb->conn, $role_name);
                $clgdb->executeSql("INSERT INTO tbl_committee_role (role) VALUES (\"$role_name\");");
                if(mysqli_affected_rows($clgdb->conn) != -1){
                    echo "<div class=\"callout callout-success\">New Role Added!</div>";
                }
                $clgdb->disconnect();
            }
        }
    }

    if(isset($_GET['del_committee'])){
        $committee_id = (int) $_GET['del_committee'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id_exists = $clgdb->executeSql("SELECT * FROM tbl_committee WHERE id=$committee_id ;")->num_rows;
            if(!$id_exists){
                echo "<div class=\"callout callout-warning\">This committee does not exist!</div>";
            }else{
                $id_used = $clgdb->executeSql("SELECT * FROM tbl_committee_detail WHERE committee_id = $committee_id ;")->num_rows;
                if($id_used){
                    echo "<div class=\"callout callout-warning\"><p>Cannot delete this committee!</p><p>You need to delete all members from this committee before deleting this committee.</p></div>";
                }else{
                    $clgdb->executeSql("DELETE FROM tbl_committee WHERE id=$committee_id;");
                    $rows_affected = mysqli_affected_rows($clgdb->conn);
                    if($rows_affected != -1 && $rows_affected != 0){
                        echo "<div class=\"callout callout-danger\">Committee deleted!</div>";
                    }
                }
            }
            $clgdb->disconnect();
        }
    }
    if(isset($_GET['del_role'])){
        $role_id = (int) $_GET['del_role'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id_exists = $clgdb->executeSql("SELECT * FROM tbl_committee_role WHERE id=$role_id ;")->num_rows;
            if(!$id_exists){
                echo "<div class=\"callout callout-warning\">Role does not exist!</div>";
            }else{
                $id_used = $clgdb->executeSql("SELECT * FROM tbl_committee_detail WHERE role_id = $role_id ;")->num_rows;
                if($id_used){
                    echo "<div class=\"callout callout-warning\"><p>Cannot delete this role!</p><p>You need to delete all committee members who have this role before deleting this role.</p></div>";
                }else{
                    $clgdb->executeSql("DELETE FROM tbl_committee_role WHERE id=$role_id;");
                    $rows_affected = mysqli_affected_rows($clgdb->conn);
                    if($rows_affected != -1 && $rows_affected != 0){
                        echo "<div class=\"callout callout-danger\">Role deleted!</div>";
                    }
                }
            }
            $clgdb->disconnect();
        }
    }

    if(isset($_GET['del_member'])){
        $id = (int) $_GET['del_member'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            $clgdb->executeSql("DELETE FROM tbl_committee_detail WHERE id = $id ;");
            $rows_affected = mysqli_affected_rows($clgdb->conn);
            if($rows_affected != -1 && $rows_affected != 0){
                echo "<div class=\"callout callout-danger\">Committee member deleted!</div>";
            }
            $clgdb->disconnect();
        }
    }

    $committees = array();
    $roles = array();
    $clgdb->connect();
    if($clgdb->isConnected()){
        $committee_results = $clgdb->executeSql("SELECT * FROM tbl_committee ;");
        if($committee_results && $committee_results->num_rows){
            while($row = $committee_results->fetch_assoc()){
                $id = $row['id'];
                $name = $row['committee_name'];
                $committees[$id] = $name;
            }
        }
        $role_results = $clgdb->executeSql("SELECT * FROM tbl_committee_role ;");
        if($role_results && $role_results->num_rows){
            while($row = $role_results->fetch_assoc()){
                $id = $row['id'];
                $name = $row['role'];
                $roles[$id] = $name;
            }
        }
        $clgdb->disconnect();
    }
    ?>

    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['add_committee_member']) && isset($_POST['name']) && isset($_POST['select_committee']) && isset($_POST['select_role'])){
            $member_name = $_POST['name'];
            $committee = (int) $_POST['select_committee'];
            $role = (int) $_POST['select_role'];
            $is_role_valid = key_exists($role, $roles);
            $is_committee_valid = key_exists($committee, $committees);
            if($is_role_valid && $is_committee_valid){
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $member_name = mysqli_real_escape_string($clgdb->conn, $member_name);
                    $clgdb->executeSql("INSERT INTO tbl_committee_detail (member_name, committee_id, role_id) VALUES (\"$member_name\", $committee, $role);");
                    if(mysqli_affected_rows($clgdb->conn) != -1){
                        echo "<div class=\"callout callout-success\">New Committee Member Added!</div>";
                    }
                    $clgdb->disconnect();
                }
            }
        }
        if(isset($_POST['get_committee_member']) && isset($_POST['committee_option']) && isset($_POST['role_option'])){
            $committee_id = (int) $_POST['committee_option'];
            $role_id = (int) $_POST['role_option'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $query = "";
                if($role_id == ZERO_INDEX){
                    $query = "SELECT * FROM tbl_committee_detail WHERE committee_id = $committee_id ;";
                }else{
                    $query = "SELECT * FROM tbl_committee_detail WHERE committee_id = $committee_id AND role_id = $role_id ;";
                }
                $results = $clgdb->executeSql($query);
                if($results && $results->num_rows){
                    echo"
                       <div class=\"row\">
                           <div class=\"col-md-12\">
                               <div class=\"box box-primary\">
                                   <div class=\"box-header\"><div class=\"box-title\">Results</div></div>
                                   <div class=\"box-body\">
                                      <div style=\"max-height:200px;overflow: auto; overflow-x: hidden;\">
                       ";
                    while($row = $results->fetch_assoc()){
                        $id = $row['id'];
                        $member_name = $row['member_name'];
                        $committee = $committees[$row['committee_id']];
                        $role = $roles[$row['role_id']];
                        ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="media">
                                <div class="media-body">
                                    <div class="media-heading" style="font-size:16px;">
                                        <a class="btn bg-red btn-xs" title="Delete Member" href="?del_member=<?php echo $id; ?>"><i class="fa fa-times"></i></a>
                                        <strong><?php echo $member_name; ?></strong>
                                    </div>
                                    <p>
                                        <small>Committee : <?php echo $committee; ?></small><br>
                                        <small>Role : <?php echo $role; ?></small><br>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo"  </div>
                         </div>
                      </div>
                     </div>
                   </div>";
                }else{
                    echo "<div class=\"callout callout-info\"><i class=\"fa fa-info-circle\"></i> No Results!</div><br>";
                }
                $clgdb->disconnect();
            }
        }
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Add a new committee</div></div>
                <div class="box-body">
                    <form method="POST" id="add_committee_form" action="committee.php" autocomplete="off" onsubmit="return validateForm(this.id);">
                        <div class="form-group">
                            <label for="committee">Committee Name</label><br>
                            <input id="committee" title="Committee Name" type="text" class="form-control" tabindex="1" name="committee" placeholder="Enter Committee Name" onkeypress="return validateTextbox(event, this);" maxlength="100" required>
                        </div>
                        <input name="add_committee" type="submit" role="button" tabindex="2" class="btn btn-success" value="Add">
                    </form>
                    <br>
                    <?php
                    $clgdb->connect();
                    if($clgdb->isConnected()){
                        $results = $clgdb->executeSql("SELECT * FROM tbl_committee;");
                        if($results && $results->num_rows){
                            echo"<strong>Added Committees</strong>";
                            echo "<div style=\"max-height: 100px;overflow:auto;overflow-x: hidden;\" >";
                            echo "<ol>";
                            while($row = $results->fetch_assoc()){
                                $committee_name = $row['committee_name'];
                                $committee_id = $row['id'];
                                echo "<li><a class=\"btn bg-red btn-xs\" title=\"Delete Committee\" href=\"?del_committee=$committee_id\"><i class=\"fa fa-times\"></i></a> $committee_name</li>";
                            }
                            echo "</ol>";
                            echo "</div>";
                        }else{
                            echo "<div style=\"font-size:16px;color:#AAAAAA;\"><i class=\"fa fa-info-circle\"></i> No Committee added!</div>";
                        }
                        $clgdb->disconnect();
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Add a new role</div></div>
                <div class="box-body">
                    <form method="POST" id="add_role_form" action="committee.php" autocomplete="off" onsubmit="return validateForm(this.id);">
                        <div class="form-group">
                            <label for="role">Role Name</label><br>
                            <input id="role" title="Role Name" type="text" name="role" class="form-control" maxlength="50" tabindex="3" placeholder="Enter Role Name" required>
                        </div>
                        <input name="add_role" type="submit" role="button" class="btn btn-success"  tabindex="4" value="Add">
                    </form>
                    <br>
                    <?php
                    $clgdb->connect();
                    if($clgdb->isConnected()){
                        $results = $clgdb->executeSql("SELECT * FROM tbl_committee_role;");
                        if($results && $results->num_rows){
                            echo"<strong>Added Committee Roles</strong>";
                            echo "<div style=\"max-height: 100px;overflow:auto;overflow-x: hidden;\" >";
                            echo "<ol>";
                            while($row = $results->fetch_assoc()){
                                $role_name = $row['role'];
                                $role_id = $row['id'];
                                echo "<li><a class=\"btn bg-red btn-xs\" title=\"Delete Role\" href=\"?del_role=$role_id\"><i class=\"fa fa-times\"></i></a> $role_name</li>";
                            }
                            echo "</ol>";
                            echo "</div>";
                        }else{
                            echo "<div style=\"font-size:16px;color:#AAAAAA;\"><i class=\"fa fa-info-circle\"></i> No Roles added!</div>";
                        }
                        $clgdb->disconnect();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Add a new committee member</div></div>
                <div class="box-body">
                    <form class="form-horizontal" id="new_committee_member" method="post" action="committee.php" autocomplete="off" onsubmit="return validateForm(this.id)">
                        <div class="form-group">
                            <label class="control-label col-md-2" for="name">Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" id="name" title="Member Name" tabindex="5" maxlength="50" placeholder="Enter member name" onkeypress="return validateTextbox(event, this)" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2" for="select_committee">Committee</label>
                            <div class="col-md-9">
                                <select class="form-control" title="Committee" name="select_committee" id="select_committee" tabindex="6">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a committee</option>
                                    <?php
                                    foreach($committees as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2" for="select_role">Role</label>
                            <div class="col-md-9">
                                <select class="form-control" title="Role" name="select_role" id="select_role" tabindex="7">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a role</option>
                                    <?php
                                    foreach($roles as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-2">
                                <button role="button" type="submit" class="btn btn-success" name="add_committee_member" tabindex="8">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Committee Members</div></div>
                <div class="box-body">
                    <form class="form-horizontal" id="get_committee_member" method="post" action="committee.php" autocomplete="off" onsubmit="return validateForm(this.id)">
                        <div class="form-group">
                            <label class="control-label col-md-2" for="committee_option">Committee</label>
                            <div class="col-md-9">
                                <select class="form-control" title="Committee" name="committee_option" id="committee_option" tabindex="9">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a committee</option>
                                    <?php
                                    foreach($committees as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2" for="role_option">Role</label>
                            <div class="col-md-9">
                                <select class="form-control" title="Role" name="role_option" id="role_option" tabindex="10">
                                    <option value="<?php echo ZERO_INDEX; ?>">Select a role</option>
                                    <?php
                                    foreach($roles as $key=>$value){
                                        echo "<option value=\"$key\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-2">
                                <button role="button" type="submit" class="btn btn-success" name="get_committee_member" tabindex="11">Get</button>
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