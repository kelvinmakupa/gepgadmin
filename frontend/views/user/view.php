<?php

use yii\helpers\Html;
use app\models\AuthAssignment;
#use yii\widgets\DetailView;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = ['label' => 'Available Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-view">

    <p>
        <?= Yii::$app->user->can('create-user')?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('auth-user')&&AuthAssignment::find()->where(['user_id'=>$model->id])->one())?Html::a('Assignment', ['auth', 'id' => $model->id], ['class' => 'btn btn-success']):'' ?>
        <?= Yii::$app->user->can('delete-user')?Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):'' ?>
       </p>

    <?= DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,
        'fadeDelay'=>true,
        'buttons1'=>'',
        'buttons2'=>'',
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>Html::encode('User Details'),
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [

            'first_name',
            'last_name',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            //'role_id',
            [
                'attribute'=>'role_id',
                'format'=>'text',
                'value'=>\app\models\AccountRole::getRoleName($model->role_id)

            ],
           // 'avatar',
            [
                'attribute'=>'avatar',
                'format'=>'raw',
                'type'=>DetailView::INPUT_FILEINPUT,
                'value'=>"<img src='".Yii::getAlias('@web').'/uploads/'.$model->avatar."' height='100' width='100'>"

            ],
           // 'status',
            [
                'attribute'=>'status',
                'value'=> \app\models\User::getAccountStatus($model->status),
                'type'=>DetailView::INPUT_SELECT2,
                'widgetOptions'=>[
                    'data'=>yii\helpers\ArrayHelper::map(\app\models\User::getAccountStatus($model->status,true),'id','name'),
                    'options' => ['placeholder' => 'Select User Account Status'],
                    'pluginOptions' => ['allowClear'=>true]
                ],
            ],
           // 'created_at',
            [
                'attribute'=>'created_at',
                'type'=>DetailView::INPUT_TEXT,
                'value'=>date('d M Y G:i:s',$model->created_at)
            ],
            //'updated_at',
            [
                'attribute'=>'updated_at',
                'type'=>DetailView::INPUT_TEXT,
                'value'=>date('d M Y G:i:s',$model->updated_at)
            ],

        ],
    ]) ?>

</div>
