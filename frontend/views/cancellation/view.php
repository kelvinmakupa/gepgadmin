<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblCancellation */

$this->title = 'Bill Cancellation';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Cancellations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-close"></i><?= Html::encode(' Cancelled Bill Details') ?></div>
    <div class="panel-body">
    <p>
        <?=(Yii::$app->user->can('update-cancellation'))? Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?=(Yii::$app->user->can('delete-cancellation'))?Html::a('Delete', ['delete', 'id' => $model->id], [
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
//            'user_id',
            [
                'attribute'=>'user_id',
                'filter'=> \yii\helpers\ArrayHelper::map(\app\models\User::find()->all(),'id','username'),
                'format'=>'text',
                'value'=>function($data){
                    return \app\models\Common::getNames($data->user_id);
                }
            ],
            'bill_id',
            'reason',
            'response_message',
            'gepg_response',
            'date_cancelled',
        ],
    ]) ?>

</div>
</div>
