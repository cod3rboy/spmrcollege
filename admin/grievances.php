<?php
// Set this variable to page title (No title if not set)
$page_title = "Grievances / Feedback";
// Include Admin Panel header
require('../templates/admin/header.php');
?>

<?php
// Function to delete grievance with given id
function deleteGrievance($id, $clgdb){
    $clgdb->connect();
    if($clgdb->isConnected()){
        $clgdb->executeSql("DELETE FROM tbl_feedback WHERE id=$id ;");
        $clgdb->disconnect();
    }
}
?>
<?php
// Function to display grievance with given id
function viewGrievance($id, $clgdb){
    $clgdb->connect();
    if($clgdb->isConnected()){
        $record = $clgdb->executeSql("SELECT id, name, email_id, title, description, is_read, DATE_FORMAT(time_stamp, \"On %d-%b-%Y at %h:%i %p\") as date_submitted FROM tbl_feedback WHERE id=$id ;");
        if ($record) {
            while ($row = $record->fetch_assoc()) {
                $_id = $row['id'];
                $name = $row['name'];
                $email_id = $row['email_id'];
                $title = $row['title'];
                $desc = $row['description'];
                $is_read = $row['is_read'];
                $timestamp = $row['date_submitted'];
                ?>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <div class="box-title"><?php echo $title; ?><br></div>
                                    <div style="font-size:12px;color:#999999"><?php echo $timestamp; ?></div>
                                     <a class="btn bg-red btn-xs"
                                           href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?delete=" . $_id; ?>"><i
                                                    class="fa fa-times"></i> Delete</a>
                                    <a class="btn bg-green btn-xs" href="grievances.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                </div>
                                <div class="box-body">
                                    <p>
                                        <?php echo $desc; ?>
                                    </p>
                                </div>
                                <div class="box-footer">
                                    Submitted By :-
                                    <?php echo $name; ?><br>Email ID : <?php echo $email_id; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
                if (!$is_read) {
                    $clgdb->executeSql("UPDATE tbl_feedback SET is_read = 1 WHERE id=$_id ;");
                }
            }
        }else{
            echo "<section class=\"content\"><h4>No Records Found</h4></section>";
        }
        $clgdb->disconnect();
    }
}
?>
<?php
    // Delete Grievance
    if(isset($_GET['delete'])){
        $grievance_id = (int) $_GET['delete'];
        deleteGrievance($grievance_id, $clgdb);
    }

    // View Grievance
    if(isset($_GET['view'])){
        $grievance_id = (int) $_GET['view'];
        viewGrievance($grievance_id, $clgdb);
    }else{
        ?>
        <!-- Main Content -->
        <section class="content">
            <div style="max-height:550px;overflow:auto;overflow-x:hidden;">
                <?php
                $clgdb->connect();
                if($clgdb->isConnected()){
                    $query_grievances = "SELECT id, title, DATE_FORMAT(time_stamp, \"On %d-%b-%Y at %h:%i %p\") As date_submitted, is_read FROM tbl_feedback ORDER BY time_stamp DESC;";
                    $results = $clgdb->executeSql($query_grievances);
                    if($results->num_rows){
                        while($row = $results->fetch_assoc()){
                            $id = $row['id'];
                            $title = $row['title'];
                            $timestamp = $row['date_submitted'];
                            $read = $row['is_read'];
                            $color_property = ($read)? "bg-gray" : "" ;
                            echo "<div class=\"box box-primary $color_property\">
                                <div class=\"box-body\">
                                    <div class=\"row\">
                                        <div class=\"col-xs-3 col-sm-2\"><a class=\"btn bg-green btn-xs\" href=\"".htmlspecialchars($_SERVER['PHP_SELF'])."?view=$id\"><i class=\"fa fa-eye\"></i> Read</a><br><a class=\"btn bg-red btn-xs\" href=\"".htmlspecialchars($_SERVER['PHP_SELF'])."?delete=$id\"><i class=\"fa fa-times\"> Delete</i></a></div>
                                        <div class=\"col-xs-9 col-sm-8\"><div style=\"font-size:16px;font-weight:bold;\">$title</div><small>$timestamp</small></div>
                                    </div>
                                </div>
                           </div>";
                        }
                    }else{
                        echo "<h4>No Records Found</h4>";
                    }
                    $clgdb->disconnect();
                }
                ?>
            </div>
        </section>
        <?php
    }
?>
<?php
//Include Admin Panel Footer
require('../templates/admin/footer.php');
?>