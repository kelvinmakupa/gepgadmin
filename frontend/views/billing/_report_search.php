<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\TblBillingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row col-lg-12">

    <?php $form = ActiveForm::begin([
        'action' => ['report'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>
    <div class="col-lg-4">
    <?= $form->field($model, 'fee_structure_id')->label(false)->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\PaymentType::find()->all(),'id','name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Search by payment type --'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>
    <div class="col-lg-4">
    <?= $form->field($model, 'reg_no')->textInput(['placeholder'=>'Search by registration number'])->label(false) ?>
    </div>
    <div class="col-lg-4">
    <?= $form->field($model, 'invoice')->textInput(['placeholder'=>'Search by invoice number'])->label(false) ?>
    </div>
    <!--div class="col-lg-4">
    <?php // $form->field($model, 'status') ?>
    </div-->
    <div class="col-lg-4">
    <?php  echo $form->field($model, 'billing_date')->label(false)->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Search by billing date ...'],
        'readonly'=>true,
        'pluginOptions' => [
            'autoclose'=>true,
            'format'=>'yyyy-mm-dd'
        ]
    ])?>
    </div>
    <div class="col-lg-4">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Export Report', ['name'=>'export','class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
