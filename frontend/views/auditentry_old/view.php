<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AuditEntry */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Audit Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-entry-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created',
            'user_id',
            'duration',
            'ip',
            'request_method',
            'ajax',
            'route',
            'memory_max',
        ],
    ]) ?>

</div>
