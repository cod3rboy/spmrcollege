<?php
// Set this variable to page title (No title if not set)
$page_title = "Results";
// Include Admin Panel header
require('../templates/admin/header.php');
?>
    <script>
        function validate(){
            var link = document.getElementById("link").value.trim();
            if(link.search("http://") == -1 && link.search("https://") == -1){
                window.alert("Link must start with http:// or https://");
                return false;
            }
            var title = document.getElementById("title").value.trim();
            if(title.length == 0){
                window.alert("Title is empty!");
                return false;
            }
        }
    </script>
    <!-- Main Content -->
    <section class="content">
        <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                if(isset($_POST['publish']) && isset($_POST['title']) && isset($_POST['result_link'])){
                    $clgdb->connect();
                    if($clgdb->isConnected()){
                        $title = mysqli_real_escape_string($clgdb->conn, $_POST['title']);
                        $link = mysqli_real_escape_string($clgdb->conn, $_POST['result_link']);
                        $clgdb->executeSql("INSERT INTO tbl_results (title, link) VALUES (\"$title\", \"$link\"); ");
                        if(mysqli_affected_rows($clgdb->conn) != -1){
                            echo "<div class=\"callout callout-success\"><p>Result Published!</p></div>";
                        }
                        $clgdb->disconnect();
                    }
                }
            }
            if(isset($_GET['delete'])){
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $id = (int) $_GET['delete'];
                    $clgdb->executeSql("DELETE FROM tbl_results WHERE id=$id ;");
                    if(mysqli_affected_rows($clgdb->conn) != -1){
                        echo "<div class=\"callout callout-danger\"><p>Result Deleted!</p></div>";
                    }
                    $clgdb->disconnect();
                }
            }
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Publish New Result
                        </div>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" onsubmit="return validate()" autocomplete="off">
                            <div class="form-group">
                                <label class="control-label col-md-1" for="title">Title</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="title" name="title" tabindex="1" maxlength="300" placeholder="Enter title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-1" for="link">Link</label>
                                <div class="col-md-10">
                                    <textarea id="link" class="form-control" name="result_link" style="resize:none;height:60px;" tabindex="2" maxlength="500" placeholder="Enter Result Link ( with http:// or https:// )" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-1 col-md-10">
                                    <button type="submit" name="publish" class="btn btn-success" tabindex="3">Publish</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header"><div class="box-title">All Published Results</div></div>
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
                            // Query String to get total records in the results table
                            $total_rec_query = "SELECT * FROM tbl_results;";
                            // Execute query and get no of rows
                            $total_rec = $clgdb->executeSql($total_rec_query)->num_rows;
                            if ($total_rec == 0) { //If there is no row i.e. no record found
                                //Display No Records Found
                                $msg_string = "<h5>No result published yet!</h5>";
                                echo $msg_string;
                            } else { //If there are records in the results table
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
                                // SQL Query to load results from database with limit and offset
                                $query = "SELECT id, title, link, UNIX_TIMESTAMP(time_stamp) AS dated FROM tbl_results ORDER BY time_stamp DESC LIMIT $per_page OFFSET $offset;";
                                // Execute Query
                                $results = $clgdb->executeSql($query);
                                echo "<ol>";
                                while ($tupple = $results->fetch_assoc()) {
                                    $id = $tupple['id']; // result Id
                                    $title = $tupple['title']; // result Title
                                    $link =  $tupple['link']; // result Link
                                    $time_stamp = $tupple['dated']; // result Timestamp
                                    $formatted_date = date("d-M-Y", $time_stamp);
                                    $formatted_time = date("h:i A", $time_stamp);
                                    $formatted_time_stamp = "Dated : $formatted_date at $formatted_time";
                                    echo "
                            <li>
                                <div style=\"font-size:14px;font-weight:bold;\">$title</div>
                                <small>$formatted_time_stamp</small><br>
                                <a class=\"btn bg-green btn-xs\" target=\"_blank\" href=\"$link\" title=\"Open Link\"><i class=\"fa fa-link\"></i></a>
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
            </div>
        </div>
    </section>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>