<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Registered Debtors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-debtor-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Actions</h3>
                </div>
                <div class="box-body">
                <i class="fa fa-plus-square"></i>&nbsp;<?=Html::a('Register Debtor', ['create'], ['class' => ''])?>
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

                            'company_name',
                            'first_name',
                            'middle_name',
                            'last_name',
                            [
                                'attribute' => 'debtor_type_id',
                                'label' => 'Debtor Type',
                                'value' => function($model) {
                                    return $model->debtorType->name;
                                }
                            ],
                            'tin_no',
                            'check_no',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
