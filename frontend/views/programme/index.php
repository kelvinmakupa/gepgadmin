<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProgrammesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Manage Programmes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Available Programmes') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('create-programme'))?Html::a('Add Programme', ['create'], ['class' => 'btn btn-default text-bold']):'' ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
         //   'code',
           // 'level',
            [
                'attribute'=>'level',
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\QualificationType::find()->all(),'id','name'),
                'format'=>'raw',
                'value'=>function($dataProvider){
                    return \app\models\QualificationType::find()->where(['id'=>$dataProvider->level])->one()->name;
                }
            ],
            'programme_name',
           // 'department_id',
//            [
//                'attribute'=>'department_id',
//                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\Department::find()->all(),'department_id','department_name'),
//                'format'=>'raw',
//                'value'=>function($dataProvider){
//                    $department_name='';
//                    if($m=\app\models\Department::find()->where(['department_id'=>$dataProvider->department_id])->one()){
//                        $department_name=$m->department_name;
//                    }
//                    return $department_name;
//                }
//            ],
            // 'admission_direct:ntext',
            // 'admission_equiv:ntext',
            // 'min_point',
            // 'programme_duration',
//            'capacity',
//            'direct_capacity',
//            'equivalent_capacity',
             'local_amount',
             'foreign_amount',
           //  'status',
            [
                'attribute'=>'status',
                'filter'=>\yii\helpers\ArrayHelper::map([['id'=>'0','name'=>'Inactive'],['id'=>'1','name'=>'Active']],'id','name'),
                'format'=>'raw',
                'value'=>function($dataProvider){
                    return ($dataProvider->status=='1')?'Active':'Inactive';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
</div>
