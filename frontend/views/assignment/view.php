<?php

use mdm\admin\AnimateAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;




$this->title =  'Admin Panel';

$this->params['breadcrumbs'][] = ['label' =>  'Access Assignment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $user_details->first_name.' '.$user_details->last_name;

$opts = Json::htmlEncode([
    'items' => $model->getItems($user_details->id),
]);

$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-eye"></i> <?=' Assignment' . ' : ' . $user_details->username?>
    </div>
    <div class="panel-body">
    <div class="row">
        <div class="col-sm-5">
            <input class="form-control search" data-target="available"
                   placeholder="<?='Search for available'?>">
            <select multiple size="20" class="form-control list" data-target="available">
            </select>
        </div>
        <div class="col-sm-1">
            <br><br>
            <?=Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => $user_details->id], [
                'class' => 'btn btn-success btn-assign',
                'data-target' => 'available',
                'title' => 'Assign',
            ]);?><br><br>
            <?=Html::a('&lt;&lt;' . $animateIcon, ['revoke', 'id' => $user_details->id], [
                'class' => 'btn btn-danger btn-assign',
                'data-target' => 'assigned',
                'title' =>  'Remove',
            ]);?>
        </div>
        <div class="col-sm-5">
            <input class="form-control search" data-target="assigned"
                   placeholder="<?='Search for assigned'?>">
            <select multiple size="20" class="form-control list" data-target="assigned">
            </select>
        </div>
    </div>
</div>
</div>
