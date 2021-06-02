<?php

use yii\widgets\DetailView;
use app\models\Common;
use yii\helpers\Html;
?>
<div class="text-center text-bold"><img src="<?=Yii::getAlias("@web")?>/logo/logo.png" height="120px" width="120px"/></div>
<div class="text-center" style="font-size:18px;margin-top:6px"><span><b>THE UNIVERSITY OF DODOMA</b></div>
<div class="text-center" style="font-size:16px;margin-top:5px"><span>The University of Dodoma Bill</div>

<div style="border-top:dotted 2px #ccc;border-bottom:dotted 2px #ccc;margin-top:15px;font-size:14px">       

        <table class="table" >
        <tr><td style="padding-left:10px;height:50px;width:40%">Control Number</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$model->control_number?></td></tr>
            <tr ><td style="padding-left:10px;height:50px">Payment Reference</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$model->bill_item_ref?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Payer Name</td><td style="padding-left:10px;text-transform:uppercase">: <?=$model->payer_name?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Payer Phone</td><td style="padding-left:10px;text-transform:uppercase">: <?=$model->payer_cell_num?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Bill Description</td><td style="padding-left:10px;text-transform:uppercase">: <?=$model->bill_description?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Billed Amount</td><td style="padding-left:10px;text-transform:uppercase">: <?="<b>".$model->bill_currency." ".number_format($model->bill_amount,2)."</b>"?></td></tr>
           
        </table>
        


</div>
<div style="margin-top:15px;font-size:14px">       

        <table class="table" >
            <tr><td style="padding-left:10px;height:50px;width:40%">Generated on</td><td style="padding-left:10px;text-transform:uppercase">: <?=date('d-m-Y',strtotime($model->bill_gen_date))?></td></tr>
            <!--tr><td style="padding-left:10px;height:50px">Expire</td><td style="padding-left:10px;text-transform:uppercase">: <?=date('d-m-Y',strtotime($model->bill_exp_date))?></td></tr-->
            <tr><td style="padding-left:10px;height:50px">Printed By</td><td style="padding-left:10px;text-transform:capitalize;font-weight:bold">: <?=Yii::$app->user->identity->username?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Signature</td><td style="padding-left:10px;text-transform:uppercase">:______________</td></tr>   
            <tr><td colspan="2" style="padding:10px;margin-top:80px;font-size:14px">
     
  
     <p>
        Make payments through Bank(NMB Bank / CRDB Bank/ EXIM Bank) or Mobile (Airtel Money / Halopesa / MPESA / TigoPesa / TPesa by selecting "Government Payments"). User provided Control Number as your payment reference.
       Lipa kupitia Benki (NMB Benki / CRDB Benki/ EXIM Benki) au mitando (Airtel Money / Halopesa / MPESA / TigoPesa / TPesa kwa kuchagua "Malipo ya Serikali"). Tumia Namba ya Malipo uliyopewa kama Kumbukumbu ya Malipo.
     </p>
 </td></tr>
        </table>
        


</div>


