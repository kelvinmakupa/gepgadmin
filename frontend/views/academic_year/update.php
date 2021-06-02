<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblAcademicYear */

$this->title = 'Update Tbl Academic Year: ' . $model->year_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Academic Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->year_id, 'url' => ['view', 'id' => $model->year_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-academic-year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
