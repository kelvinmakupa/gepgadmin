<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */

$this->title = 'Billing Management';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-plus"></i><?= Html::encode(' Bill Generation Panel') ?></div>
    <div class="panel-body">

        <?php
            if(!empty(Yii::$app->request->get('ws'))){
                $tab=Yii::$app->request->get('ws');
            }else{
                $tab=$model->payer;
            }

        $items = [
            [
                'label'=>'<i class="fa fa-user"></i> Student Billing',
                'content'=>$this->render('_student',['model'=>$model]),
                'url'=>Url::to(['billing/create','ws'=>'3']),//Yii::$app->homeUrl.'billing/create.aspx',
                'active'=>$tab==3

            ],

            [
                'label'=>'<i class="fa fa-bank"></i> Companies / Registered User Billing',
                'content'=>$this->render('_company',['model'=>$model]),
                'url'=>Url::to(['billing/create','ws'=>'2']),//Yii::$app->homeUrl.'billing/create.aspx',
                'active'=>$tab==2

            ],

            [
                'label'=>'<i class="glyphicon glyphicon-user"></i> Other Billing',
                'content'=>$this->render('_individual',['model'=>$model]),
                //'active' => $tab === 1,
                'url'=>Url::to(['billing/create','ws'=>'1']),//Yii::$app->homeUrl.'billing/create.aspx',
                'active'=>$tab==1
            ],

        ];
        // Ajax Tabs Above
        echo TabsX::widget([
                'enableStickyTabs' => true,
                'stickyTabsOptions' => [
                    'selectorAttribute' => 'data-target',
                    'backToTop' => true,
                ],
            'items'=>$items,
            'position'=>TabsX::POS_ABOVE,
            'encodeLabels'=>false
        ]);


        ?>


</div>
<?php
$url="'".Yii::$app->urlManager->createUrl(['companies/details'])."'";
$js=<<<JS
$("#company_id").change(function(){
var depa=document.getElementById('company_id').value;
var url =$url;
// alert(url);
$.ajax({
           type: "POST",
           url : url,
           data : {company_id: depa},
           success : function(data) {
               var json=JSON.parse(data);
               if(json){
                   document.getElementById('payer_name').value=json.name;
                   document.getElementById('payer_phone').value=json.phone;
                   document.getElementById('payer_email').value=json.email;
                   document.getElementById('bill_item').value=json.code;
               }else{
                    empty();
               }
               },
            error: function(data){
                    empty();
	            }
       });
});
function empty(){
    document.getElementById('payer_name').value='';
    document.getElementById('payer_phone').value='';
    document.getElementById('payer_email').value='';
}
JS;
$this->registerJs($js, \yii\web\View::POS_READY);

    ?>