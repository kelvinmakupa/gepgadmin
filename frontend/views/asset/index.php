<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Registered Assets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-asset-index">

<div class="raw">
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=Html::encode($this->title)?></h3>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'asset_type_id',
                                'label' => 'Asset',
                                'value' => function($model) {
                                    return $model->assetType->name;
                                }
                            ],
                            [
                                'attribute' => 'asset_no',
                                'label' => 'Asset Number',
                            ],
                            [
                                'attribute' => 'block_no',
                                'label' => 'Block Number',
                            ],
                            [
                                'attribute' => 'location_id',
                                'label' => 'Asset Location',
                                'value' => function($model) {
                                    return $model->location->name;
                                }
                            ],

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Actions</h3>
                </div>
                <div class="box-body">
                    <?=Html::a('Register Asset', ['create'], ['class' => ''])?>
                </div>
            </div>
        </div>
    </div>
</div>
