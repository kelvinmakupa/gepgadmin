<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MenuPanel */

$this->title = 'Menu Management';
$this->params['breadcrumbs'][] = ['label' => 'Menu Panels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-plus"></i> <?= Html::encode(' Add Menu | Submenu') ?></div>
<div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
