<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = 'Transaction Management';
$this->params['breadcrumbs'][] = ['label' => 'Available Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">

        <i class="fa fa-diamond"></i><?= Html::encode(' Transaction Details') ?></div>
<div class="panel-body">
    <p>
        <?= Html::a('Print Receipt', ['receipt', 'id' => $model->id], ['class' => 'btn btn-cons btn-primary']) ?>
        <?= \app\models\Common::checkSpSystem($model->pay_control_num)? Html::a(' <i class="fa fa-cloud-upload"></i> Send to SP System', ['sp-system', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('update-transaction'))?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('reverse-transaction'))?Html::a($model->trx_status==1?'Reverse Transaction':'Return Transaction to OK', ['reverse', 'id' => $model->id,'trx_status'=>base64_encode($model->trx_status==1?2:1)], ['class' => $model->trx_status==1?'btn btn-cons btn-danger':'btn btn-cons btn-success']):'' ?>
        <?= (Yii::$app->user->can('delete-transaction'))?Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this transaction item?',
                'method' => 'post',
            ],
        ]):'' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'bill_id',
            'trx_id',
            'pay_ref_id',
            'pay_control_num',
            'bill_amount',
            'paid_amount',
//            'bill_pay_opt',
            [
                'attribute'=>'bill_pay_opt',
                'format'=>'text',
                'value'=> \app\models\Common::getPaymentOption($model->bill_pay_opt),
            ],
            'ccy',
            'trx_dt_tm',
            'usd_pay_channel',
            'payer_cell_num',
            'payer_name',
            'payer_email:email',
            'psp_receipt_num',
            'psp_name',
            'ctr_acc_num',
            [
                'attribute'=>'trx_status',
                'format'=>'raw',
                'value'=> ($model->trx_status==1)?'<i class="fa fa-2x fa-check text-success"></i>':'<i class="fa fa-2x fa-reply text-danger"></i>',

            ],
            'received_date',
        ],
    ]) ?>

</div>
</div>
