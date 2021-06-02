<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblBillingTemp */

$this->title = 'Update Tbl Billing Temp: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Billing Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-billing-temp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
