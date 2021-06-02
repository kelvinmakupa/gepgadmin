<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TblCancellation */

$this->title = 'Create Tbl Cancellation';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Cancellations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-cancellation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
