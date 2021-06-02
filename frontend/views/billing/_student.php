<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Common;
use app\models\PaymentType;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */
/* @var $form yii\widgets\ActiveForm */

//print_r(Common::getNames());
?>

<div class="tbl-billing-form">

    <?php $form = ActiveForm::begin(['action' => ['billing/student'],'options' => ['method' => 'post']]); ?>

    <?php
    print_r($form->errorSummary($model));
    ?>

    <?= $form->field($model, 'payer')->hiddenInput(['maxlength' => true,'value'=>'3','readonly'=>true])->label(false) ?>

    <?= $form->field($model, 'bill_item_ref')->textInput(['maxlength' => true,'onKeyUp'=>'complete(this.value);','placeholder'=>'Please enter student registration number'])->label('Registration No') ?>

	<?= $form->field($model, 'payer_name')->textInput(['maxlength' => true,'readonly'=>false,'id'=>'student-names','placeholder'=>'Please enter payer names']) ?>

    <?= $form->field($model, 'payer_cell_num')->textInput(['maxlength' => true,'readonly'=>false,'id'=>'student-phone','placeholder'=>'Please enter payer phone number']) ?>

    <?= $form->field($model, 'payer_email')->textInput(['maxlength' => true,'readonly'=>false,'id'=>'student-email','placeholder'=>'Please enter payer email address']) ?>


    <?php // $form->field($model, 'payer_name')->textInput(['maxlength' => true,'placeholder'=>'Please enter payer names']) ?>

    <?php // $form->field($model, 'payer_cell_num')->textInput(['maxlength' => true,'placeholder'=>'Please enter payer phone number']) ?>

    <?php // $form->field($model, 'payer_email')->textInput(['maxlength' => true,'placeholder'=>'Please enter payer email address']) ?>

    <?php // $form->field($model, 'bill_item_ref')->textInput(['maxlength' => true,'placeholder'=>'Please enter student registration number'])->label('Registration No') ?>


    <?= $form->field($model, 'payment_type_id')->widget(Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map(PaymentType::find()->where('id<>:id',[':id'=>'30'])->
        andWhere('id<>:id',[':id'=>'31'])->andWhere('id<>:id',[':id'=>'32'])
        ->andWhere('id<>:id',[':id'=>'34'])->andWhere('status=:sts',[':sts'=>1])->orderBy('acc_description asc')->all(),'id','acc_description'),
        'language' => 'en',
        'options' => ['id'=>'student_payment_type','placeholder' => 'Please select payment type'],
        'pluginOptions' => [
            'allowClear' =>true     
        ],
    ])?>   
    <?= $form->field($model, 'bill_currency')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map([
            ['id'=>'TZS','name'=>'TZS'],
            ['id'=>'USD','name'=>'USD']],'id','name'),
        'language' => 'en',
        'options' => ['id'=>'student_currency','placeholder' => 'Please select currency'],
        'pluginOptions' => [
            'allowClear' =>true
        ],
    ])?>

    <?= $form->field($model, 'year_id')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(Yii::$app->db->createCommand("SELECT year_id as id,year FROM tbl_academic_year order by id desc")->queryAll(),'id','year'),
        'language' => 'en',
        'options' => ['id'=>'student_year','placeholder' => 'Please select academic year'],
        'pluginOptions' => [
            'allowClear' =>true
        ],
    ])?>

    <?= $form->field($model, 'bill_amount')->textInput(['placeholder'=>'Please enter bill amount']) ?>    

    <?= $form->field($model, 'bill_eqv_amount')->hiddenInput(['placeholder'=>'Applicable for non TZS bill','readonly'=>true,'value'=>0])->label(false) ?>

    <?= $form->field($model, 'bill_exp_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter choose expire date','id'=>'student_bill'],
            'pluginOptions' => [
                'startDate' => date("Y-m-d",strtotime("+1 month", time())),
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ])?>
                    
    <?= $form->field($model, 'bill_description')->textArea(['maxlength' => true,'placeholder'=>'Please enter bill description']) ?>

    <?= $form->field($model, 'bill_gen_date')->hiddenInput(['value'=>Common::getTime()])->label(false) ?>

    <?= $form->field($model, 'bill_pay_opt')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map([['id'=>'1','name'=>'Pay in Full Only'],
        ['id'=>'2','name'=>'Partial payment is allowed'],
        ['id'=>'3','name'=>'Exact bill (Same as full but does not allow over or under payment)']],'id','name'),
        'language' => 'en',
        'options' => ['id'=>'student_first','placeholder' => 'Please select payment option'],
        'pluginOptions' => [
            'allowClear' =>true
        ],  
    ])?>

    <?= $form->field($model, 'use_on_pay')->hiddenInput(['maxlength' => true,'value'=>'N'])->label(false) ?>

    <?= $form->field($model, 'is_posted')->hiddenInput(['value'=>'1'])->label(false) ?>

    <?= $form->field($model, 'is_cancelled')->hiddenInput(['value'=>'1'])->label(false) ?>

    <?= $form->field($model, 'company_id')->hiddenInput(['value'=>0])->label(false) ?>

    <?= $form->field($model, 'bill_gen_by')->hiddenInput(['maxlength' => true,'value'=>Common::getOnlineUser()])->label(false) ?>

    <?= $form->field($model, 'bill_appr_by')->hiddenInput(['maxlength' => true,'value'=>Common::getOnlineUser()])->label(false) ?>

    <?= $form->field($model, 'bill_id')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'control_number')->hiddenInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Generate Bill', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>

<?php
$url = "'" . Yii::$app->urlManager->createUrl(['billing/autocomplete']) . "'";
$js = <<<JS
 var url =$url;
 function complete(reg_no){
    
     if(reg_no.length>14){
      $.ajax({
        url: url, 
        type: 'post',
        data: {registration_number: reg_no},
        success: function(data) {
        var obj = JSON.parse(data);
        
        if(obj.statusCode==200){
         $('#student-names').val(obj.data.names);
         $('#student-email').val(obj.data.email);
        //$('#student-phone').val(obj.data.phone);
        }else{
          //  $('#student-names').val('');
         //$('#student-email').val('');
        //$('#student-phone').val(''); 
        }
}
});
     }
      
}

JS;
$this->registerJs($js, \yii\web\View::POS_HEAD);
?>
