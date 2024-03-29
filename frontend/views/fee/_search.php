<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FeeStructureSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fee-structure-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'payment_type_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'programme_id') ?>

    <?= $form->field($model, 'year_of_study') ?>

    <?php // echo $form->field($model, 'local_amount') ?>

    <?php // echo $form->field($model, 'foreign_amount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
