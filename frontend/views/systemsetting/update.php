<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemSetting */

$this->title = 'System Setting';
$this->params['breadcrumbs'][] = ['label' => 'System Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-setting-update">

    <h1><?= Html::encode('Update Details') ?></h1>

    <?= $this->render('_update', [
        'model' => $model,
    ]) ?>

</div>
