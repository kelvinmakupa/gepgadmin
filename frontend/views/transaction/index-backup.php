<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use jino5577\daterangepicker\DateRangePicker; // add widget

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
$viewMsg='View Details';
$updateMsg='Update Details';
$deleteMsg='delete Details';
$scrollingTop='Scroll Top';


//use kartik\daterange\DateRangePicker;
//echo DateRangePicker::widget([
//	'model'=>$model,
//	'attribute'=>'datetime_range',
//	'convertFormat'=>true,
//	'pluginOptions'=>[
//		'timePicker'=>true,
//		'timePickerIncrement'=>30,
//		'locale'=>[
//			'format'=>'Y-m-d h:i A'
//		]
//	]
//]);
?>
<div class="transaction-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--p>
        <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->
    <?php

	$gridColumns = [
		['class' => 'kartik\grid\SerialColumn'],

		// 'id',
		//'billing_id',
		[
			'label'=>'Billing ID',
			'attribute'=>'billing_id',
			'format'=>'raw',
			'value'=>function($dataProvider){
				$url=Yii::$app->urlManager->createUrl('billing/'.$dataProvider->id);
				return html::a($dataProvider->id,$url,['title'=>'billing id']);
			},
		],
	//	'payment_channel',
		[
			'attribute'=>'payment_channel',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterInputOptions'=>['placeholder'=>'search by payment channel'],
			'filterWidgetOptions'=>[
				'pluginOptions'=>[
					'allowClear'=>true
				]
			]
		],
		'receipt_no',
		'transaction_ref',
		'amount_paid',
		//'received_date',
		//'transaction_date',
		[
			'attribute'=>'transaction_date',
			//'filterType'=>GridView::FILTER_DATE_RANGE,
			'filterInputOptions'=>['placeholder'=>'search by payment channel'],
			'filter'=>DateRangePicker::widget([
				'model'=>$searchModel,
				'attribute'=>'transaction_date',
								'convertFormat' => true,
				'pluginOptions'=>[
					'timePicker'=>true,
					'timePickerIncrement'=>30,
					'locale'=>[
						'format'=>'Y-m-d h:i A'
					]
				]
			]),
			'filterWidgetOptions'=>[
				'pluginOptions'=>[
					'allowClear'=>true
				]
			]
//			'filter'=>DateRangePicker::widget([
//				'model' => $searchModel,
//				'attribute' => 'transaction_date',
//				'convertFormat' => true,
//				'pluginOptions' => [
//					'allowClear'=>true
//
//				],
//			]),
//			'filter'=>DateRangePicker::widget([
//				'model'=>$searchModel,
//				'attribute'=>'transaction_date',
//				'convertFormat'=>true,
//				'pluginOptions'=>[
//					'timePicker'=>true,
//					'timePickerIncrement'=>30,
//					'locale'=>[
//						'format'=>'Y-m-d h:i A'
//					]
//				]
//			])
		],
		//'status',
		// 'status',
	/*	[
			'attribute'=>'status',
			'filterType'=>GridView::FILTER_SELECT2,
			'filter'=>\yii\helpers\ArrayHelper::map(array(['id'=>'0','name'=>'Inactive'],['id'=>'1','name'=>'Active']),'id','name'),
			'filterInputOptions'=>['placeholder'=>'search by status'],
			'filterWidgetOptions'=>[
				'pluginOptions'=>[
					'allowClear'=>true
				]
			],
			'value'=>function($model){
				return ($model->status>0)?'Active':'Inactive';
			}
		],
		//'currency_flag',
		[
			'attribute'=>'currency_flag',
			'filterType'=>GridView::FILTER_SELECT2,
			'filter'=>\yii\helpers\ArrayHelper::map(\app\models\Currency::getCurrency(1,true),'id','name'),
			'filterInputOptions'=>['placeholder'=>'search by currency'],
			'filterWidgetOptions'=>[
				'pluginOptions'=>[
					'allowClear'=>true
				]
			],
			'value'=>function($model){
				return \app\models\Currency::getCurrency($model->currency_flag);
			}
		],
//        [
//            'attribute'=>'role_id',
//            'filterType'=>GridView::FILTER_SELECT2,
//            'filter'=>\yii\helpers\ArrayHelper::map(AccountRole::find()->all(),'role_id','role_name'),
//            'filterInputOptions'=>['placeholder'=>'search by account role'],
//            'filterWidgetOptions'=>[
//                'pluginOptions'=>[
//                    'allowClear'=>true
//                ]
//            ],
//            'value'=>function($model){
//                return \app\models\AccountRole::getRoleName($model->role_id) ;
//            }
//        ],
//        'created_at',
//        'updated_at',
	*/
		[
			'class' => 'kartik\grid\ActionColumn',
			'dropdown' => false,
			'vAlign'=>'middle',
//    'urlCreator' => function($action, $model, $key, $index) {
//            return '#'; },
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
//        'beforeHeader'=>[
//            [
//                'columns'=>[
//                    ['content'=>'Header Before 1', 'options'=>[ 'class'=>'text-center warning']],
//                    ['content'=>'Header Before 2', 'options'=>['class'=>'text-center warning']],
//                    ['content'=>'Header Before 3', 'options'=>[ 'class'=>'text-center warning']],
//                ],
//                'options'=>['class'=>'skip-export'] // remove this row from export
//            ]
//        ],
		'toolbar' =>  [
			['content'=>''],
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
			'type' => GridView::TYPE_DEFAULT
		],
	]);


	?>
</div>
