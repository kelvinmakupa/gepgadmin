<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblBillingTemp */

$this->title = 'Temp Bills';
$this->params['breadcrumbs'][] = ['label' => 'Billing Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->payer_name;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-eye"></i><?= Html::encode(' View Bill Details') ?></div>
    <div class="panel-body">
        <p>
            <?= (Yii::$app->user->can('update-billing-temp'))?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
            <?= (Yii::$app->user->can('delete-billing-temp'))?Html::a('Delete', ['delete', 'id' => $model->id], [
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
                // 'file_uploaded_id',
                // 'sp_system_id',
                //  'payer',
                'payer_name',
                'bill_amount',
                'bill_exp_date',
                'bill_description',
                'bill_gen_by',
                'bill_appr_by',
                'payer_cell_num',
                'payer_email:email',
                'bill_currency',
                'payment_type_id',
                'bill_gen_date',
                'bill_id',
                'control_number',
                'bill_pay_opt',
                'use_on_pay',
                'bill_eqv_amount',
                'bill_item_ref',
                'year_id',
//            'is_deleted',
                'status',
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>
</div>
