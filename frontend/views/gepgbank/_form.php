<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\GepgBank */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-bank-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'beneficiary_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'account_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'swift_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acc_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_visible')->widget(Select2::classname(), [
        // 'data' => array('TZS'=>'TZS','USD'=>'USD'),// array('1'=>'Pay in Full Only','2'=>'Partial payment is allowed','3'=>'Exact bill(Same as full but does not allow over od under payment'),
        'data' => ArrayHelper::map(array(['id'=>'0','name'=>'Invisible'],['id'=>'10','name'=>'Visible']),'id','name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select a visibility status...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
