<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\User;
use app\models\Banker;
use app\models\Transaction;
use app\models\Common;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- Info boxes -->
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Registered Users</span>
                <span class="info-box-number"><?=Common::getUsers()?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-bank"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Registered Companies</span>
                <span class="info-box-number"><?=Common::getRegisteredCompanies()?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only >
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-diamond"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Graduation Revenue</span>
                <span class="info-box-number"><?=Common::getGraduationRevenue()?></span>
            </div>
            <!--.info-box-content >
</div>
        <!-- /.info-box >
    </div-->

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>


<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-diamond"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total Revenue - <b>USD</b></span>
            <span class="info-box-number"><?= Common::getTotalRevenue('USD')?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
    <!-- /.col -->
    <?php
    //Common::getTotalRevenue('USD')
     ?>
      <div class="clearfix visible-sm-block"></div>

<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-diamond"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total Revenue - <b>TZS</b></span>
            <span class="info-box-number"><?=Common::getTotalRevenue('TZS')?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-list-ul"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Today's Transactions</span>
                <span class="info-box-number"><?=Common::getTodayTransaction() ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>

<!-- Main row -->
<div class="row">
<div class="col-md-8">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Transactions Line Chart - TZS</h3>

              <!--div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div-->
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart" style="height:350px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


        </div>
        <!-- /.col (RIGHT) -->
    <div class="col-md-4">
        <?php
            echo Common::getEachBank(2,'green');
            echo Common::getEachBank(3,'yellow');
            echo Common::getEachBank(4,'purple');
        ?>


</div>
</div>


        <?php
        $graph=Common::graph();
        $lables=json_encode($graph['labels']);
        $values=json_encode($graph['values']);

  $script = <<< JS
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    // var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    // var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : $lables,   
      datasets: [
        {
          label               : 'Transactions',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#f39c12',
          pointHighlightFill  : '#f56954',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : $values
        },
        
      ]
    }
 
    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.01)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: false,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }
    

    //Create the line chart
    // areaChart.Line(areaChartData, areaChartOptions)
   
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    lineChartOptions.datasetFill = false
    lineChart.Line(areaChartData, lineChartOptions)

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    // var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    // var pieChart       = new Chart(pieChartCanvas)
    

   
  })
JS;
$this->registerJs($script);
?>