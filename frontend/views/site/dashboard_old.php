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

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-diamond"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Graduation Revenue</span>
                <span class="info-box-number"><?=Common::getGraduationRevenue()?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-diamond"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total Revenue</span>
            <span class="info-box-number"><?=Common::getTotalRevenue()?></span>
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


   
