<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bill_id') ?>

    <?= $form->field($model, 'trx_id') ?>

    <?= $form->field($model, 'pay_ref_id') ?>

    <?= $form->field($model, 'pay_control_num') ?>

    <?php // echo $form->field($model, 'bill_amount') ?>

    <?php // echo $form->field($model, 'paid_amount') ?>

    <?php // echo $form->field($model, 'bill_pay_opt') ?>

    <?php // echo $form->field($model, 'ccy') ?>

    <?php // echo $form->field($model, 'trx_dt_tm') ?>

    <?php // echo $form->field($model, 'usd_pay_channel') ?>

    <?php // echo $form->field($model, 'payer_cell_num') ?>

    <?php // echo $form->field($model, 'payer_name') ?>

    <?php // echo $form->field($model, 'payer_email') ?>

    <?php // echo $form->field($model, 'psp_receipt_num') ?>

    <?php // echo $form->field($model, 'psp_name') ?>

    <?php // echo $form->field($model, 'ctr_acc_num') ?>

    <?php // echo $form->field($model, 'received_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
