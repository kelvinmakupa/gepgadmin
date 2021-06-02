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
                'format'=>'text',
                'value'=>function($model){
                    return ($user=$model->user)?$user->username:NULL;
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
