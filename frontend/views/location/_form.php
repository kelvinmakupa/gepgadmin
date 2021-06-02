<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use app\models\TblOrgan;
?>

<div class="tbl-location-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->label('Location Name')->textInput(['maxlength' => true, 'placeholder' => 'Enter location name']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'short_name')->label('Acronym Name')->textInput(['placeholder' => 'Enter acronym name']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'organ_id')->label('Organ')->widget(Select2::className(),[
                'data'=>ArrayHelper::map(TblOrgan::find()->all(),'id','name'),
                'options' => ['placeholder' => 'Please select organ'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
