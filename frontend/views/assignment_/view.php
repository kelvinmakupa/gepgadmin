<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */

$this->title = $model->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-eye"></i>
        <?= Html::encode("Permission Detail") ?></div>
<div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'item_name' => $model->item_name, 'user_id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'item_name' => $model->item_name, 'user_id' => $model->user_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'item_name',
            'user_id',
            //  [
            //      'attribute'=>'user_id',
            //      'format'=>'raw',
            //      'value'=>function($dataProvider){
            //             return User::find()->where(['id'=>$dataProvider->user_id])->one()->username;
            //      }
            //     ],
            'created_at',
        ],
    ]) ?>
</div>
</div>
