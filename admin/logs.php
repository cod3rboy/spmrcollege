<?php
    // Set this variable to page title (No title if not set)
    $page_title = "Admin Logs";
    // Include Admin Panel header
    require('../templates/admin/header.php');
    // Clean Up all Logs which are more than 30 days old
    $thirty_days_ago = date("Y-m-d 00:00:00" , strtotime("now -30 days"));
    $clgdb->connect();
    if($clgdb->isConnected()){
        $delete_old_logs_query = "DELETE FROM tbl_admin_log WHERE last_time_login < \"$thirty_days_ago\" ;";
        $clgdb->executeSql($delete_old_logs_query);
        if(isset($_GET['clear'])){
            $clgdb->executeSql("DELETE FROM tbl_admin_log;");
        }
        $clgdb->disconnect();
    }
?>
<!-- Main Content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align:right;margin:5px;"><a class="btn bg-red btn-xs" href="?clear"><i class="fa fa-times"></i> Clear All</a></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div style="max-height:800px;overflow:auto;overflow-x:hidden;">
                        <table class="table-responsive" style="width:100%;font-size: 16px;">
                            <tr>
                                <th style="border-bottom:1px solid #eeeeee;">IP Address</th>
                                <th style="border-bottom:1px solid #eeeeee;">Last Time Login</th>
                            </tr>
                            <?php
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $logs_query = "SELECT ip_address, DATE_FORMAT(last_time_login, \"%d-%m-%Y %h:%i:%s %p\") as last_login FROM tbl_admin_log ORDER BY last_time_login DESC;";
                                $logs_result = $clgdb->executeSql($logs_query);
                                if($logs_result->num_rows){
                                    while($log = $logs_result->fetch_assoc()){
                                        $ip_address = $log['ip_address'];
                                        $time_stamp = $log['last_login'];
                                        echo "<tr><td>$ip_address</td><td>$time_stamp</td></tr>";
                                    }
                                }else{
                                    echo "<tr><td colspan=\"2\" style=\"font-size: 14px;\">No Logs Found</td></tr>";
                                }
                                $clgdb->disconnect();
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    //Include Admin Panel Footer
    require('../templates/admin/footer.php');
?>