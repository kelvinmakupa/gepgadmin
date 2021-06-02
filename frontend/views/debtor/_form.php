<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use app\models\TblDebtorType;
?>

<div class="tbl-debtor-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'company_name')->label('Company Name')->textInput(['maxlength' => true, 'placeholder' => 'Enter company name']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'sex')->label('Gender')->widget(Select2::classname(), [
                'data' => ArrayHelper::map([
                    ['id'=>'1','name'=>'Female'],
                    ['id'=>'2','name'=>'Male']],
                    'id','name'),'options' => ['placeholder' => 'Please select gender'],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ])?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'postal_address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'debtor_type_id')->label('Debtor Type')->widget(Select2::className(),[
                'data'=>ArrayHelper::map(TblDebtorType::find()->all(),'id','name'),
                'options' => ['placeholder' => 'Please debtor type'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'tin_no')->label('Tin Number')->textInput(['maxlength' => true,'placeholder' => 'Enter tin number']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'check_no')->label('Check Number')->textInput(['maxlength' => true,'placeholder' => 'Enter tin number']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
