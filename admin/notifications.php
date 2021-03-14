<?php
// Set this variable to page title (No title if not set)
$page_title = "Notifications";
// Include Admin Panel header
require('../templates/admin/header.php');
?>
    <script>
        // Add Link Behaviour here
        function insertLink(code){
            var linkBoxId = (code == 1) ? "update_link": "new_link" ;
            var descBoxId = (code == 1) ? "update_desc": "new_desc" ;
            var link = document.getElementById(linkBoxId).value;
            var descriptionBox = document.getElementById(descBoxId);
            var desc = descriptionBox.value;
            if(link.search("http://") != -1 || link.search("https://") != -1){
                descriptionBox.value = desc + " " + "<a target=\"_blank\" href=\""+link+"\">Link</a>";
            }else{
                window.alert("Link must contain http:// or https://");
            }
        }

        function validate_update(){
            var title = document.getElementById("title").value.trim();
            if(title.length == 0){
                window.alert("Title is empty!");
                return false;
            }
            var desc = document.getElementById("update_desc").value.trim();
            if(desc.length == 0){
                window.alert("Description is empty!");
                return false;
            }
        }

        function validate_new(){
            var title = document.getElementById("title").value.trim();
            if(title.length == 0){
                window.alert("Title is empty!");
                return false;
            }
            var desc = document.getElementById("new_desc").value.trim();
            if(desc.length == 0){
                window.alert("Description is empty!");
                return false;
            }
        }

    </script>
<?php
function updateNotification($id, $clgdb){
    $result = $clgdb->executeSql("SELECT * FROM tbl_notification WHERE id=$id;");
    if($result->num_rows){
        while($row = $result->fetch_assoc()){
            $_id = $row['id'];
            $title = $row['title'];
            $description = $row['description'];
            ?>
            <div class="box box-primary with-border">
                <div class="box-header">
                    <div class="box-title">Update Notification</div>
                    <div class="box-tools pull-right"><button type="button" class="btn bg-red btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button></div>
                </div>
                <div class="box-body">
                    <form method="post" action="notifications.php"  class="form-horizontal" onsubmit="return validate_update()" autocomplete="off">
                        <input hidden type="text" name="id" value="<?php echo $_id; ?>">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Title</label>
                            <div class="col-sm-8"><input class="form-control" id="title" name="title" type="text" maxlength="150" value="<?php echo htmlspecialchars($title); ?>" required tabindex="1"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="update_desc">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" style="resize:none;height:100px;" id="update_desc" name="description" maxlength="500" required tabindex="2"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="update_link"><a class="btn bg-blue btn-xs" tabindex="4" onclick="insertLink(1)">Insert Link</a></label>
                            <div class="col-sm-8"><input type="text" class="form-control" id="update_link" tabindex="3" placeholder="With http:// or https://"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" name="update" class="btn btn-success" tabindex="5">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
    }
}
?>
<?php
    function newNotification(){
        ?>
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">Add New Notification</div>
            </div>
            <div class="box-body">
                <form method="post" action="notifications.php" class="form-horizontal" autocomplete="off" onsubmit="return validate_new()">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Title</label>
                        <div class="col-sm-8"><input class="form-control" id="title" name="title" type="text" maxlength="150" required placeholder="Enter Notification Title" tabindex="1"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="new_desc">Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" style="resize:none;height:100px;" id="new_desc" name="description" maxlength="500" required placeholder="Enter Description" tabindex="2"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="new_link"><a class="btn bg-blue btn-xs" tabindex="4" onclick="insertLink(2)">Insert Link</a></label>
                        <div class="col-sm-8"><input type="text" class="form-control" id="new_link" tabindex="3" maxlength="100" placeholder="With http:// or https://"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" name="new" class="btn btn-success" tabindex="5">Publish</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
?>
<?php
    function deleteNotification($id, $clgdb){
        $clgdb->executeSql("DELETE FROM tbl_notification WHERE id=$id");
        if(mysqli_affected_rows($clgdb->conn) != 0){
            echo "<div class=\"callout callout-danger\"><p>Notification Deleted!</p></div>";
        }
    }
?>
<!-- Main Content -->
<section class="content">
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['update']) && isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description'])){
            // Update notification here
            $id = $_POST['id'];
            $title = $_POST['title'];
            $desc = $_POST['description'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $id = mysqli_real_escape_string($clgdb->conn, $id);
                $title = mysqli_real_escape_string($clgdb->conn, $title);
                $desc = mysqli_real_escape_string($clgdb->conn, $desc);
                $clgdb->executeSql("UPDATE tbl_notification SET title =\"$title\", description=\"$desc\" WHERE id=$id ;");
                // Show successful status here
                if(mysqli_affected_rows($clgdb->conn) != 0){
                    echo "<div class=\"callout callout-success\"><p>Notification Updated!</p></div>";
                }
                $clgdb->disconnect();
            }
        }else if(isset($_POST['new']) && isset($_POST['title']) && isset($_POST['description'])){
            // Publish new notification here
            $title = $_POST['title'];
            $desc = $_POST['description'];
            $clgdb->connect();
            if($clgdb->isConnected()){
                $title = mysqli_real_escape_string($clgdb->conn, $title);
                $desc = mysqli_real_escape_string($clgdb->conn, $desc);
                $clgdb->executeSql("INSERT INTO tbl_notification (title, description) VALUES(\"$title\", \"$desc\") ;");
                // Show successful status here
                if(mysqli_affected_rows($clgdb->conn) != -1){
                    echo "<div class=\"callout callout-success\"><p>Notification Published!</p></div>";
                }
                $clgdb->disconnect();
            }
        }
    }
    if(isset($_GET['delete'])){
        $id = (int) $_GET['delete'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            deleteNotification($id, $clgdb);
            $clgdb->disconnect();
        }
    }

    newNotification();

    if(isset($_GET['update'])){
        $id = (int) $_GET['update'];
        $clgdb->connect();
        if($clgdb->isConnected()){
            updateNotification($id, $clgdb);
            $clgdb->disconnect();
        }
    }
    ?>
    <div class="box box-primary">
        <div class="box-header">
            <div class="box-title">All Issued Notifications</div>
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
                    // Query String to get total records in the notification table
                    $total_rec_query = "SELECT * FROM tbl_notification ;";
                    // Execute query and get no of rows
                    $total_rec = $clgdb->executeSql($total_rec_query)->num_rows;
                    if ($total_rec == 0) { //If there is no row i.e. no record found
                        //Display No Records Found
                        $msg_string = "<h5>No notification issued yet!</h5>";
                        echo $msg_string;
                    } else { //If there are records in the notification table
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
                        // SQL Query to load notifications from database with limit and offset
                        $query = "SELECT id, title, UNIX_TIMESTAMP(time_stamp) AS dated FROM tbl_notification ORDER BY time_stamp DESC LIMIT $per_page OFFSET $offset;";
                        // Execute Query
                        $results = $clgdb->executeSql($query);
                        echo "<ol>";
                        while ($tupple = $results->fetch_assoc()) {
                            $id = $tupple['id']; // Notification Id
                            $title = $tupple['title']; // Notification Title
                            $time_stamp = $tupple['dated']; // Notification Timestamp
                            $formatted_date = date("d-M-Y", $time_stamp);
                            $formatted_time = date("h:i A", $time_stamp);
                            $formatted_time_stamp = "Issued Date : $formatted_date at $formatted_time";
                            echo "
                            <li>
                                <div style=\"font-size:14px;font-weight:bold;\">$title</div>
                                <small>$formatted_time_stamp</small><br>
                                <a class=\"btn bg-green btn-xs\" href=\"?update=$id\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>
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
                }
                ?>
        </div>
    </div>
</section>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>