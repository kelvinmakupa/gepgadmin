<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dmstr\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';
$message = 'Sign in to start your session';
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box" style="margin-top:10%">
    <!--div class="login-logo">
        <a href="#"><b>UDOM</b>OAS</a>
    </div>
    <!-- /.login-logo -->
    <?= Alert::widget() ?>
    <!--p class="profile-username text-center">Sign in to start your session</p-->
    <h3 class="profile-username text-center"><?= $this->title ?></h3>

    <p class="text-muted text-center"><?= $message ?></p>
    <div class="login-box-body">

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            // ->label(false)
            ->textInput(['placeholder' => 'Please enter username']) ?>

        <?= $form
            ->field($model, 'password_hash', $fieldOptions2)
            //->label(false)
            ->passwordInput(['placeholder' => 'Please enter password']) ?>


        <!-- /.col -->

        <div class="form-group pull-right">
            <?= Html::submitButton('&nbsp;&nbsp;&nbsp;Sign In&nbsp;&nbsp;&nbsp;', ['class' => 'btn btn-primary text-bold']) ?>
        </div>

        <!-- <?= Yii::$app->security->generatePasswordHash('admin');?> -->

        <!-- /.col -->
        <?php ActiveForm::end(); ?>

        <!-- /.social-auth-links -->
    </div>


</div>
 