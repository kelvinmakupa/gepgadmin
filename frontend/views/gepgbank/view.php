<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GepgBank */

$this->title = 'Banks Management';
$this->params['breadcrumbs'][] = ['label' => 'Available Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class='panel-heading'>
        <i class='fa fa-eye-o'></i><?= Html::encode(' Bank Details') ?></div>
<div class="panel-body">
    <p>
        <?= Yii::$app->user->can('update-gepgbank')?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= Yii::$app->user->can('delete-gepgbank')?Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'beneficiary_name',
            'bank_name',
            'account_name',
            'account_number',
            'swift_code',
            'acc_currency',
            // 'is_visible',
            [
                'attribute'=>'is_visible',
                'value'=>($model->is_visible==10)?'Visible':'Invisible'
            ],
            'created_at',
        ],
    ]) ?>
</div>
</div>
