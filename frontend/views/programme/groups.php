<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\Programmes */

$this->title = 'Criteria Configuration';
$url="'".Yii::$app->urlManager->createUrl(['advanced/six'])."'";
$detail="'".Yii::$app->urlManager->createUrl(['advanced/index'])."'";

?>
<div class="general-setting-form">
<div class=" row" >
<div class="col-lg-8">
   <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'action'=>['group/create'],
        'enableClientValidation' => true,]); ?>
    <br/>
    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true,'placeholder'=>'Please enter group name']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add Group' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default text-bold pull-right' : 'btn btn-primary']) ?>
    </div>



    <?php ActiveForm::end(); ?>
  
</div>
</div>
</div>
