<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblAcademicYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Academic Years';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-academic-year-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Academic Year', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'year_id',
            'year',
            'status',
            'last_reg_no',
            'last_reg_no_graduate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
