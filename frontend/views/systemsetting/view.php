<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SystemSetting */

$this->title = 'System Configuration';
$this->params['breadcrumbs'][] = ['label' => 'System Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-setting-view">

    <h1><?= Html::encode($model->acronym) ?></h1>

    <p>
        <?= Yii::$app->user->can('update-systemsetting')?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= Yii::$app->user->can('delete-systemsetting')?Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):'' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'acronym',
            'full_name',
            'email:email',
            'phone',
           // 'avatar',
			[
				'attribute'=>'avatar',
				'format'=>'raw',
				'value'=>function($model){
				return "<img src='".Yii::getAlias('@web').'/'.$model->avatar."' height='100px' width='100px'/>";
				}
			],
		//	'welcome_note',
			[
				'attribute'=>'welcome_note',
				'format'=>'raw',
				
			],
            'created_at',
        ],
    ]) ?>

</div>
