<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\detail\DetailView;
use app\models\Common;
use app\models\PaymentType;
use app\models\TblAcademicYear;

/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */
/* @var $form yii\widgets\ActiveForm */

//print_r(Common::getNames());

$this->title='Billing Managenent';
?>
<div class='row'>
<div class='col-lg-8'>
        <div class="panel panel-info">
        <div class="panel-heading">
                <i class="fa fa-user-circle-o"></i><?= Html::encode(' Student Bill Details') ?></div>
            <div class="panel-body">
            <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
             //'id',
            'payer_name',
            'payer_cell_num',
            'payer_email:email',
            'bill_amount',
            'bill_exp_date',
            'bill_description',
            'bill_gen_by',
            'bill_appr_by',
            'bill_currency',
            [
                'attribute'=>'payment_type_id',
                'format'=>'text',
                'value'=>Common::getPaymentNameById($model->payment_type_id),
                
            ],
            'bill_gen_date',
            'bill_id',
            'control_number',
            [
                'attribute'=>'bill_pay_opt',
                'format'=>'text',
                'value'=>Common::getPaymentOption($model->bill_pay_opt),
                
            ],
            'bill_eqv_amount',
            'bill_item_ref',
            [
                'attribute'=>'year_id',
                'format'=>'text',
                'value'=>TblAcademicYear::findOne($model->year_id)->year,
            ],    
            [
                'attribute'=>'is_posted',
                'format'=>'text',
                'value'=> Common::isPosted($model->is_posted),

            ],
//            'is_cancelled',
            [
                'attribute'=>'is_cancelled',
                'format'=>'text',
                'value'=> Common::isCancelled($model->is_cancelled),
            ],
        ],
    ]) ?>

            </div>
        </div>    
</div>
<div class='col-lg-4'>  

<div class="panel panel-info">
<div class="panel-heading">
    <i class="fa fa-plus"></i><?= Html::encode(' Update Bill Panel') ?></div>
<div class="panel-body">

    <?php $form = ActiveForm::begin(); ?>

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

    <?= $form->field($model, 'year_id')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(Yii::$app->db->createCommand("SELECT year_id as id,year FROM tbl_academic_year order by id desc")->queryAll(),'id','year'),
        'language' => 'en',
        'options' => ['id'=>'student_year','placeholder' => 'Please select academic year'],
        'pluginOptions' => [
            'allowClear' =>true
        ],
    ])?>

    <?= $form->field($model, 'bill_item_ref')->textInput(['maxlength' => true,'placeholder'=>'Please enter student registration number'])->label('Registration No') ?>

    <div class="row">    
        <div class="col-lg-12">
            <?= Html::submitButton('Update Bill', ['class' => 'btn pull-right btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    </div>

    </div>
</div>
</div>
</div>
