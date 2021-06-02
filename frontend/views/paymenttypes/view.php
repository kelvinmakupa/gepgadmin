<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblPaymentTypes */

$this->title = 'Payment Types';
$this->params['breadcrumbs'][] = ['label' => 'Available Payment Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-eye"></i><?= Html::encode(' Payment Type Details') ?>

    </div>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('update-paymenttypes'))?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('delete-paymenttypes'))?Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):'' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'acc_code',
            'acc_description',
            'gfs_code',
            'gfs_description',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
</div>
