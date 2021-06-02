<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\MenuPanel;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GepgBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banks Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class='panel-heading'>
        <i class='fa fa-bank'></i><?= Html::encode(' Available Banks') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class='panel-body'>
    <p>
        <?= Yii::$app->user->can('create-gepgbank')?Html::a(' Add Bank', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'beneficiary_name',
            'bank_name',
            'account_name',
            'account_number',
            'swift_code',
            'acc_currency',
            //'is_visible',
            'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
              //  'template'=>MenuPanel::getActions(Yii::$app->controller->id),
            ],
        ],
    ]); ?>
</div>
</div>
