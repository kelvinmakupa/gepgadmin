<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ThemeManager */

$this->title = 'Update Theme Manager';
$this->params['breadcrumbs'][] = ['label' => 'Theme Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="theme-manager-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
