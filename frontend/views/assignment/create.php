<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */

$this->title = 'Auth Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Auth Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class='fa fa-lock'></i> <?= Html::encode(' Assign User Permission') ?>
    </div>
    <div class='panel-body'>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
