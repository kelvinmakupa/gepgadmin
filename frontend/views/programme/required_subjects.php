<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\Programmes */

$this->title = 'Criteria Configuration';


$data=Yii::$app->db->createCommand("select subject_code as code,concat(subject_name,' ( ',if(exam_id>1,'Advanced Level','Ordinary level'),' )') as name from subjects ")->queryAll();


?>
<div class="general-setting-form">
<div class=" row" >
<div class="col-lg-8">

   <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'action'=>['requiredsubject/create'],
        'enableClientValidation' => true,]); ?>

        <?= $form->field($model, 'programme_id')->hiddenInput(['value'=>$id])->label(false) ?>

        <?= $form->field($model, 'subject_code')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map($data,'code','name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select subject --'],
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
        'data' => ['1'=>'Normal Pass','2'=>'Credit Pass','3'=>'Subsidiary Pass(E)','4'=>'Principal Pass(E)','5'=>'Principal Pass(D)','6'=>'Principal Pass(C)'],
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select pass type --'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add Detail' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default text-bold pull-right' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
  
</div>
</div>
</div>
