<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccountRole */

$this->title = 'Manage Account Role';
$this->params['breadcrumbs'][] = ['label' => 'Account Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->role_name, 'url' => ['view', 'id' => $model->role_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-default">
    <div class="panel-heading panel-default">
        <strong><i class="fa fa-user"></i> Update Account Role</strong>
    </div>

    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
