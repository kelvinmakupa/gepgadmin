<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblFileUploaded */

$this->title = 'Uploaded Files';
$this->params['breadcrumbs'][] = ['label' => 'Uploaded files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-file-o"></i><?= Html::encode(' File Details') ?>
    </div>
    <div class="panel-body">
        <p>

            <?=Html::a('View File Contents',['billing-temp/details','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?= (Yii::$app->user->can('create-file-uploader'))?Html::a('Delete', ['delete', 'id' => $model->id], [
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
                // 'id',
                [
                    'attribute' => 'user_id',
                    'value' => ($user = $model->user) ? $user->username : null,
                ],
                'file_name',
                'created_at',
                'update_at',
            ],
        ]) ?>
    </div>
</div>
