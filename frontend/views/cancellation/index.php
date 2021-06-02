<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblCancellationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cancelled Bills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-close"></i><?= Html::encode(' Available Details') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="panel-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'user_id',
            [
                'attribute'=>'user_id',
                'filter'=> \yii\helpers\ArrayHelper::map(\app\models\User::find()->all(),'id','username'),
                'format'=>'text',
                'value'=>function($data){
                    return \app\models\Common::getNames($data->user_id);
                }
            ],
           // 'bill_id',
            [
                'attribute'=>'bill_id',
                'format'=>'raw',
                'value'=>function($model){
                 return Html::a($model->bill_id,['billing/view', 'id' =>  \app\models\Common::getIdFromBillId($model->bill_id)],['class' => 'text-primary']);
                }
            ],
            'reason',
            'response_message',
            //'gepg_response',
            'date_cancelled',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
</div>
