<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuPanelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Available Menus') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('create-menupanel'))?Html::a('Add Menu', ['create'], ['class' => 'btn btn-primary']):'' ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'type',
            'parent_id',
            'name',
            'redirect',
            // 'user',
            // 'status',
            // 'order_index',
            // 'icon',

            [
			'class' => 'yii\grid\ActionColumn',
			'header'=>'Actions',
			'headerOptions' => ['style' => 'color:#337ab7'],
			],
    ]]); ?>
</div>
</div>
