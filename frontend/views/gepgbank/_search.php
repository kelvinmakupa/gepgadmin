<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GepgBankSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-bank-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'beneficiary_name') ?>

    <?= $form->field($model, 'bank_name') ?>

    <?= $form->field($model, 'account_name') ?>

    <?= $form->field($model, 'account_number') ?>

    <?php // echo $form->field($model, 'swift_code') ?>

    <?php // echo $form->field($model, 'acc_currency') ?>

    <?php // echo $form->field($model, 'is_visible') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
