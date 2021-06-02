<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logfiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logfile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Logfile', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'ip_address',
            'operation:ntext',
            'operation_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
