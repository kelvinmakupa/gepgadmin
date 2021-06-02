<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = ['label' => 'Available Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h2><?= Html::encode('Update User Details') ?></h2>

    <?= $this->render('_update', [
        'model' => $model,
    ]) ?>

</div>
