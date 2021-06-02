<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Programmes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programmes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true,'placeholder'=>'Please enter programme code','readonly'=>true]) ?>
    <?= $form->field($model, 'level')->hiddenInput(['maxlength' => true,'placeholder'=>'Please enter programme code','readonly'=>true])->label(false) ?>

    <?php /* $form->field($model, 'level')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(\app\models\QualificationType::find()->all(),'id','name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select programme level --','readonly'=>true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])*/ ?>
    <?= $form->field($model, 'programme_name')->textInput(['maxlength' => true,'placeholder'=>'Please enter programme name','readonly'=>true]) ?>

    <?= $form->field($model, 'department_id')->hiddenInput()->label(false) ?>

    <?php /* $form->field($model, 'department_id')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(\app\models\Department::find()->all(),'department_id','department_name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select department --'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])*/ ?>

    <?= $form->field($model, 'admission_direct')->hiddenInput(['rows' => 6,'placeholder'=>'Please enter Admission requirements for Direct Entry'])->label(false) ?>

    <?= $form->field($model, 'admission_equiv')->hiddenInput(['rows' => 6,'placeholder'=>'Please enter Admission requirements for Equivalent Entry'])->label(false) ?>

    <?= $form->field($model, 'min_point')->hiddenInput(['placeholder'=>'Please enter minimum points'])->label(false) ?>

    <?= $form->field($model, 'programme_duration')->textInput(['placeholder'=>'Please eneter programme duration','readonly'=>true]) ?>

    <?= $form->field($model, 'capacity')->hiddenInput(['placeholder'=>'Please enter total programme capacity'])->label(false) ?>

    <?= $form->field($model, 'direct_capacity')->hiddenInput(['placeholder'=>'Please enter programme direct capacity'])->label(false) ?>

    <?= $form->field($model, 'equivalent_capacity')->hiddenInput(['placeholder'=>'Please enter programme equivalent capacity'])->label(false) ?>

    <?= $form->field($model, 'local_amount')->textInput(['placeholder'=>'Please enter tutition fee in TZS']) ?>

    <?= $form->field($model, 'foreign_amount')->textInput(['placeholder'=>'Please enter tutition fee in USD']) ?>

    <?= $form->field($model, 'loan_priority')->hiddenInput(['maxlength' => true,'placeholder'=>'Please describe loan priority'])->label(false) ?>

    <?= $form->field($model, 'status')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?php /* $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map([['id'=>'1','name'=>'Visible'],['id'=>'0','name'=>'Invisible']],'id','name'),
        'language' => 'en',
        'options' => ['placeholder' => '-- Please select programme status --'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])
 */
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save Details' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default text-bold' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
