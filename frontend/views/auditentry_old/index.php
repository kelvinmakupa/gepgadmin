<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AuditEntrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Audit Entries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Available Details') ?></div>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Yii::$app->user->can('create-auditentry')?Html::a('Create Audit Entry', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'user_id',
            [
                'attribute'=>'user_id',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>\yii\helpers\ArrayHelper::map(Yii::$app->db->createCommand("select id as user_id,concat(first_name,' ',surname)  as name from user")->queryAll(),'user_id','name'),
                'filterInputOptions'=>['placeholder'=>'search by user name'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>[
                        'allowClear'=>true
                    ]
                ],
                'value'=>function($model){
                       return ($mod=\app\models\User::find()->where('id=:id',[':id'=>$model->id])->one())?$mod->username :'';
                }
            ],   
            'duration',
            'ip',
            'request_method',   
            'ajax',
            'route',
            'memory_max',
            'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
