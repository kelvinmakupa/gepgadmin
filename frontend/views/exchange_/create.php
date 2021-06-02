<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExchangeRate */

$this->title = 'Create Exchange Rate';
$this->params['breadcrumbs'][] = ['label' => 'Exchange Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exchange-rate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
