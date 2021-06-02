<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\ThemeManager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="theme-manager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'theme_name')->radioList([ 'skin-black' => 'skin-black','skin-udom-light'=>'skin-udom-light', 'skin-black-light' => 'Skin-black-light', 'skin-blue' => 'Skin-blue', 'skin-blue-light' => 'Skin-blue-light', 'skin-green' => 'Skin-green', 'skin-green-light' => 'Skin-green-light', 'skin-red' => 'Skin-red', 'skin-red-light' => 'Skin-red-light', 'skin-yellow' => 'Skin-yellow', 'skin-yellow-light' => 'Skin-yellow-light', 'skin-purple' => 'Skin-purple', 'skin-purple-light' => 'Skin-purple-light', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->hiddenInput(['value'=>'1','readonly'=>true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
