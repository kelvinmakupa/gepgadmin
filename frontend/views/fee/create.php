<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FeeStructure */

$this->title = 'Fee Structure';
$this->params['breadcrumbs'][] = ['label' => 'Fee Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-plus"></i><?= Html::encode(' New Fee Structure Details') ?></div>
    <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>   
</div>
