<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MenuPanel;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ExchangeRateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exchange Rates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Available Data') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('create-exchange'))?Html::a('Create Exchange Rate', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             //'id',
            'currency',
            'amount',
            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>MenuPanel::getActions(Yii::$app->controller->id),
            ],
        ],
    ]); ?>
</div>
</div>
