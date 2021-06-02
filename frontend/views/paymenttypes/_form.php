<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblPaymentTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-payment-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'acc_code')->textInput(['placeholder'=>'Please enter account code']) ?>

    <?= $form->field($model, 'acc_description')->textInput(['maxlength' => true,'placeholder'=>'Please enter account description']) ?>

    <?= $form->field($model, 'gfs_code')->textInput(['placeholder'=>'Please enter gfs code']) ?>

    <?= $form->field($model, 'gfs_description')->textInput(['maxlength' => true,'placeholder'=>'Please enter gfs description']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?' Save ':' Update ', ['class' => 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
