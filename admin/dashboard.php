<?php
    // Set this variable to Page title (No Title if not set)
    $page_title = "Dashboard";
    // Set this to true to load some dashboard page specific javascript files (Set this only in dashboard page)
    $is_dashboard = true;
    // Include Admin Panel Header
    require('../templates/admin/header.php');
    $current_month = (int) date('m');
    $current_year = (int) date('Y');
    $start_date = DateTime::createFromFormat("m/d/Y H-i-s","$current_month/01/$current_year 00-00-00");
    define("MONTH_START_TIMESTAMP", $start_date->getTimestamp());
?>
<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-bell-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Updates</span>
                    <span class="info-box-number">
                        <?php
                        $clgdb->connect();
                        if($clgdb->isConnected()){
                            $max_time_stamp = date("Y-m-d H:i:s", MONTH_START_TIMESTAMP);
                            $this_month_updates = $clgdb->executeSql("SELECT * FROM tbl_updates WHERE time_stamp > \"$max_time_stamp\" ;")->num_rows;
                            echo "$this_month_updates";
                            $clgdb->disconnect();
                        }
                        ?>
                    </span>
                    <span class="info-box-text" style="font-size:11px;">This Month</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box"> <span class="info-box-icon bg-blue"><i class="fa fa-info-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Notifications</span>
                    <span class="info-box-number">
                        <?php
                        $clgdb->connect();
                        if($clgdb->isConnected()){
                            $max_time_stamp = date("Y-m-d H:i:s", MONTH_START_TIMESTAMP);
                            $this_month_notifications = $clgdb->executeSql("SELECT * FROM tbl_notification WHERE time_stamp > \"$max_time_stamp\" ;")->num_rows;
                            echo "$this_month_notifications";
                            $clgdb->disconnect();
                        }
                        ?>
                    </span>
                    <span class="info-box-text" style="font-size:11px;">This Month</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-photo"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Gallery</span>
                    <span class="info-box-number">
                        <?php
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $total_images = $clgdb->executeSql("SELECT * FROM tbl_gallery;")->num_rows;
                                echo $total_images;
                                $clgdb->disconnect();
                            }
                        ?>
                    </span>
                    <span class="info-box-text" style="font-size:11px;">Total Images</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box"> <span class="info-box-icon bg-purple"><i class="fa fa-envelope-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Grievances</span>
                    <span class="info-box-number">
                        <?php
                        $clgdb->connect();
                        if($clgdb->isConnected()){
                            $max_time_stamp = date("Y-m-d H:i:s", MONTH_START_TIMESTAMP);
                            $this_month_grievances = $clgdb->executeSql("SELECT * FROM tbl_feedback WHERE time_stamp > \"$max_time_stamp\" ;")->num_rows;
                            echo "$this_month_grievances";
                            $clgdb->disconnect();
                        }
                        ?>
                    </span>
                    <span class="info-box-text" style="font-size:11px;">This Month</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Website Hits Report</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-center"> <strong>Website Hits : <?php echo date("d/m/Y", strtotime("now -6 days")) . " - " . date("d/m/Y");?></strong> </p>
                            <div class="chart">
                                <!-- PageHitsChart Chart Canvas -->
                                <canvas id="pageHitsChart" style="height: 200px;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <h2 class="text-center"> <strong><i class="fa fa-eye"></i> Total Views</strong> </h2>
                            <h1 class="text-center">
                            <?php
                            $clgdb->connect();
                            if($clgdb->isConnected()){
                                $total_views = $clgdb->executeSql("SELECT * FROM tbl_visitor;")->num_rows;
                                echo $total_views;
                                $clgdb->disconnect();
                            }
                            ?>
                            </h1>
                            <h4 class="text-center" style="color:#AAAAAA">Views</h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<?php
    //Include Admin Panel Footer
    require('../templates/admin/footer.php');
?>