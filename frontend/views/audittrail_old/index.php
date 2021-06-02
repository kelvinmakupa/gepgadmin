<?php

use yii\helpers\Html;
use kartik\grid\GridView;

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
            'entry_id',
            'user_id',
            // [
            //     'attribute'=>'user_id',
            //     'filterType'=>GridView::FILTER_SELECT2,
            //     // 'filter'=>\yii\helpers\ArrayHelper::map(Yii::$app->db->createCommand("select id as user_id,concat(first_name,' ',surname)  as name from user")->queryAll(),'user_id','name'),
            //     'filterInputOptions'=>['placeholder'=>'search by user name'],
            //     'filterWidgetOptions'=>[
            //         'pluginOptions'=>[
            //             'allowClear'=>true
            //         ]
            //     ],
            //     'value'=>function($model){
            //            return ($mod=\app\models\User::find()->where('id=:id',[':id'=>$model->id])->one())?$mod->username :'';
            //     }
            // ],   
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
