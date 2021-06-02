<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TblReconcilliation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-reconcilliation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>

    <?= $form->field($model, 'trx_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Please pick transaction date'],
        'readonly'=>true,
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose'=>true,
            'todayHighlight' => true
        ]
    ])?>

    <?= $form->field($model, 'recon_opt')->widget(Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map(array(['id'=>'1','name'=>'GePG successful transactions'],['id'=>'2','name'=>'Exception report after reconciliation between GePG and bank']),'id','name') ,
        'language' => 'en',
        'options' => ['placeholder' => 'Please select reconcilliation option '],
        'pluginOptions' => [
            'allowClear' => true
        ],])?>

    <?= $form->field($model, 'file_name')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'created_at')->hiddenInput(['value'=>date('Y-m-d h:i:s')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(' Obtain Reconcilliation Data', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
