<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccountRole */

$this->title = 'Manage Account Role';
$this->params['breadcrumbs'][] = ['label' => 'Available Account Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Add User Role';
?>
<div class="panel panel-default">
    <div class="panel-heading">
    <strong><i class="fa fa-user"></i> New User Role</strong>
     </div>
    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
