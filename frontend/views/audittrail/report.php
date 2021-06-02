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
        <i class="fa fa-download"></i><b><?=Html::encode(' Audit Trail Report')?></b>
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
        <?=$form->field($model, 'user_id')->widget(Select2::classname(), [
            'language' => 'en',
            'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->all(),'id','username'),

            'options' => ['placeholder' => 'Please choose username'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => false
            ],
        ])->label('Username')?>
            </div>

    <div class="col-lg-12">
        <div class="form-group">
            <br/>
            <?= Html::submitButton('Download', ['class' => 'btn btn-cons btn-primary text-bold']) ?>
            <?= Html::a('Reset Details',['audittrail/report'], ['class' => 'btn btn-cons btn-default text-bold']) ?>
        </div>

    </div>
    </div>
</div>





    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
