<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccountRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save Detail' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning text-bold pull-right' : 'btn btn-primary text-bold pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
