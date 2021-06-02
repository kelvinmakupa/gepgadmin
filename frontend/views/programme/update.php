<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Programmes */

$this->title = 'Programmes Management';
$this->params['breadcrumbs'][] = ['label' => 'Available Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->programme_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-edit"></i><?= Html::encode(' Update Programme') ?></div>
    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
