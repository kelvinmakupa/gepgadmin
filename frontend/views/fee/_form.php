<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\PaymentType;
use app\models\Programmes;
/* @var $this yii\web\View */
/* @var $model app\models\FeeStructure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fee-structure-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payment_type_id')->widget(Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map(PaymentType::find()->where(['status'=>1])->orderBy('acc_description asc')->all(),'id','acc_description') ,
        'language' => 'en',
        'options' => ['placeholder' => 'Please select payment type'],    
        'pluginOptions' => [    
            'allowClear' => true
        ],])?>

    <?php // $form->field($model, 'academic_year_id')->textInput(['value'=>'5','readonly'=>true])->label(false) ?>

    <?= $form->field($model, 'programme_id')->widget(Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map(Programmes::find()->where(['>','level',1])->andWhere(['<','level',7])->orderBy('level DESC')->all(),'program_id','programme_name') ,
        'language' => 'en',
        'options' => ['placeholder' => 'Please select programme name'],
        'pluginOptions' => [
            'allowClear' => true
        ],])?>    

    <?=
		
		$form->field($model, 'year_of_study')->widget(Select2::classname(), [
        'data' =>yii\helpers\ArrayHelper::map([['id'=>'1','name'=>'First Year'],['id'=>'2','name'=>'Second Year'],['id'=>'3','name'=>'Third Year'],['id'=>'4','name'=>'Forth Year'],['id'=>'5','name'=>'Fifth Year']],'id','name') ,
        'language' => 'en',
        'options' => ['placeholder' => 'Please select year of study'],
        'pluginOptions' => [
            'allowClear' => true
        ],])
		
	?>

    <?= $form->field($model, 'local_amount')->textInput(['placeholder'=>'Please enter local amount (TSH)']) ?>       

    <?= $form->field($model, 'foreign_amount')->textInput(['placeholder'=>'Please enter foreign amount (USD)']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
