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
        <i class="fa fa-plus"></i> Assign Permission
    </div>
    <div class="panel-body">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
