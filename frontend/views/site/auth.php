<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-create">

    <?= $this->render('_auth', [
        'model' => $model,
    ]) ?>

</div>
