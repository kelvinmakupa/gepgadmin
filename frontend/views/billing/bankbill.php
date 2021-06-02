<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Common;
use app\models\PaymentType;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */

$this->title = 'Billing Management';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-plus"></i><?= Html::encode(' Bill Generation Panel (Bank Bills)') ?>
    </div>
    <div class="panel-body">

    <?php $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_HORIZONTAL
    ]); ?>

    <?= $form->field($model, 'payer')->hiddenInput(['maxlength' => true,'value'=>'3','readonly'=>true])->label(false) ?>

    <?= $form->field($model, 'payer_name')->textInput(['maxlength' => true,'placeholder'=>'Please enter payer names']) ?>

    <?= $form->field($model, 'payer_cell_num')->textInput(['maxlength' => true,'placeholder'=>'Please enter payer phone number']) ?>

    <?= $form->field($model, 'payer_email')->textInput(['maxlength' => true,'placeholder'=>'Please enter payer email address']) ?>

    <?= $form->field($model, 'bill_item_ref')->textInput(['maxlength' => true,'placeholder'=>'Please enter student registration number'])->label('Registration No') ?>

    <?= $form->field($model, 'payment_type_id')->widget(Select2::classname(), [
            'data' => yii\helpers\ArrayHelper::map(PaymentType::find()
                ->where('id>:id',[':id'=>29])->andWhere('id<:num',[':num'=>33])->orderBy('acc_description asc')->all(),'id','acc_description'),
            'language' => 'en',
            'options' => ['placeholder' => 'Please choose payment type...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'bill_currency')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(array(['id'=>'TZS','name'=>'TZS']),'id','name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Please choose bill currency ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

    <?= $form->field($model, 'year_id')->widget(Select2::classname(), [
            'data' => yii\helpers\ArrayHelper::map(Yii::$app->db->createCommand("SELECT year_id as id,year FROM tbl_academic_year order by status desc")->queryAll(),'id','year'),
            'language' => 'en',
            'options' => ['placeholder' => 'Please choose academic year ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>


    <?= $form->field($model, 'bill_amount')->textInput(['placeholder'=>'Please enter bill amount']) ?>

    <?= $form->field($model, 'bill_eqv_amount')->hiddenInput(['value'=>0,'placeholder'=>'Please enter bill amount'])->label(false) ?>


    <?=$form->field($model, 'bill_exp_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Please pick bill expire date','id'=>'dpicker'],
            'readonly'=>true,
            'pluginOptions' => [
                'startDate' => date('Y-m-d',strtotime('+3 months')),
                'autoclose'=>true,
                'todayHighlight' => true
            ]
        ]);
        ?>

    <?= $form->field($model, 'bill_description')->textArea(['rows'=>4,'maxlength' => true,'placeholder'=>'Please enter bill description']) ?>

    <?= $form->field($model, 'bill_gen_date')->hiddenInput(['value'=>Common::getTime()])->label(false) ?>

    <?= $form->field($model, 'bill_pay_opt')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(array(['id'=>'3','name'=>'Exact bill(Same as full but does not allow over or under payment)']),'id','name'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select a payment option ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>


    <div class="row">
        <div class="col-lg-12">
            <?= Html::submitButton('Generate Bill', ['class' => 'btn btn-primary pull-right']) ?>
        </div>
    </div>
    <?= $form->field($model, 'use_on_pay')->hiddenInput(['maxlength' => true,'value'=>'N'])->label(false) ?>

    <?= $form->field($model, 'is_posted')->hiddenInput(['value'=>'2'])->label(false) ?>

    <?= $form->field($model, 'is_cancelled')->hiddenInput(['value'=>'1'])->label(false) ?>

    <?= $form->field($model, 'company_id')->hiddenInput(['value'=>0])->label(false) ?>

    <?= $form->field($model, 'bill_gen_by')->hiddenInput(['maxlength' => true,'value'=>Common::getOnlineUser()])->label(false) ?>

    <?= $form->field($model, 'bill_appr_by')->hiddenInput(['maxlength' => true,'value'=>Common::getOnlineUser()])->label(false) ?>

    <?= $form->field($model, 'bill_id')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'control_number')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?php ActiveForm::end(); ?>


</ div>
</ div>
