<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = 'Companies Management';
$this->params['breadcrumbs'][] = ['label' => 'Available Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Company Details') ?></div>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('update-companies'))?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('delete-companies'))?Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):'' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'company_code',
            'full_name',
            'phone_number',
            'email_address:email',
//            'is_active',
            [
                'attribute'=>'is_active',
                'format'=>'text',
                'value'=>function($data){
                    return ($data->is_active==10)?'Active':'Inactive';
                }
            ]
        ],
    ]) ?>

</div>
</div>
