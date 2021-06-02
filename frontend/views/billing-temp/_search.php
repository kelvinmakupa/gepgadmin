<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BillingTempSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-billing-temp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'file_uploaded_id') ?>

    <?= $form->field($model, 'sp_system_id') ?>

    <?= $form->field($model, 'payer') ?>

    <?= $form->field($model, 'payer_name') ?>

    <?php // echo $form->field($model, 'bill_amount') ?>

    <?php // echo $form->field($model, 'bill_exp_date') ?>

    <?php // echo $form->field($model, 'bill_description') ?>

    <?php // echo $form->field($model, 'bill_gen_by') ?>

    <?php // echo $form->field($model, 'bill_appr_by') ?>

    <?php // echo $form->field($model, 'payer_cell_num') ?>

    <?php // echo $form->field($model, 'payer_email') ?>

    <?php // echo $form->field($model, 'bill_currency') ?>

    <?php // echo $form->field($model, 'payment_type_id') ?>

    <?php // echo $form->field($model, 'bill_gen_date') ?>

    <?php // echo $form->field($model, 'bill_id') ?>

    <?php // echo $form->field($model, 'control_number') ?>

    <?php // echo $form->field($model, 'bill_pay_opt') ?>

    <?php // echo $form->field($model, 'use_on_pay') ?>

    <?php // echo $form->field($model, 'bill_eqv_amount') ?>

    <?php // echo $form->field($model, 'bill_item_ref') ?>

    <?php // echo $form->field($model, 'year_id') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
