<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuditTrailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Audit Trails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Available Details') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Yii::$app->user->can('create-audittrail')?Html::a('Create Audit Trail', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute'=>'entry_id',
                'filter'=>false,
                'format'=>'html',
                'value'=>function($model){
                    return Html::a('View',Url::to(['auditentry/view','id'=>$model->entry_id]));
                }

            ]    ,
            [
                'attribute'=>'user_id',
                'format'=>'text',
                'value'=>function($model){
                    return ($user=$model->user)?$user->username:NULL;
                }
            ],
            'action',
            'model',
            'model_id',
            'field',
            'old_value:ntext',
            'new_value:ntext',
            'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
</div>
