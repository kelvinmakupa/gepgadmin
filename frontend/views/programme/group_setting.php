<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
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
 <br/>
<div class="col-lg-8">
   <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'action'=>['groupsetting/create'],
        'enableClientValidation' => true,]); ?>

    <?= $form->field($model, 'programme_id')->hiddenInput(['value'=>$id])->label(false) ?>

    <?= $form->field($model, 'pick')->textInput() ?>

    <?= $form->field($model, 'group_id')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Groups::find()->all(),'id','group_name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select group--'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>
    <?= $form->field($model, 'entry_category')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map([['id'=>'1','name'=>'Direct Entry'],['id'=>'2','name'=>'Equivalent Entry']],'id','name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select entry category--','onchange'=>'check(this.value)'],
        'pluginOptions' => [
            'allowClear' =>true
        ],
    ])?>
    <?= $form->field($model, 'pass_type')->widget(Select2::classname(), [
        'data'=>['1'=>'Normal/Principal Pass','2'=>'Credit Pass','3'=>'Subsidiary Pass(E)','4'=>'Principal Pass(E)','5'=>'Principal Pass(D)','6'=>'Principal Pass(C)'],
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select pass type--'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>

    <?= $form->field($model, 'group_type')->widget(Select2::classname(), [
        'data' => ['1'=>'OR group','2'=>'AND group'],
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select group type --'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>
    <div class="form-group">
        <?= Html::submitButton('Save Details', ['class' => 'btn btn-default text-bold pull-right']) ?>
    </div>


    <?php ActiveForm::end(); ?>
  
</div>
</div>
</div>
