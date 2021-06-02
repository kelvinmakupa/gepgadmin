<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Registered Contracts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-contract-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Actions</h3>
                </div>
                <div class="box-body">
                    <ul class="list-unstyled">
                        <li> <i class="fa fa-plus-square"></i>&nbsp;<?=Html::a('Register Contract Type', ['contract_type/create'], ['class' => ''])?></li>
                        <li> <i class="fa fa-plus-square"></i>&nbsp;<?=Html::a('Register Contract', ['create'], ['class' => ''])?></li>
                    </ul>
                   
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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

                            'contract_no',
                            [
                                'attribute' => 'debtor_id',
                                'label' => 'Debtor'
                            ],
                            [
                                'attribute' => 'contract_type_id',
                                'label' => 'Contract Type',
                                'value' => function($model) {
                                    return $model->contractType->name;
                                }
                            ],
                            'start_date',
                            'end_date',
                            [
                                'attribute' => 'duration',
                                'label' => 'Duration (Per Month)'
                            ],
                            [
                                'attribute' => 'created_by',
                                'label' => 'Created By',
                                'value' => function($model) {
                                    return $model->createdBy->first_name.' '.$model->createdBy->last_name.' '.$model->createdBy->surname;
                                }
                            ],

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
