<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Logfile */

$this->title = 'Create Logfile';
$this->params['breadcrumbs'][] = ['label' => 'Logfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logfile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
