<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblPaymentTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Available Payment Types') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('create-paymenttypes'))?Html::a('Add Payment Type', ['create'], ['class' => 'btn btn-primary']):'' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'acc_code',
            'acc_description',
            'gfs_code',
            'gfs_description',
            [
                'attribute'=>'status',
                'filter'=>array('1'=>'Visible','0'=>'Invisible'),
                'value'=>function($model){
                        return ($model->status==1)?'Visible':'Invisible';
                }
            ],    
            'created_at',
            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
</div>
