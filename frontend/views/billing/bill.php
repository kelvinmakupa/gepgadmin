<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\TblBilling;
use kartik\alert\Alert;
use kartik\dialog\DialogAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblBillingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Billings';
$this->params['breadcrumbs'][] = $this->title;
DialogAsset::register($this);
$urlReservationsByCustomer = Url::to(['billing/sample']);

?>

<div class="customer-form">
	<div class="tbl-billing-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <button class="btn btn-default" id='bill_students'>Start Billing</button>
    </p>
	
</div>
    <div id="loader"></div>
    </div>
    <div id='responseStatus'></div>
    <div id='response'></div>


</div>
<?php
$url="'".Yii::$app->urlManager->createUrl(['billing/sample'])."'";
$js=<<<JS
$("#bill_students").click(function(){
$('#loader').show();
var url =$url;
//alert('url::'+url);

$.ajax({
            type: "POST",
            url : url,
            async: true,
            data : {short_name: ''},
            success : function(data) {
				$('#loader').hide();
             //   document.getElementById('response').innerHTML=String(data);
               alert(JSON.stringify(data));
                },
             error: function(data){
			  $('#loader').hide();
			  var status=data['status'];
			  var statusText=data['statusText'];
			  var responseText=data['responseText'];
			  var data="Status : "+statusText+"\\nResponseText : "+responseText;
             // alert("Status : "+statusText+"<br>ResponseText : "+responseText);
			 //  
			 alert(data);
			 
			 if(status==500){
				 responseText='Student billing has already being conducted on the current academic year';
			 }
			   document.getElementById('responseStatus').innerHTML="<p style='color:red;font-size:16px;font-weight:bold;font-family:arial'>"+statusText+' ('+status+')'+"</p>";
			   document.getElementById('response').innerHTML="<p style='color:red;font-size:16px;font-weight:bold;font-family:arial'>"+responseText+"</p>";
            }
        });
        

    });

      

JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>
<style type="text/css">

    #loader{
        position: fixed;
        display:none;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url(<?=Yii::getAlias('@web').'/uploads/Spinner.gif'?>) 50% 50% no-repeat rgba(0,0,0,0.8);

</style>