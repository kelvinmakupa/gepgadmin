<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblAcademicYearSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-academic-year-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'year_id') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'last_reg_no') ?>

    <?= $form->field($model, 'last_reg_no_graduate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
