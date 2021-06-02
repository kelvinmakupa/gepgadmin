<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblDebtor */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Debtors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-debtor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'company_name',
            'first_name',
            'middle_name',
            'last_name',
            'sex',
            'phone',
            'email:email',
            'postal_address',
            'debtor_type_id',
            'tin_no',
            'check_no',
            'is_active',
            'created_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
