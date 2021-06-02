<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Companies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="companies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_code')->textInput(['maxlength' => true,'placeholder'=>'Please enter company code']) ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true,'placeholder'=>'Please enter company full name']) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true,'placeholder'=>'Please enter phone number']) ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true,'placeholder'=>'Please enter email address']) ?>

    <?= $form->field($model, 'is_active')->widget(kartik\select2\Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map(array(['id'=>'0','name'=>'Inactive'],['id'=>'10','name'=>'Active']),'id','name') ,
        'language' => 'en',
        'options' => ['placeholder' => 'Please select status '],
        'pluginOptions' => [
            'allowClear' => true
        ],])?>

    <div class="form-group">
        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-cons btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
