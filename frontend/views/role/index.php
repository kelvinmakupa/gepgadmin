<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Account Roles';
$this->params['breadcrumbs'][] = $this->title;
$viewMsg='View Details';
$updateMsg='Update Details';
$deleteMsg='delete Details';
$scrollingTop='Scroll Top';
?>
<div class="account-role-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
       // 'role_id',
        'role_name',


        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'vAlign'=>'middle',
            'viewOptions'=>['title'=>$viewMsg, 'data-toggle'=>'tooltip'],
            'updateOptions'=>['title'=>$updateMsg, 'data-toggle'=>'tooltip'],
            'deleteOptions'=>['title'=>$deleteMsg, 'data-toggle'=>'tooltip'],
        ],
        // ['class' => 'kartik\grid\CheckboxColumn']
    ];





    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
        'toolbar' =>  [
            ['content'=>
                Yii::$app->user->can('create-role')?Html::a('Add User Role', ['create'], ['class' => 'btn btn-default']):''
            ],
            '{export}',
            'exportConfig'=> [
                GridView::EXCEL => [
                    'label' => ( 'Exportar en Excel'),
                    'iconOptions' => ['class' => 'text-success'],
                    'showHeader' => true,
                    'showPageSummary' => true,
                    'showFooter' => true,
                    'showCaption' => true,
                    'filename' => ('myReportPDF'),
                    'alertMsg' => ( 'El archivo de exportación EXCEL se generará para descargar.'),
                    'options' => ['title' => ( 'Microsoft Excel 95+')],
                    'mime' => 'application/vnd.ms-excel',
                    'config' => [
                        'worksheet' => ( 'ExportWorksheet'),
                        'cssFile' => ''
                    ]
                ],
                GridView::HTML=>false,
                GridView::TEXT=>false,


            ],
            '{toggleData}'
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
        'showPageSummary' => false,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading'=>"<strong><i class='fa fa-user'></i> Account Roles</strong>"
        ],
    ]);




    ?>




</div>
