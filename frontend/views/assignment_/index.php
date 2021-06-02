<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AuthAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auth Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(" Available Items") ?></div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
    <p>
        <?= Html::a('Add Auth Assignment', ['create'], ['class' => 'btn btn-default text-bold']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_name',
//            'user_id',
            [
                'attribute'=>'user_id',

                'value'=>function($model){
                    return User::find()->where('id=:user',[':user'=>$model->user_id])->one()->username;
                }
            ],
            //'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
</div>
