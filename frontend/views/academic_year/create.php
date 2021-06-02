<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblAcademicYear */

$this->title = 'Create Tbl Academic Year';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Academic Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-academic-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
