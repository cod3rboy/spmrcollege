<?php
    // Initializing data before loading page views chart

    // Last 7 days unix timestamps
    $today =  date("M"). " ". date("d"). ", " . date("Y");
    $today_date = strtotime($today);
    $yesterday_date = strtotime($today." -1 day");
    $third_date = strtotime($today." -2 days");
    $fourth_date = strtotime($today." -3 days");
    $fifth_date = strtotime($today." -4 days");
    $sixth_date = strtotime($today." -5 days");
    $seventh_date = strtotime($today." -6 days");
    // MySQL database Formatted last 7 days dates
    define("TODAY_DAY", date("Y-m-d", $today_date)." 00:00:00"); // Today Date
    define("YESTERDAY_DAY", date("Y-m-d", $yesterday_date)." 00:00:00"); // Yesterday
    define("THIRD_DAY", date("Y-m-d", $third_date)." 00:00:00");
    define("FOURTH_DAY", date("Y-m-d", $fourth_date)." 00:00:00");
    define("FIFTH_DAY", date("Y-m-d", $fifth_date)." 00:00:00");
    define("SIXTH_DAY", date("Y-m-d", $sixth_date)." 00:00:00");
    define("SEVENTH_DAY", date("Y-m-d", $seventh_date)." 00:00:00");
    $clgdb->connect();
    if($clgdb->isConnected()){
        // Query No of Views in last 7 days
        $seventh_day_views = (int)$clgdb->executeSql("SELECT * FROM tbl_visitor WHERE time_stamp BETWEEN \"". SEVENTH_DAY . "\" AND \"" . SIXTH_DAY . "\" ;")->num_rows;
        $sixth_day_views = (int)$clgdb->executeSql("SELECT * FROM tbl_visitor WHERE time_stamp BETWEEN \"". SIXTH_DAY . "\" AND \"" . FIFTH_DAY . "\" ;")->num_rows;
        $fifth_day_views = (int) $clgdb->executeSql("SELECT * FROM tbl_visitor WHERE time_stamp BETWEEN \"". FIFTH_DAY. "\" AND \"" . FOURTH_DAY . "\" ;")->num_rows;
        $fourth_day_views = (int)$clgdb->executeSql("SELECT * FROM tbl_visitor WHERE time_stamp BETWEEN \"". FOURTH_DAY . "\" AND \"" . THIRD_DAY . "\" ;")->num_rows;
        $third_day_views = (int) $clgdb->executeSql("SELECT * FROM tbl_visitor WHERE time_stamp BETWEEN \"". THIRD_DAY . "\" AND \"" . YESTERDAY_DAY . "\" ;")->num_rows;
        $second_day_views = (int) $clgdb->executeSql("SELECT * FROM tbl_visitor WHERE time_stamp BETWEEN \"". YESTERDAY_DAY . "\" AND \"" . TODAY_DAY . "\" ;")->num_rows;
        $ist_day_views = (int) $clgdb->executeSql("SELECT * FROM tbl_visitor WHERE time_stamp > \"" . TODAY_DAY . "\" ;")->num_rows;
        $clgdb->disconnect();
    }
?>
<!-- Page Views Chart Script -->
<script type="text/javascript">
    $(function () {
        'use strict';

        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //---------------------------------
        //- WEEKLY Website Visitors Chart -
        //---------------------------------

        // Get context with jQuery - using jQuery's .get() method.
        var pageHitsChartCanvas = $("#pageHitsChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var pageHitsChart = new Chart(pageHitsChartCanvas);

        var pageHitsChartData = {
            // X-Axis Labels ( Last 7 Days dates )
            labels: [
                "<?php echo date("M d, Y", $seventh_date) ?>",
                "<?php echo date("M d, Y", $sixth_date) ?>",
                "<?php echo date("M d, Y", $fifth_date) ?>",
                "<?php echo date("M d, Y", $fourth_date) ?>",
                "<?php echo date("M d, Y", $third_date) ?>",
                "<?php echo date("M d, Y", $yesterday_date) ?>",
                "<?php echo date("M d, Y", $today_date) ?>"
            ],
            datasets: [
                {
                    label: "Visitors",
                    fillColor: "rgb(210, 214, 222)",
                    strokeColor: "rgb(210, 214, 222)",
                    pointColor: "rgb(210, 214, 222)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgb(220,220,220)",
                    // Y-Axis Values ( No of page views)
                    data: [
                        <?php
                        echo $seventh_day_views. " ,";
                        echo $sixth_day_views. " ,";
                        echo $fifth_day_views. " ,";
                        echo $fourth_day_views. " ,";
                        echo $third_day_views. " ,";
                        echo $second_day_views. " ,";
                        echo $ist_day_views;
                        ?>
                    ]
                }
            ]
        };

        var pageHitsChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };

        //Create the line chart
        pageHitsChart.Line(pageHitsChartData, pageHitsChartOptions);

        //---------------------------
        //- END WEEKLY PAGE HITS CHART -
        //---------------------------


        /* SPARKLINE CHARTS
         * ----------------
         * Create a inline charts with spark line
         */

        //-----------------
        //- SPARKLINE BAR -
        //-----------------
        $('.sparkbar').each(function () {
            var $this = $(this);
            $this.sparkline('html', {
                type: 'bar',
                height: $this.data('height') ? $this.data('height') : '30',
                barColor: $this.data('color')
            });
        });

        //-----------------
        //- SPARKLINE PIE -
        //-----------------
        $('.sparkpie').each(function () {
            var $this = $(this);
            $this.sparkline('html', {
                type: 'pie',
                height: $this.data('height') ? $this.data('height') : '90',
                sliceColors: $this.data('color')
            });
        });

        //------------------
        //- SPARKLINE LINE -
        //------------------
        $('.sparkline').each(function () {
            var $this = $(this);
            $this.sparkline('html', {
                type: 'line',
                height: $this.data('height') ? $this.data('height') : '90',
                width: '100%',
                lineColor: $this.data('linecolor'),
                fillColor: $this.data('fillcolor'),
                spotColor: $this.data('spotcolor')
            });
        });
    });
</script>
