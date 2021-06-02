<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TblBillingTemp */

$this->title = 'Create Tbl Billing Temp';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Billing Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-billing-temp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
