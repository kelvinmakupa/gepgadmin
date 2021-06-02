<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Common;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */
/* @var $form yii\widgets\ActiveForm */

//print_r(Common::getNames());
?>

<div class="tbl-billing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_amount')->textInput() ?>

    <?= $form->field($model, 'bill_exp_date')->textInput() ?>

    <?= $form->field($model, 'bill_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_gen_by')->textInput(['maxlength' => true,'value'=>Common::getNames()]) ?>

    <?= $form->field($model, 'bill_appr_by')->textInput(['maxlength' => true,'value'=>Common::getNames()]) ?>

    <?= $form->field($model, 'payer_cell_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_currency')->dropDownList(['TZS'=>'TZS','USD'=>'USD'],['placeholder'=>'Please select currency']) ?>

    <?= $form->field($model, 'payment_type_id')->textInput() ?>

    <?= $form->field($model, 'company_id')->textInput() ?>

    <?= $form->field($model, 'bill_gen_date')->textInput() ?>

    <?= $form->field($model, 'bill_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'control_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_pay_opt')->widget(Select2::classname(), [
        // 'data' => array('TZS'=>'TZS','USD'=>'USD'),// array('1'=>'Pay in Full Only','2'=>'Partial payment is allowed','3'=>'Exact bill(Same as full but does not allow over od under payment'),
        'data' => ArrayHelper::map(array(['id'=>'1','name'=>'Pay in Full Only'],['id'=>'2','name'=>'Partial payment is allowed'],['id'=>'3','name'=>'Exact bill(Same as full but does not allow over od under payment','id','name']),'id','name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select a payment option ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'use_on_pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_eqv_amount')->textInput() ?>

    <?= $form->field($model, 'bill_item_ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_posted')->textInput() ?>

    <?= $form->field($model, 'is_cancelled')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
