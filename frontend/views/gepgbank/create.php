<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GepgBank */

$this->title = 'Create Gepg Bank';
$this->params['breadcrumbs'][] = ['label' => 'Gepg Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-bank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
