<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounts-form">

    <?php $form = ActiveForm::begin(['options' => [
                'class' => 'form-horizontal'
             ]]); ?>
			
		<div class="col-sm-12">
		<?= $form->field($model, 'username')->textInput([ 'placeholder'=>'Please enter username','class'=>'form-control','id'=>'email','maxlength' => true])->label(false) ?>
		</div>
		<div class="col-sm-12">
			<?= $form->field($model, 'password_hash')->passwordInput(['placeholder'=>'Please enter password','class'=>'form-control','id'=>'email','maxlength' => true])->label(false) ?>
		</div>
	
    <div class="form-group">
	<div class="col-lg-12">
        <?= Html::submitButton($model->isNewRecord ? 'Log In' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning col-lg-12' : 'btn btn-primary col-lg-12']) ?>
    </div>
    </div>

    

    <?php ActiveForm::end(); ?>

</div>
