<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Capplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="capplication-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'open_application')->textInput() ?>

    <?= $form->field($model, 'close_application')->textInput() ?>

    <?= $form->field($model, 'publish')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'academic_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
