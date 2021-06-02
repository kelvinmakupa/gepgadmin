<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Programmes;
/* @var $this yii\web\View */
/* @var $model app\models\FeeStructure */
/* @var $form yii\widgets\ActiveForm */
$programme=($p=Programmes::find()->where(['program_id'=>$model->programme_id])->one())?$p->programme_name:$model->programme_id;
$this->title = 'Fee Structure ';
$this->params['breadcrumbs'][] = ['label' => 'Fee Structures', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $programme, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';


?>

<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-edit"></i> Update Fee Structure > <?=$programme?>
        </div>
<div class="panel-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payment_type_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'academic_year_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'programme_id')->hiddenInput(['readonly'=>true])->label(false) ?>

    <?= $form->field($model, 'year_of_study')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'local_amount')->textInput() ?>

    <?= $form->field($model, 'foreign_amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Update Details', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
