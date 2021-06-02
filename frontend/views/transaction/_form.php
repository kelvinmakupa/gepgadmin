<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bill_id')->textInput() ?>

    <?= $form->field($model, 'trx_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_ref_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_control_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_amount')->textInput() ?>

    <?= $form->field($model, 'paid_amount')->textInput() ?>

    <?= $form->field($model, 'bill_pay_opt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ccy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trx_dt_tm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usd_pay_channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_cell_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'psp_receipt_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'psp_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ctr_acc_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'received_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
