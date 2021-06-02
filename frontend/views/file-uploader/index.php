<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FileUploadedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Uploaded Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list-alt"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?>

    </div>

    <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-cloud-upload"></i>  Upload File', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
//            [
//                    'attribute'=>'user_id',
//                    'value'=>function($model){
//                        return ($user=$model->user)?$user->username:null;
//                    }
//            ],
            'file_name',
            'created_at',
            //'update_at',

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>'{view} {download}',
                    'buttons'=>[
                        'view'=>function($url,$model,$key){
                            return Html::a('<i class="fa fa-file"></i>',['billing-temp/details','token'=>base64_encode($key)],['title'=>'View file contents','class'=>'btn btn-info']);
                        },
                        'download'=>function($url,$model,$key){
                            return Html::a('<i class="fa fa-download"></i>',['file-uploader/download','token'=>base64_encode($key)],['title'=>'Download','class'=>'btn btn-default']);
                        }

                    ]
            ],
        ],
    ]); ?>
</div>
</div>
