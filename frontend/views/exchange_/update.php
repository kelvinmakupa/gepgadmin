<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExchangeRate */

$this->title = 'Exchange Rate';
$this->params['breadcrumbs'][] = ['label' => 'Exchange Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->currency, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-edit"></i><?= Html::encode(' Update Details') ?></div>
<div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
