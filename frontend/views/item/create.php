<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = 'Admin Panel' ;
$this->params['breadcrumbs'][] = ['label' => $labels['Items'], 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
    <i class="fa fa-plus"></i><?= Html::encode(' Create ' . $labels['Item']) ?>
    </div>
    <div class="panel-body">
    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
</div>
