<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dmstr\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['readonly'=>true,'value'=>Yii::$app->user->identity->id,'maxlength' => 150])->label(false) ?>

    <?= $form->field($model, 'username')->textInput(['readonly'=>true,'value'=>Yii::$app->user->identity->username,'maxlength' => 250]) ?>

    <?= $form->field($model, 'current_password')->passwordInput(['placeholder'=>'Enter current password','maxlength' => 250]) ?>

    <?= $form->field($model, 'password_hash')->passwordInput(['placeholder'=>'Enter new password','maxlength' => 250]) ?>

	<?= $form->field($model, 'repeat_password')->passwordInput(['placeholder'=>'Enter retype new password','maxlength' => 250]) ?>

    <div class="form-group">
        <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary']) ?>
    </div>
	<?= Alert::widget() ?>
    <?php ActiveForm::end(); ?>

</div>
