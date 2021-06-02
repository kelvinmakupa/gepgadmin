<?php

use yii\helpers\Html;
#use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use app\models\AccountRole;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$roles=ArrayHelper::map(AccountRole::find()->all(),'role_id','role_name');
$sex=ArrayHelper::map(array(['id'=>'F','name'=>'Female'],['id'=>'M','name'=>'Male']),'id','name');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->widget(Select2::classname(), [
        'data' =>$sex ,
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select user sex --'],
        'pluginOptions' => [
            'allowClear' => true
        ],])?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_id')->widget(Select2::classname(), [
    'data' =>$roles ,
    'language' => 'en',
    'options' => ['placeholder' => '-- Please select role --'],
    'pluginOptions' => [
        'allowClear' => true
    ],])?>

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
        <?= Html::submitButton($model->isNewRecord ? 'Save Details' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
