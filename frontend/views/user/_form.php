<?php

use yii\helpers\Html;
use kartik\file\FileInput;
use kartik\select2\Select2;
use app\models\AccountRole;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$roles=ArrayHelper::map(AccountRole::find()->all(),'role_id','role_name');
$sex=ArrayHelper::map(array(['id'=>'F','name'=>'Female'],['id'=>'M','name'=>'Male']),'id','name');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(
        [
            'options' => ['enctype' => 'multipart/form-data'],
            'type' => ActiveForm::TYPE_VERTICAL,
        ]); ?>

  <?= $form->field($model, 'first_name', [
    'feedbackIcon' => [
    'default' => 'user',
    'success' => 'ok',
    'error' => 'exclamation-sign',
    'defaultOptions' => ['class'=>'text-default']
    ]
    ])->textInput(['placeholder'=>'Please enter first name'])?>

    <?= $form->field($model, 'last_name', [
        'feedbackIcon' => [
            'default' => 'user',
            'success' => 'ok',
            'error' => 'exclamation-sign',
            'defaultOptions' => ['class'=>'text-default']
        ]
    ])->textInput(['placeholder'=>'Please enter middle name'])?>

    <?= $form->field($model, 'surname', [
        'feedbackIcon' => [
            'default' => 'user',
            'success' => 'ok',
            'error' => 'exclamation-sign',
            'defaultOptions' => ['class'=>'text-default']
        ]
    ])->textInput(['placeholder'=>'Please enter surname'])?>

    <?= $form->field($model, 'sex')->widget(Select2::classname(), [
        'data' =>$sex ,
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select user sex --'],
        'pluginOptions' => [
            'allowClear' => true
        ],])?>

    <?= $form->field($model, 'username', [
        'feedbackIcon' => [
            'default' => 'user',
            'success' => 'ok',
            'error' => 'exclamation-sign',
            'defaultOptions' => ['class'=>'text-default']
        ]
    ])->textInput(['placeholder'=>'Please enter username'])?>

    <?= $form->field($model, 'auth_key')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'password_hash', [
        'feedbackIcon' => [
            'default' => 'lock',
            'success' => 'ok',
            'error' => 'exclamation-sign',
            'defaultOptions' => ['class'=>'text-default']
        ]
    ])->passwordInput(['placeholder'=>'Please enter password'])?>


    <?= $form->field($model, 'password_reset_token')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?=$form->field($model, 'email', [
        'addon' => [
            'append' => [
                'content' => '<i class="glyphicon glyphicon-envelope"></i>'
            ]
        ]
    ])->textInput(['placeholder'=>'Please enter email address'])?>


    <?= $form->field($model, 'role_id')->widget(Select2::classname(), [
    'data' =>$roles ,
    'language' => 'en',
    'options' => ['placeholder' => '-- Please select role --'],
    'pluginOptions' => [
        'allowClear' => true
    ],])?>

    <?= $form->field($model, 'avatar')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],]) ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
    'data' => [ '0' => 'In Active', '10' => 'Active',],
    'language' => 'en',
    'options' => ['placeholder' => '-- Please select status --'],
    'pluginOptions' => [
        'allowClear' => true
    ],]);?>

    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save Details' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
