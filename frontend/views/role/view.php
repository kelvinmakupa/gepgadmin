<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccountRole */

$this->title = 'Manage Account Role';
$this->params['breadcrumbs'][] = ['label' => 'Account Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View Details';
?>
<div class="account-role-view">

    <p>
        <?= Yii::$app->user->can('update-role')?Html::a('Update', ['update', 'id' => $model->role_id], ['class' => 'btn btn-primary']):'' ?>
        <?= Yii::$app->user->can('delete-role')?Html::a('Delete', ['delete', 'id' => $model->role_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):'' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'buttons1'=>'',
        'buttons2'=>'',
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<strong><i class="fa fa-user"></i> Account Roles</strong> ',
            'type'=>DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            'role_id',
            'role_name',
        ],
    ]) ?>

</div>
