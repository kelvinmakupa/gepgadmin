<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Common;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblBillingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Billing Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading" ><i class="fa fa-list"></i><?= Html::encode(' Available Billings') ?></div>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('create-billing'))?Html::a('Generate Bill', ['create'], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('Cancel Bill Access'))?"<input type='button' class='btn btn-danger' value='Cancell Bills' id='cancell'>":""?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],
        'id' => 'grid',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],

            //'id',
            'payer_name',
            'bill_amount',
//            'bill_exp_date',
            //'bill_gen_date',
//            [
//                'attribute'=>'bill_gen_date',
//                'filter'=>false
//            ],
            'bill_description',
            //'bill_gen_by',
            //'bill_appr_by',
            //'payer_cell_num',
            //'payer_email:email',
            'bill_currency',
//            'payment_type_id',
            [
                'attribute'=>'payment_type_id',
                'format'=>'text',
                'value'=>function($data){
                 return \app\models\PaymentType::find()->where('id=:id',[':id'=>$data->payment_type_id])->one()->acc_description;
                }
            ]
            ,
            //'company_id',
            'bill_id',
            'control_number',
            // 'bill_pay_opt',
            //'use_on_pay',
            //'bill_eqv_amount',
            'bill_item_ref',
            // 'is_posted',
            [
                'attribute'=>'is_posted',
                'filter'=>\yii\helpers\ArrayHelper::map(array(['id'=>'1','name'=>'Drafted'],['id'=>'2','name'=>'Posted']),'id','name'),
                'format'=>'text',
                'value'=>function($data){
                     return Common::isPosted($data->is_posted);
                }
            ],
           // 'is_cancelled',
            [
                'attribute'=>'is_cancelled',
                'filter'=>\yii\helpers\ArrayHelper::map(array(['id'=>'1','name'=>'Not Cancelled'],['id'=>'2','name'=>'Cancelled']),'id','name'),
                'format'=>'text',
                'value'=>function($data){
                    return Common::isCancelled($data->is_cancelled);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>\app\models\MenuPanel::getActions(Yii::$app->controller->id),
                'buttons' => [

                    'delete' => function ($url, $model) {
                        if($model->is_posted==2){
                            return false;
                        }else{
                           return Html::a(' <i class="fa fa-trash text-red"></i>', ['delete', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this bill item?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    },
                    'update' => function ($url, $model) {
                        if($model->is_posted==2){
                            return false;
                        }else{
                           return Html::a(' <i class="fa fa-pen"></i>', ['update', 'id' => $model->id]);
                        }
                    },
                ],

            ],
        ],
    ]); ?>
</div>
    <!-- Modal form-->
    <div class="modal fade" id="myModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="modal-bodyku">
                </div>
                <div class="modal-footer" id="modal-footerq">
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal ------------------------------>
</div>
<?php
$script = <<< JS

  
    $(document).on('click','#cancell',function(e) {
      e.preventDefault();
            var content = '';
			var title = '<b class="text-center">UDOM BILLING SYSTEM</b>';
			var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

    var keys = $('#grid').yiiGridView('getSelectedRows'); // returns an array of pkeys, and #grid is your grid element id
     if(keys.length>0){
         
          var reason = prompt("Please enter reason for cancell bill item(s)");
          if ((reason != null)&&reason.length>10 ) {  
            $.ajax({
            type: "GET",
            url : '/billing/cancellbills.aspx',
            timeout: 30000,
			data : {keyslist:keys,reason:encodeURI(reason)},
            success : function(data) { 
			    
				var v=JSON.parse(data);
				
				if(v['code']==200){	
				    setModalBox(title,v['message'],footer);
		            $('#myModal').modal('show');
                
				}else{
                   setModalBox(title,v['message'],footer);
		            $('#myModal').modal('show');
                    
				  //  document.getElementById('response').innerHTML='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+v['message']+'</div>';
                }
				
			},
             error: function(data){
			alert(data);
			
			 // document.getElementById('response').innerHTML="<p style='color:red;font-size:16px;font-weight:bold;font-family:arial'>Failed to fetch your details. Please try again later</p>";
            }
        });

            }else{
                alert("No action can be taken without specify the reason for cancellation");
            }
     }else{
         alert('No data selected');
     }
     
     
   
    });

 function setModalBox(title,content,footer)
		{
			document.getElementById('modal-bodyku').innerHTML=content;
			document.getElementById('myModalLabel').innerHTML=title;
			document.getElementById('modal-footerq').innerHTML=footer;
        
            $('#myModal').attr('class', 'modal fade bs-example-modal-lg')
                .attr('aria-labelledby','myLargeModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-lg');
		
		}
JS;
$this->registerJs($script);
?>