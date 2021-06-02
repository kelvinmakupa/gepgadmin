<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */

$this->title = 'Billing Management';
$this->params['breadcrumbs'][] = ['label' => 'Available Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_description, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Update Bill Info') ?></div>
    <div class="panel-body">
    <?= $this->render('_update', [
        'model' => $model,
    ]) ?>

</div>
</div>
