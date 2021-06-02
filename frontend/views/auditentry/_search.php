<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuditEntrySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="audit-entry-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'duration') ?>

    <?= $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'request_method') ?>

    <?php // echo $form->field($model, 'ajax') ?>

    <?php // echo $form->field($model, 'route') ?>

    <?php // echo $form->field($model, 'memory_max') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
