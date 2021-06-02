<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ThemeManager */

$this->title = 'Theme was updated';
$this->params['breadcrumbs'][] = ['label' => 'Theme Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-manager-view">

    <h1><?= Html::encode($model->theme_name) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!-- Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'theme_name',
           // 'status',
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=>function($model){
                    return ($model->status)?'Active':'Not Active';
                }

            ],
        ],
    ]) ?>

</div>
