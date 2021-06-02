<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblCancellation */

$this->title = 'Update Tbl Cancellation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Cancellations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-cancellation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
