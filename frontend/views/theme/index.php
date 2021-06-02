<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ThemeManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Theme Managers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-manager-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--p>
        <?= Html::a('Create Theme Manager', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'theme_name',
          //  'status',
            [
              'attribute'=>'status',
                'format'=>'raw',
                'value'=>function($dataProvider){
                    return ($dataProvider->status=='1')?'Active':'Inactive';
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
               'template'=>'{update}',
            ],
        ],
    ]); ?>
</div>
