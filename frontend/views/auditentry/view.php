<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuditEntrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Audit Entries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Audit Entry Details') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Yii::$app->user->can('create-auditentry')?Html::a('Create Audit Entry', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'created',
            [
                'attribute'=>'user_id',
                'format'=>'text',
                'value'=> ($user=$model->user)?$user->username:NULL,
            ],
            'duration',
            'ip',
            'request_method',
            'ajax',
            'route',
            'memory_max',
        ],
    ]) ?>
</div>
