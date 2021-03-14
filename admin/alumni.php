<?php
// Set this variable to page title (No title if not set)
$page_title = "Alumni";
// Include Admin Panel header
require('../templates/admin/header.php');
?>
<!-- Main Content -->
<section class="content">
    <?php
    if(isset($_GET['verify'])){ // When verify Action is set
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id = (int) $_GET['verify']; // Get Alumni Record ID
            $clgdb->executeSql("UPDATE tbl_alumni SET is_verified = 1 WHERE id=$id ;"); // Set it to verified
            $rows_affected = mysqli_affected_rows($clgdb->conn);
            if($rows_affected != 0 && $rows_affected != -1 ){ // When verification is successful
                echo "<div class=\"callout callout-success\"><p>Alumni Record Verified!</p></div>";
            }
            $clgdb->disconnect();
        }
    }

    if(isset($_GET['delete'])){ // When Delete action is set
        $clgdb->connect();
        if($clgdb->isConnected()){
            $id = (int) $_GET['delete']; // Get Alumni Record ID
            $result = $clgdb->executeSql("SELECT photo_path FROM tbl_alumni WHERE id= $id ;"); // Get Photo Path of record
            $photo_path = "";
            while($row = $result->fetch_assoc()){
                $photo_path = $row['photo_path'];
            }
            $clgdb->executeSql("DELETE FROM tbl_alumni WHERE id = $id ;"); // Delete Record
            $rows_affected = mysqli_affected_rows($clgdb->conn);
            if($rows_affected != 0 && $rows_affected != -1){ // When Record Deleted
                if(!substr_count($photo_path, "nophoto.png")){
                    // Delete Photo if exists
                    if(file_exists($photo_path)) unlink($photo_path);
                }
                echo "<div class=\"callout callout-danger\"><p>Alumni Record Deleted!</p></div>";
                $alumni_records_pending = $clgdb->executeSql("SELECT * FROM tbl_alumni WHERE is_verified = 0 ;")->num_rows;
            }
            $clgdb->disconnect();
        }
    }
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Pending records for verification <?php if($alumni_records_pending) echo "($alumni_records_pending)"; ?></div></div>
                <div class="box-body">
                    <?php
                    $clgdb->connect();
                    if($clgdb->isConnected()){
                        // Get Unverified Records
                        $alumni_query = "SELECT * FROM tbl_alumni  WHERE is_verified = 0 ORDER BY id DESC ;";
                        $result = $clgdb->executeSql($alumni_query);
                        if($result->num_rows){
                            // Generate list of unverified records with verify, delete and view action buttons
                            while($row = $result->fetch_assoc()){
                                $id = $row['id'];
                                $name = $row['name'];
                                $stream = $row['stream'];
                                $batch = $row['batch_year'];
                                $address = $row['address'];
                                $contact = $row['contact_no'];
                                $status = $row['current_status'];
                                $email = $row['email_id'];
                                $photo_path = $row['photo_path'];
                                ?>
                                <div class="col-md-4">
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="media-heading" style="font-size:16px;">
                                                <strong><?php echo $name; ?></strong> <i class="fa fa-exclamation-circle" style="color:#FF9933;"></i><br>
                                                <small><?php echo $stream . " ( $batch )";?></small>
                                            </div>
                                            <p>
                                                <a class="btn bg-blue btn-xs" title="View Record" data-toggle="modal" data-target="#alumniModal<?php echo $id;?>"><i class="fa fa-eye"></i></a>
                                                <a class="btn bg-green btn-xs" title="Verify" href="?verify=<?php echo $id; ?>"><i class="fa fa-check"></i></a>
                                                <a class="btn bg-red btn-xs" title="Delete" href="?delete=<?php echo $id; ?>"><i class="fa fa-times"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                     <div class="modal fade" id="alumniModal<?php echo $id; ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn bg-red btn-xs pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                                    <div class="modal-title"><div style="font-size:16px;font-weight:bold;">Alumni Contact Details</div></div>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <img class="media-object" src="<?php echo $photo_path; ?>" alt="Alumni Contact Photo">
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading"><?php echo $name; ?></h4>
                                                            <p>
                                                                <small><strong>Stream : </strong><?php echo $stream . " ( $batch )"; ?></small><br>
                                                                <small><strong>Status : </strong><?php echo $status; ?></small><br>
                                                                <small><strong>Contact : </strong>+91-<?php echo $contact; ?></small><br>
                                                                <small><strong>Email : </strong><?php echo $email; ?></small><br>
                                                                <small><strong>Address : </strong><?php echo $address; ?></small><br>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }else{
                            echo "<div style=\"color:#AAAAAA;font-size:14px;\"><i class=\"fa fa-info-circle\"></i> No record pending for verification!</div>";
                        }
                        $clgdb->disconnect();
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header"><div class="box-title">Verified Alumni Records</div></div>
                <div class="box-body">
                    <?php
                    // Declaring Pagination variable
                    // Tracks current page number initially set to first page
                    $current_page = 1;
                    // Stores no of records to display per page
                    $per_page = 12;
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
                    if($clgdb->isConnected()){
                        // Query String to get total records in the alumni table
                        $total_rec_query = "SELECT * FROM tbl_alumni WHERE is_verified = 1;";
                        // Execute query and get no of rows
                        $total_rec = $clgdb->executeSql($total_rec_query)->num_rows;
                        if ($total_rec == 0) { //If there is no row i.e. no record found
                            //Display No Records Found
                            echo "<div style=\"color:#AAAAAA;font-size:14px;\"><i class=\"fa fa-info-circle\"></i> No Verified Record Found!</div>";
                        } else {
                            //If there are records in the alumni table
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
                            // SQL Query to load alumni records from database with limit and offset
                            $verified_recs_query = "SELECT * FROM tbl_alumni WHERE is_verified = 1 ORDER BY id DESC LIMIT $per_page OFFSET $offset;";
                            // Execute Query
                            $result = $clgdb->executeSql($verified_recs_query);
                            if($result && $result->num_rows > 0){
                                // Generate list of verified records with delete and view action buttons
                                while($row = $result->fetch_assoc()){
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $stream = $row['stream'];
                                    $batch = $row['batch_year'];
                                    $address = $row['address'];
                                    $contact = $row['contact_no'];
                                    $status = $row['current_status'];
                                    $email = $row['email_id'];
                                    $photo_path = $row['photo_path'];
                                    ?>
                                    <div class="col-md-4">
                                        <div class="media">
                                            <div class="media-body">
                                                <div class="media-heading" style="font-size:16px;">
                                                    <strong><?php echo $name; ?></strong> <i class="fa fa-check-circle-o" style="color:#00AA00;"></i><br>
                                                    <small><?php echo $stream . " ( $batch )";?></small>
                                                </div>
                                                <p>
                                                    <a class="btn bg-blue btn-xs" title="View Record" data-toggle="modal" data-target="#alumniModal<?php echo $id;?>"><i class="fa fa-eye"></i></a>
                                                    <a class="btn bg-red btn-xs" title="Delete" href="?delete=<?php echo $id; ?>"><i class="fa fa-times"></i></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="alumniModal<?php echo $id; ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn bg-red btn-xs pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                                    <div class="modal-title"><div style="font-size:16px;font-weight:bold;">Alumni Contact Details</div></div>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <img class="media-object" src="<?php echo $photo_path; ?>" alt="Alumni Contact Photo">
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading"><?php echo $name; ?></h4>
                                                            <p>
                                                                <small><strong>Stream : </strong><?php echo $stream . " ( $batch )"; ?></small><br>
                                                                <small><strong>Status : </strong><?php echo $status; ?></small><br>
                                                                <small><strong>Contact : </strong>+91-<?php echo $contact; ?></small><br>
                                                                <small><strong>Email : </strong><?php echo $email; ?></small><br>
                                                                <small><strong>Address : </strong><?php echo $address; ?></small><br>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
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
                        $clgdb->disconnect();
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