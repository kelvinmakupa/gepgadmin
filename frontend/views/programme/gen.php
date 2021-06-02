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
<script type="text/javascript">

    function check(val){
        if(val.toLowerCase()!='2'){
            document.getElementById('grade').disabled=true;
            document.getElementById('grade').value='';
            document.getElementById('gpa').disabled=true;
            document.getElementById('gpa').value='';
        }else{
            document.getElementById('gpa').disabled=false;
            document.getElementById('grade').disabled=false;
        }

    }
    $(window).load(function() {
       check('2');
    })
</script>
<div class="general-setting-form">
<div class=" row" >
<div class="col-lg-8">
   <?php $form = ActiveForm::begin([
       // 'enableAjaxValidation' => true,
        'action'=>['general/create'],
        'enableClientValidation' => true,]); ?>

    <?= $form->field($model, 'programme_id')->hiddenInput(['id'=>'programme_id','value'=>$id])->label(false) ?>

    <?= $form->field($model, 'entry_category')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map([['id'=>'1','name'=>'Direct Entry'],['id'=>'2','name'=>'Equivalent Entry']],'id','name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select entry category--','onchange'=>'check(this.value)'],
        'pluginOptions' => [
            'allowClear' =>true
        ],
    ])?>

    <?= $form->field($model, 'min_olevel')->textInput(['id'=>'min_olevel']) ?>

    <?= $form->field($model, 'min_alevel')->textInput(['id'=>'min_alevel']) ?>

    <?= $form->field($model, 'olevel_pass')-> dropDownList(['1'=>'Normal Pass','2'=>'Credit Pass'],['id'=>'olevel_pass','prompt'=>'Please select ordinary level pass type'])?>

    <?= $form->field($model, 'alevel_pass')-> dropDownList(['3'=>'Subsidiary Pass(S)','4'=>'Principal Pass(E)','5'=>'Principal Pass(D)','6'=>'Principal Pass(C)'],['id'=>'alevel_pass','prompt'=>'Please select ordinary level pass type']) ?>

    <?= $form->field($model, 'min_point')->textInput(['id'=>'min_pass']) ?>

    <?= $form->field($model, 'gpa')->textInput(['id'=>'gpa']) ?>

    <?= $form->field($model, 'grade')->textInput(['id'=>'grade','maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save Details', ['class' => 'btn btn-default text-bold pull-right']) ?>
    </div>


    <?php ActiveForm::end(); ?>
  
</div>
</div>
</div>
