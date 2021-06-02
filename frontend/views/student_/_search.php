<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'admission_number') ?>

    <?= $form->field($model, 'reg_number') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?php // echo $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'citizenship') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'f4indexno') ?>

    <?php // echo $form->field($model, 'other_f4indexno') ?>

    <?php // echo $form->field($model, 'f6indexno') ?>

    <?php // echo $form->field($model, 'other_f6indexno') ?>

    <?php // echo $form->field($model, 'programme_code') ?>

    <?php // echo $form->field($model, 'study_level') ?>

    <?php // echo $form->field($model, 'yos') ?>

    <?php // echo $form->field($model, 'application_round') ?>

    <?php // echo $form->field($model, 'academic_year') ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
