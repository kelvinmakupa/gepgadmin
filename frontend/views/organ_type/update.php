<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblOrganType */

$this->title = 'Update Organ Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Organ Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-organ-type-update">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=Html::encode($this->title)?></h3>
                </div>
                <div class="box-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
