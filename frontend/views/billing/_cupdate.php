<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Common;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\PaymentType;
use app\models\Companies;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-billing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_id')->widget(kartik\select2\Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map(Companies::find()->where('is_active=:status',[':status'=>'10'])->all(),'id','full_name') ,
        'language' => 'en',
        'options' => ['id'=>'company_id','placeholder' => 'Please select company'],
        'pluginOptions' => [
            'allowClear' => true
        ],])?>

    <?= $form->field($model, 'payer')->textInput(['maxlength' => true,'readonly'=>true])->label(false) ?>

    <?= $form->field($model, 'payer_name')->textInput(['maxlength' => true,'id'=>'payer_name','readonly'=>true]) ?>

    <?= $form->field($model, 'payer_cell_num')->textInput(['maxlength' => true,'id'=>'payer_phone','readonly'=>true]) ?>

    <?= $form->field($model, 'payer_email')->textInput(['maxlength' => true,'id'=>'payer_email','readonly'=>true]) ?>

    <?= $form->field($model, 'bill_amount')->textInput() ?>

    <?= $form->field($model, 'bill_eqv_amount')->textInput() ?>

    <?= $form->field($model, 'bill_exp_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Please pick bill expire date'],
        'readonly'=>true,
        'pluginOptions' => [
            'startDate' => date('Y-m-d',strtotime('+3 months')),
            'autoclose'=>true,
            'todayHighlight' => true
        ]
    ]);
    ?>

    <?= $form->field($model, 'bill_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_gen_by')->textInput(['maxlength' => true,'value'=>Common::getOnlineUser()]) ?>

    <?= $form->field($model, 'bill_appr_by')->textInput(['maxlength' => true,'value'=>Common::getOnlineUser()]) ?>

    <?= $form->field($model, 'bill_currency')->dropDownList(['TZS'=>'TZS','USD'=>'USD'],['placeholder'=>'Please select currency']) ?>

    <?= $form->field($model, 'payment_type_id')->dropDownList(ArrayHelper::map(PaymentType::find()->where('status=:sts',[':sts'=>1])->all(),'id','acc_description'),['placeholder'=>'Please select payment type']) ?>

    <?= $form->field($model, 'bill_gen_date')->hiddenInput(['value'=>Common::getTime()])->label(false) ?>

    <?= $form->field($model, 'bill_id')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'control_number')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'bill_pay_opt')->dropDownList([
        '1'=>'Pay in Full Only','2'=>'Partial payment is allowed','3'=>'Exact bill (Same as full but does not allow over or under payment)']) ?>

    <?= $form->field($model, 'use_on_pay')->hiddenInput(['maxlength' => true,'value'=>'N'])->label(false) ?>


    <?= $form->field($model, 'bill_item_ref')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'is_posted')->hiddenInput(['value'=>'1'])->label(false) ?>

    <?= $form->field($model, 'is_cancelled')->hiddenInput(['value'=>'1'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-edit"></i> Update Bill', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
<?php
$url="'".Yii::$app->urlManager->createUrl(['companies/details'])."'";
$js=<<<JS
$("#company_id").change(function(){
var depa=document.getElementById('company_id').value;
var url =$url;
// alert(url);
$.ajax({
           type: "POST",
           url : url,
           data : {company_id: depa},
           success : function(data) {
               var json=JSON.parse(data);
               if(json){
                   document.getElementById('payer_name').value=json.name;
                   document.getElementById('payer_phone').value=json.phone;
                   document.getElementById('payer_email').value=json.email;
               }else{
                    empty();
               }
               },
            error: function(data){
                    empty();
	            }
       });
});
function empty(){
    document.getElementById('payer_name').value='';
    document.getElementById('payer_phone').value='';
    document.getElementById('payer_email').value='';
}
JS;
$this->registerJs($js, \yii\web\View::POS_READY);

?>
