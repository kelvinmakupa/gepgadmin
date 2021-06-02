<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Programmes */

$this->title = 'Manage Programmes';
$this->params['breadcrumbs'][] = ['label' => 'Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-plus"></i><?= Html::encode(' Add Programme') ?></div>
    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
