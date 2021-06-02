<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$context = $this->context;
$labels = $context->labels();
?>

<div class="auth-item-form">
    <?php $form = ActiveForm::begin(['id' => 'item-form']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['placeholder'=>'Please enter name','maxlength' => 64]) ?>

            <?= $form->field($model, 'description')->textarea(['placeholder'=>'Please enter description','rows' => 2]) ?>
        </div>
        <!--div class="col-sm-6">
            <?= $form->field($model, 'ruleName')->textInput(['id' => 'rule_name']) ?>

            <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
        </div-->
    </div>
    <div class="form-group">
        <?php
        echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'name' => 'submit-button'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
