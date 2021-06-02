<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompaniesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Companies Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-bank"></i><?= Html::encode(' Available Companies') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('create-companies'))? Html::a('Add Companies', ['create'], ['class' => 'btn btn-default']):'' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'company_code',
            'full_name',
            'phone_number',
            'email_address:email',
//            'is_active',
            [
                'attribute'=>'is_active',
                'filter'=>yii\helpers\ArrayHelper::map(array(['id'=>'0','name'=>'Inactive'],['id'=>'10','name'=>'Active']),'id','name'),
                'format'=>'text',
                'value'=>function($model){
                    return ($model->is_active==10)?"Active":"Inactive";
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
