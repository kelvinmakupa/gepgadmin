<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Common;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillingTempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Billing Temps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' List of Verified/UnApproved Bills') ?>
        <span class="pull-right"><strong><?=\app\models\TblBillingTemp::unApprovedBills()?></strong> - UnApproved Bills</span>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
        <p>
            <?=(Yii::$app->user->can('approveall-billing-temp'))?Html::a('<i class="fa fa-check"></i>  Approve All', ['approveall'], ['class' => 'btn btn-default']):'' ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last'
            ],
            'id' => 'grid',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

//          'file_uploaded_id',
//          'sp_system_id',
//          'payer',
                'payer_name',
                'bill_amount',
//                'bill_exp_date',
                'bill_description',
                'bill_gen_by',
//                'bill_appr_by',
//            'payer_cell_num',
//            'payer_email:email',
                'bill_currency',
                [
                    'attribute' => 'payment_type_id',
                    'value' => function ($model) {
                        return ($pay = $model->paymentType) ? $pay->acc_description : null;
                    }
                ],
                'bill_gen_date',
                'bill_id',
                'control_number',
                [
                    'attribute'=>'bill_pay_opt',
                    'format'=>'text',
                    'filter'=>\yii\helpers\ArrayHelper::map([['id'=>'1','name'=>'Pay in Full Only'],
                        ['id'=>'2','name'=>'Partial payment is allowed'],
                        ['id'=>'3','name'=>'Exact bill (Same as full but does not allow over or under payment)']],'id','name'),
                    'value'=>function($model){
                        return Common::getPaymentOption($model->bill_pay_opt);
                    }

                ],
                // 'use_on_pay',
                'bill_eqv_amount',
                'bill_item_ref',
                //'year_id',
                //'is_deleted',
                [
                    'attribute' => 'status',
                    'filter' => ArrayHelper::map(\app\models\TblBillingTemp::getStatuMessages(), 'id', 'name'),
                    'value' => function ($model) {
                        return \app\models\TblBillingTemp::getStatus($model->status);
                    }
                ],
                //'created_at',
                //'updated_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{verify} {approve}',// \app\models\MenuPanel::getActions(Yii::$app->controller->id),
                    'buttons' => [
                        'verify' => function ($url, $model, $key) {
                            return ($model->status == 2) ? Html::a('<i class="fa fa-2x fa-check"></i>', ['approve', 'id' => $model->id], ['title' => 'Approve & bill',
                                'data' => [
                                    'confirm' => 'Are you sure you want to approve and bill this bill item?',
                                    'method' => 'post',
                                ],
                            ]) : '';
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>
