<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\MenuPanel;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\MenuPanel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-panel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList([ 'MENU' => 'MENU', 'SUBMENU' => 'SUBMENU' ], ['prompt' => 'Please select menu type']) ?>

   <?=$form->field($model, 'parent_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(MenuPanel::find()->all(),'id','name'),
    'language' => 'en',
    'options' => ['placeholder' => '-- Please select parent id --'],
    'pluginOptions' => [
        'allowClear' => true
    ],
	])?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'redirect')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user')->hiddenInput(['value'=>Yii::$app->user->identity->id,'readOnly'=>true])->label(false) ?>

    <?= $form->field($model, 'status')->dropDownList([ '0' => 'Inactive', '10' => 'Active' ], ['prompt' => 'Please select media status'])  ?>

    <?= $form->field($model, 'order_index')->textInput() ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '   SAVE   ' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
