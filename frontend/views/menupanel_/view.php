<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\MenuPanel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Available Menu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-eye"></i><?= Html::encode(' Menu Details') ?></div>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('update-user'))?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('update-user'))?Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):'' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'parent_id',
            'name',
            'redirect',
//            'user',
            [
                'attribute'=>'user',
                'format'=>'raw',
                'value'=>function($model){
                    return User::find()->where('id=:id',[':id'=>$model->user])->one()->username;
                }
            ],
//            'status',
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=>function($model){
                  return ($model->status==10)?'Active':'In Active';
                }
            ],
            'order_index',
            [
                'attribute'=>'icon',
                'format'=>'raw',
                'value'=>function($model){
                    return '<i class="'.$model->icon.'"></i>';
                }
            ]
        ],
    ]) ?>
    </div>
</div>
