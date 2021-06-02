<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TblPaymentTypes */

$this->title = 'Payment Types';
$this->params['breadcrumbs'][] = ['label' => 'Available Payment Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-plus"></i><?= Html::encode(' Add Payment Type') ?></div>
    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
