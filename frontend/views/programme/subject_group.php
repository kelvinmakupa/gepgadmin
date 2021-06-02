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
$data=Yii::$app->db->createCommand("select subject_code as code,concat(subject_name,' ( ',if(exam_id>1,'Advanced Level','Ordinary level'),' )') as name from subjects ")->queryAll();

?>
<div class="general-setting-form">
    <br/>
<div class=" row" >
<div class="col-lg-8">
   <?php $form = ActiveForm::begin([

        'action'=>['subjectgroup/create'],
        'enableClientValidation' => true,]); ?>

    <?= $form->field($model, 'group_id')->label('Group Name')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Groups::find()->all(),'id','group_name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select group--'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>
    <?= $form->field($model, 'subject_code')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map($data,'code','name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select subject --'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Add Details', ['class' => 'btn btn-warning pull-right']) ?>
    </div>


    <?php ActiveForm::end(); ?>
  
</div>
</div>
</div>
