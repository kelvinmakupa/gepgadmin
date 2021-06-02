<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Common;
use app\models\Companies;
use app\models\PaymentType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */
/* @var $form yii\widgets\ActiveForm */

//print_r(Common::getNames());
?>

<div class="tbl-billing-form">

    <?php $form2 = ActiveForm::begin(['action' => ['billing/company'],'options' => ['method' => 'post']]); ?>

    <?= $form2->field($model, 'payer')->hiddenInput(['maxlength' => true,'value'=>'2','readonly'=>true])->label(false) ?>

    <?= $form2->field($model, 'company_id')->widget(kartik\select2\Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map(Companies::find()->where('is_active=:status',[':status'=>'10'])->all(),'id','full_name') ,
        'language' => 'en',
        'options' => ['id'=>'company_id','placeholder' => 'Please select company'],
        'pluginOptions' => [
            'allowClear' => true
        ],])?>

    <?= $form2->field($model, 'payer_name')->textInput(['maxlength' => true,'id'=>'payer_name','readonly'=>true]) ?>

    <?= $form2->field($model, 'payer_cell_num')->textInput(['maxlength' => true,'id'=>'payer_phone','readonly'=>true]) ?>

    <?= $form2->field($model, 'payer_email')->textInput(['maxlength' => true,'id'=>'payer_email','readonly'=>true]) ?>

    <?= $form2->field($model, 'bill_item_ref')->textInput(['maxlength' => true,'id'=>'bill_item','readonly'=>true]) ?>

    <?= $form2->field($model, 'bill_amount')->textInput(['placeholder'=>'Please enter bill amount']) ?>

    <?= $form2->field($model, 'bill_eqv_amount')->hiddenInput(['value'=>0])->label(false) ?>

    <?=$form2->field($model, 'bill_exp_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter choose expire date','id'=>'company_bill'],
            'pluginOptions' => [
                'startDate' => date("Y-m-d",strtotime("+1 month", time())),
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ])
        ?>

       <?php /* $form2->field($model, 'bill_exp_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Please pick bill expire date','id'=>'dpicker'],
        'readonly'=>true,
        'pluginOptions' => [
            'startDate' => date('Y-m-d',strtotime('+3 months')),
            'autoclose'=>true,
            'todayHighlight' => true
        ]
    ])*/
    ?>

    <?= $form2->field($model, 'bill_description')->textArea(['rows'=>4,'maxlength' => true,'placeholder'=>'Please enter bill description']) ?>

    <?= $form2->field($model, 'bill_gen_by')->hiddenInput(['maxlength' => true,'value'=>Common::getOnlineUser()])->label(false) ?>

    <?= $form2->field($model, 'bill_appr_by')->hiddenInput(['maxlength' => true,'value'=>Common::getOnlineUser()])->label(false) ?>

    <?= $form2->field($model, 'bill_currency')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map([
            ['id'=>'TZS','name'=>'TZS'],
            ['id'=>'USD','name'=>'USD']],'id','name'),
        'language' => 'en',
        'options' => ['id'=>'company_currency','placeholder' => 'Please select currency'],
        'pluginOptions' => [
            'allowClear' =>true
        ],
    ])?>    
    
    <?= $form2->field($model, 'payment_type_id')->widget(Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map(PaymentType::find()->where('id<>:id',[':id'=>'30'])->
        andWhere('id<>:id',[':id'=>'31'])->andWhere('id<>:id',[':id'=>'32'])
        ->andWhere('id<>:id',[':id'=>'34'])->andWhere('status=:sts',[':sts'=>1])->orderBy('acc_description asc')->all(),'id','acc_description'),
        'language' => 'en',
        'options' => ['id'=>'company_payment_type','placeholder' => 'Please select payment type'],
        'pluginOptions' => [
            'allowClear' =>true
        ],
    ])?>
    
    <?= $form2->field($model, 'bill_gen_date')->hiddenInput(['value'=>Common::getTime()])->label(false) ?>

    <?= $form2->field($model, 'bill_id')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form2->field($model, 'control_number')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form2->field($model, 'bill_pay_opt')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map([['id'=>'1','name'=>'Pay in Full Only'],
        ['id'=>'2','name'=>'Partial payment is allowed'],
        ['id'=>'3','name'=>'Exact bill (Same as full but does not allow over or under payment)']],'id','name'),
        'language' => 'en',
        'options' => ['id'=>'company_first','placeholder' => 'Please select payment option'],
        'pluginOptions' => [
            'allowClear' =>true
        ],
    ])?>

    <?= $form2->field($model, 'use_on_pay')->hiddenInput(['maxlength' => true,'value'=>'N'])->label(false) ?>


    <?php // $form2->field($model, 'bill_item_ref')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form2->field($model, 'is_posted')->hiddenInput(['value'=>'1'])->label(false) ?>

    <?= $form2->field($model, 'is_cancelled')->hiddenInput(['value'=>'1'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Genarate Bill', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
<?php
$js=<<<JS
/*   
    $('.dpicker').datepicker({
    startDate: '-3d'
});

$.fn.dpicker.defaults.format = "mm/dd/yyyy";
$('.dpicker').datepicker({
    startDate: '-3d'
});*/
    
JS;
$this->registerJs($js, \yii\web\View::POS_READY);

?>