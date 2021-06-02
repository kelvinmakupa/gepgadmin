<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblReconcilliationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reconcilliation Panel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i> <?= Html::encode(' Reconcilliation Details') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">

    <p>
        <?= (Yii::$app->user->can('create-reconcilliation'))?Html::a(' Make Reconcilliation', ['create'], ['class' => 'btn btn-default']):'' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute'=>'user_id',
                'filter'=> \yii\helpers\ArrayHelper::map(\app\models\User::find()->all(),'id','username'),
                'format'=>'text',
                'value'=>function($data){
                    return \app\models\Common::getNames($data->user_id);
                }
            ],
            'reconc_id',
            'trx_date',
           //'recon_opt',
            [
                'attribute'=>'recon_opt',
                'filter'=>yii\helpers\ArrayHelper::map(array(['id'=>'1','name'=>'GePG successful transactions'],['id'=>'2','name'=>'Exception report after reconciliation between GePG and bank']),'id','name'),
                'format'=>'text',
                'value'=>function($data){
                    return \app\models\Common::getReconOption($data->recon_opt);
                }
            ],
//            'file_name',
            [
                'attribute'=>'file_name',
                'format'=>'html',
                'value'=>function($data){
                    return "<a href='".Yii::$app->urlManager->createUrl(['reconcilliation/download','token'=>base64_encode($data->file_name)])."' target='_blank'>".$data->file_name."</a>";
                }
            ],
            'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
</div>
