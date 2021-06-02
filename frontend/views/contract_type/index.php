<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Contract Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-contract-type-index">

<div class="row">
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
                                'attribute' => 'name',
                                'label' => 'Contract Type'
                            ],
                            [
                                'attribute' => 'short_name',
                                'label' => 'Acronym Name'
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
                    <?=Html::a('Create Contract Type', ['create'], ['class' => ''])?>
                </div>
            </div>
        </div>
    </div>
</div>
