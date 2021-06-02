<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProgrammesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programmes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programmes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= (Yii::$app->user->can('create-programme'))?Html::a('Create Programmes', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'code',
           // 'level',
            [
                'attribute'=>'level',
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\QualificationType::find()->where(['<>','id','3'])->all(),'id','name'),
                'format'=>'raw',
                'value'=>function($dataProvider){
                    return \app\models\QualificationType::find()->where(['id'=>$dataProvider->level])->one()->name;
                }
            ],
            'programme_name',
            [
                'attribute'=>'status',
                'filter'=>Array('0'=>'Invisible','1'=>'Visible'),
                'format'=>'raw',
                'value'=>function($dataProvider){
                    return ($dataProvider->status=='1')?'Visible':'Invisible';
                }
            ],
            //'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
