<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;

// Usage with model and Active Form (with no default initial value)
/* @var $this yii\web\View */
/* @var $model app\models\Bank */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true,'readonly'=>true,'id'=>'short']) ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true,'readonly'=>true,'id'=>'authKey']) ?>

    <div class="form-group">
       <?= Html::button('Generate Auth Key',['class' =>'btn btn-primary','id'=>'generateAuthKey']) ?> <?= Html::submitButton('Save Auth Key', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$url="'".Yii::$app->urlManager->createUrl(['bank/authkey'])."'";
$js=<<<JS
$("#generateAuthKey").click(function(){

var url =$url;
//alert('url::'+url);
var short=document.getElementById('short').value;
$.ajax({
            type: "POST",
            url : url,
            data : {short_name: short},
            success : function(data) {
                document.getElementById('authKey').value=String(data);
                },
             error: function(data){
              alert(JSON.stringify(data['responseText']));
            }
        });

    });
JS;
$this->registerJs($js, \yii\web\View::POS_READY);

?>