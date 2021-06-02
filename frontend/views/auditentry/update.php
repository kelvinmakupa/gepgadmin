<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AuditEntry */

$this->title = 'Update Audit Entry: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Audit Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="audit-entry-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
