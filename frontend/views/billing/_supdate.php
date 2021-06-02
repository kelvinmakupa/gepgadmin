<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Common;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\PaymentType;
use app\models\Companies;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-billing-form">    

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payer')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'payer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_item_ref')->textInput(['maxlength' => true])->label('Registration Number') ?>

    <?= $form->field($model, 'payer_cell_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_type_id')->dropDownList(ArrayHelper::map(PaymentType::find()->where('status=:sts',[':sts'=>1])->orderBy('acc_description asc')->all(),'id','acc_description'),['placeholder'=>'Please select payment type']) ?>

    <?= $form->field($model, 'bill_currency')->dropDownList(['TZS'=>'TZS','USD'=>'USD'],['placeholder'=>'Please select currency']) ?>

    <?= $form->field($model, 'bill_amount')->textInput() ?>

    <?= $form->field($model, 'bill_eqv_amount')->textInput(['placeholder'=>'Applicable for non TZS bill']) ?>

    <?= $form->field($model, 'bill_exp_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Please pick bill expire date'],
        'readonly'=>true,
        'pluginOptions' => [
            'startDate' => date('Y-m-d',strtotime('+3 months')),
            'autoclose'=>true,
            'todayHighlight' => true
        ]
    ]);
    ?>

    <?= $form->field($model, 'bill_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_pay_opt')->dropDownList([
        '1'=>'Pay in Full Only','2'=>'Partial payment is allowed','3'=>'Exact bill (Same as full but does not allow over or under payment)']) ?>

    <?= $form->field($model, 'use_on_pay')->hiddenInput(['maxlength' => true,'value'=>'N'])->label(false) ?>

    <?= $form->field($model, 'is_posted')->hiddenInput(['value'=>'1'])->label(false) ?>

    <?= $form->field($model, 'is_cancelled')->hiddenInput(['value'=>'1'])->label(false) ?>

    <?= $form->field($model, 'company_id')->hiddenInput(['value'=>0])->label(false) ?>

    <?= $form->field($model, 'bill_gen_by')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'bill_appr_by')->hiddenInput(['maxlength' => true,'value'=>Common::getOnlineUser()])->label(false) ?>

    <?= $form->field($model, 'bill_id')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'control_number')->hiddenInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?php Html::submitButton('<i class="fa fa-edit"></i> Update Bill', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Save Detail' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning text-bold pull-right' : 'btn btn-primary text-bold pull-right']) ?>

    </div>

    <?php ActiveForm::end(); ?>


</div>
