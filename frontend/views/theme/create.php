<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ThemeManager */

$this->title = 'Create Theme Manager';
$this->params['breadcrumbs'][] = ['label' => 'Theme Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-manager-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
