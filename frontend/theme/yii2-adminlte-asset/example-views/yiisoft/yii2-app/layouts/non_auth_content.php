<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use app\models\ThemeManager;
use yii\helpers\Html;
use kartik\nav\NavX;
use yii\bootstrap\Nav;
$obj=\app\models\SystemSetting::find()->one();
?>

<div class="content-wrapper" style="background-color: #ffffff" >


    <section class="content">

        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
<div class="container">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>

    <strong class="hidden-xs">Copyright &copy; <?=date('Y')?><a href="" > <?=$obj->sys_name?></a> All rights reserved.</strong>
    <strong class="visible-xs">Copyright &copy; <?=date('Y')?><a href="" > <?=$obj->sys_name?></a> All rights reserved.</strong>
</div>
</footer>