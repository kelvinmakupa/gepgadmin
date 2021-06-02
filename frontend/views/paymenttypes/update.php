<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblPaymentTypes */

$this->title = 'Payment Types';
$this->params['breadcrumbs'][] = ['label' => 'Available Payment Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->acc_code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-info">

    <div class="panel-heading"><i class="fa fa-edit"></i><?= Html::encode(' Update Details') ?></div>
<div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
