<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = 'Admin Panel';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="panel panel-info">

    <div class="panel-heading">
             <i class="fa fa-list"></i><?= Html::encode(' Available '. $labels['Item'].'s') ?>
    </div>

    <div class="panel-body">
    <p>
        <?= Yii::$app->user->can('create-'.strtolower($labels['Item']))?Html::a('Create ' . $labels['Item'], ['create'], ['class' => 'btn btn-cons btn-success']):'' ?>
    </p>

        <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
            ],
//            [
//                'attribute' => 'ruleName',
//                'filter' => $rules
//            ],
            [
                'attribute' => 'description',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
               // 'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ])
    ?>

</div>
</div>
