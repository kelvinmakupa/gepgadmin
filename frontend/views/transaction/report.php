<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

use kartik\daterange\DateRangePicker;
use app\models\PaymentType;
/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Reports Management';
$this->params['breadcrumbs'][] = ['label' => 'Report', 'url' => ['report']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default" style="z-index:99999">

    <div class="panel-heading">
        <i class="fa fa-download"></i><b><?=Html::encode(' Transaction Report')?></b>
        </div>
    <div class="panel-body">

        <?php $form = ActiveForm::begin(); ?>

        <div class='col-sm-6'>
        <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Please choose Start Date'],
            'readonly'=>true,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-m-dd'
            ]
        ])?>

        </div>
        <div class='col-sm-6'>

        <?=$form->field($model, 'end_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Please choose End Date'],
            'readonly'=>true,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-m-dd'
            ]
        ])?>

            </div>

            <div class='col-lg-12'>
        <?=$form->field($model, 'payment_type')->widget(Select2::classname(), [
            'language' => 'en',
            'data' => \yii\helpers\ArrayHelper::map(Yii::$app->db->createCommand("SELECT id,CONCAT(acc_description,'(',CONCAT(acc_code,'',')')) acc_description FROM tbl_payment_types")->queryAll(),'id','acc_description'),

            'options' => ['placeholder' => 'Please choose payment type'],
            'pluginOptions' => [
                'allowClear' => true,   
                'multiple' => true
            ],
        ])->label('Payment Type')?>
            </div>

    <div class="col-lg-12">
        <div class="form-group">
            <br/>
            <?= Html::submitButton('Download Details', ['class' => 'btn btn-primary text-bold']) ?>
            <?= Html::a('Reset Details',['transaction/report'], ['class' => 'btn btn-default text-bold']) ?>
        </div>

    </div>
    </div>
</div>





    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
