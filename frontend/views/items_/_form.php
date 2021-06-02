<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->hiddenInput(['value'=>'1'])->label(false) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rule_name')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'data')->hiddenInput(['rows' => 6])->label(false) ?>

    <?= $form->field($model, 'created_at')->hiddenInput(['value'=>time()])->label(false) ?>

    <?= $form->field($model, 'updated_at')->hiddenInput(['value'=>time()])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default text-bold' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
