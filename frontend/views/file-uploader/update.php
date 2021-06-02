<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblFileUploaded */

$this->title = 'Update Tbl File Uploaded: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl File Uploadeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-file-uploaded-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
