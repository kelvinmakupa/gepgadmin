<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblReconcilliation */

$this->title = 'Reconciliation Panel';
$this->params['breadcrumbs'][] = ['label' => 'Available Reconciliations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-eye"></i><?= Html::encode(' Reconciliation Details') ?></div>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('update-reconcilliation'))?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('delete-reconcilliation'))?Html::a('Delete', ['delete', 'id' => $model->id], [
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
            //'user_id',
            [
                'attribute'=>'user_id',
                'format'=>'text',
                'value'=>function($data){
                        return \app\models\Common::getNames($data->user_id);
                }
            ],
            'reconc_id',
            'trx_date',
//            'recon_opt',
            [
                'attribute'=>'recon_opt',
                'format'=>'text',
                'value'=>function($data){
                    return \app\models\Common::getReconOption($data->recon_opt);
                }
            ],
            'file_name',
            'created_at',
        ],
    ]) ?>

</div>
</div>
