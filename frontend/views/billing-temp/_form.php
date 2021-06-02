<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblBillingTemp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-billing-temp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file_uploaded_id')->textInput() ?>

    <?= $form->field($model, 'sp_system_id')->textInput() ?>

    <?= $form->field($model, 'payer')->textInput() ?>

    <?= $form->field($model, 'payer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_amount')->textInput() ?>

    <?= $form->field($model, 'bill_exp_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_gen_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_appr_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_cell_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_type_id')->textInput() ?>

    <?= $form->field($model, 'bill_gen_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'control_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_pay_opt')->textInput() ?>

    <?= $form->field($model, 'use_on_pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_eqv_amount')->textInput() ?>

    <?= $form->field($model, 'bill_item_ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_id')->textInput() ?>

    <?= $form->field($model, 'is_deleted')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
