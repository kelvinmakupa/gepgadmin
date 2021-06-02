<?php

use yii\helpers\Html;
#use yii\grid\GridView;
use kartik\grid\GridView;
use app\models\AccountRole;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = $this->title;
$viewMsg='View Details';
$updateMsg='Update Details';
$deleteMsg='delete Details';
$scrollingTop='Scroll Top';
?>
<div class="user-index">

    <h1><?= Html::encode('Available Users') ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php

    $gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn'
       
    ],
        'first_name',
        'last_name',
        'surname',
        'sex',
        'username',  
       // 'auth_key',
        // 'password_hash',
        // 'password_reset_token',
        'email:email',
        //'role_id',
        //'avatar',
      //  'status',
        [
            'attribute'=>'status',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>\yii\helpers\ArrayHelper::map(\app\models\User::getAccountStatus(1,true),'id','name'),
            'filterInputOptions'=>['placeholder'=>'search by account status'],
            'filterWidgetOptions'=>[
                'pluginOptions'=>[
                    'allowClear'=>true
                ]
            ],
            'value'=>function($model){
                return \app\models\User::getAccountStatus($model->status);
            }
        ],
        [
            'attribute'=>'role_id',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>\yii\helpers\ArrayHelper::map(AccountRole::find()->all(),'role_id','role_name'),
            'filterInputOptions'=>['placeholder'=>'search by account role'],
            'filterWidgetOptions'=>[
                'pluginOptions'=>[
                    'allowClear'=>true
                ]
            ],
            'value'=>function($model){
                return \app\models\AccountRole::getRoleName($model->role_id) ;
            }
        ],
//        'created_at',
//        'updated_at',
    [
    'class' => 'kartik\grid\ActionColumn',
    'dropdown' => false,
    'vAlign'=>'middle',
        'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id),
        'buttons'=>[
            'password'=> function($url,$model,$key){
                return Html::a('<i class="fa fa-key"></i>',$url);
            },

        ],
//    'urlCreator' => function($action, $model, $key, $index) {
//            return '#'; },
    'viewOptions'=>['title'=>$viewMsg, 'data-toggle'=>'tooltip'],
    'updateOptions'=>['title'=>$updateMsg, 'data-toggle'=>'tooltip'],
    'deleteOptions'=>['title'=>$deleteMsg, 'data-toggle'=>'tooltip'],
    ],
   // ['class' => 'kartik\grid\CheckboxColumn']
    ];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'rowOptions'=>function($model){      
                
            return ['class'=>($model->status==0)?'danger':'default'];
        
        },
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
//        'beforeHeader'=>[
//            [
//                'columns'=>[
//                    ['content'=>'Header Before 1', 'options'=>[ 'class'=>'text-center warning']],
//                    ['content'=>'Header Before 2', 'options'=>['class'=>'text-center warning']],
//                    ['content'=>'Header Before 3', 'options'=>[ 'class'=>'text-center warning']],
//                ],
//                'options'=>['class'=>'skip-export'] // remove this row from export
//            ]
//        ],
        'toolbar' =>  [
            ['content'=>
                Yii::$app->user->can('create-user')?Html::a('Add New User', ['create'], ['class' => 'btn btn-default']):''
            ],
            '{export}',
            '{toggleData}'
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
        'showPageSummary' => false,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT
        ],
    ]);
    ?>
</div>
