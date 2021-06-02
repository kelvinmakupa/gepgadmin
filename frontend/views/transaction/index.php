<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">





    <div class="panel-heading">
        <i class="fa fa-diamond"></i><?= Html::encode(' Received Transaction') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="panel-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
           // 'bill_id',
            'trx_id',
            'pay_ref_id',
            'pay_control_num',
//            'bill_amount',
            'paid_amount',
//            'bill_pay_opt',
//            [
//                'attribute'=>'bill_pay_opt',
//                'format'=>'text',
//                'value'=>function($model){
//                 return app\models\Common::getPaymentOption($model->bill_pay_opt);
//                }
//            ],
            'ccy',
            'trx_dt_tm',
            //'usd_pay_channel',
            //'payer_cell_num',
            //'payer_name',
            //'payer_email:email',
            //'psp_receipt_num',
            'psp_name',
            'ctr_acc_num',
            [
                'attribute'=>'trx_status',
                'format'=>'raw',
                'filter'=>ArrayHelper::map([['id'=>1,'name'=>'OK'],['id'=>2,'name'=>'Reversed']],'id','name'),
                'value'=>function($model){
                    return ($model->trx_status==1)?'<i class="fa fa-2x fa-check text-success"></i>':'<i class="fa fa-2x fa-reply text-danger"></i>';
                }

            ],
            'received_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
</div>
