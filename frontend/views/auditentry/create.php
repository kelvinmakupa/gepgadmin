<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AuditEntry */

$this->title = 'Create Audit Entry';
$this->params['breadcrumbs'][] = ['label' => 'Audit Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-entry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
