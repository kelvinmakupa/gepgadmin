<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SystemSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'System Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Yii::$app->user->can('create-systemsetting')?Html::a('Create System Setting', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'acronym',
            'full_name',
            'email:email',
            'phone',
            // 'avatar',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
