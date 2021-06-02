<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProgrammesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programmes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'level') ?>

    <?= $form->field($model, 'programme_name') ?>

    <?= $form->field($model, 'department_id') ?>

    <?php // echo $form->field($model, 'admission_direct') ?>

    <?php // echo $form->field($model, 'admission_equiv') ?>

    <?php // echo $form->field($model, 'min_point') ?>

    <?php // echo $form->field($model, 'programme_duration') ?>

    <?php // echo $form->field($model, 'capacity') ?>

    <?php // echo $form->field($model, 'tuition_fee') ?>

    <?php // echo $form->field($model, 'loan_priority') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
