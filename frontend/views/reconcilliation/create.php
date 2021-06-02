<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TblReconcilliation */

$this->title = 'Reconcilliation Panel';
$this->params['breadcrumbs'][] = ['label' => 'Available Reconcilliations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-plus"></i><?= Html::encode(' Reconcilliation') ?></div>
<div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
</div>
