<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FeeStructure */

$this->title = 'File Uploader';
$this->params['breadcrumbs'][] = ['label' => 'File Uploader', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-upload"></i><?= Html::encode(' File Uploader') ?></div>
    <div class="panel-body">

        <?= $this->render('_import', [
            'model' => $model,
        ]) ?>
    </div>
</div>
