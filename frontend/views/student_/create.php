<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentDetails */

$this->title = 'Create Student Details';
$this->params['breadcrumbs'][] = ['label' => 'Student Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
