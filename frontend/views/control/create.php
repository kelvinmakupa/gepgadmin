<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Capplication */

$this->title = 'Create Capplication';
$this->params['breadcrumbs'][] = ['label' => 'Capplications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capplication-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
