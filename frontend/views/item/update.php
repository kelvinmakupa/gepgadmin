<?php

use yii\helpers\Html;

$context = $this->context;
$labels = $context->labels();
$this->title = 'Admin Panel';
$this->params['breadcrumbs'][] = ['label' => $labels['Items'], 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Update ' . $labels['Item'] . ': ' . $model->name) ?>
    </div>
    <div class="panel-body">
    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>
</div>
</div>