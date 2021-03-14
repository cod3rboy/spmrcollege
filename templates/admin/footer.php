</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right"> Panel Designed By <b><a href="../home/developers.php">B.C.A. Students</a></b>, SPMR College of Commerce </div> <strong>Copyright &copy; 2017-2018 SPMR College of Commerce.</strong></footer>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../js/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../js/admin/app.min.js"></script>
<!-- Sparkline -->
<script src="../js/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="../js/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="../js/admin/plugins/chartjs/Chart.min.js"></script>
    <?php
    // Load page views chart script in the dashboard
    if(isset($is_dashboard)) {
        if ($is_dashboard) {
            //Load Page Views Chart in the Dashboard Page
            require('page_views_chart.php');
        }
    }

    // Conditionally load light box scripts (Load only in the photo gallery web pages)
    if(isset($load_light_box)){
        if($load_light_box){
            // load light box js
            echo "<script type=\"text/javascript\" src=\"../js/ekko-lightbox.js\"></script>";
            echo "<script type=\"text/javascript\" src=\"../js/admin/load_lightbox.js\"></script>";
        }
    }
    ?>
</body>
<!-- End Body -->
</html>
<!-- End HTML -->