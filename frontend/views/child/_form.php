<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AuthItem;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
$child=ArrayHelper::map(AuthItem::find()->all(),'name','name');
/* @var $this yii\web\View */
/* @var $model app\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class='col-lg-6'>
    <?=$form->field($model, 'parent')->widget(Select2::classname(), [
    'data' => $child,
    'language' => 'en',
    'options' => ['placeholder' => '-- Please select role --'],
    'pluginOptions' => [
        'allowClear' => true
    ],
	])?>
    <?=$form->field($model, 'child')->widget(Select2::classname(), [
    'data' => $child,
    'language' => 'en',
    'options' => ['placeholder' => '-- Please select permission --'],
    'pluginOptions' => [
        'allowClear' => true
    ],
	])?>
    </div>
	<div class='col-lg-12'>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add Detail' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>
	</div>
    <?php ActiveForm::end(); ?>

</div>
