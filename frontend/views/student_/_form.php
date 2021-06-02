<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'admission_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reg_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dob')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'citizenship')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f4indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'other_f4indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f6indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'other_f6indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'programme_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'study_level')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yos')->textInput() ?>

    <?= $form->field($model, 'application_round')->textInput() ?>

    <?= $form->field($model, 'academic_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
