<?php

use yii\widgets\DetailView;
use app\models\Common;
use yii\helpers\Html;
?>
<div class="text-center text-bold"><img src="<?=Yii::getAlias("@web")?>/logo/logo.png" height="120px" width="120px"/></div>
<div class="text-center" style="font-size:18px;margin-top:6px"><span><b>THE UNIVERSITY OF DODOMA</b></div>
<div class="text-center" style="font-size:16px;margin-top:5px"><span>Stakabadhi ya Malipo ya Chuo Kikuu Dodoma</div>

<div style="border-top:dotted 2px #ccc;border-bottom:dotted 2px #ccc;margin-top:15px;font-size:14px">
        <table class="table" >
        <tr><td style="padding-left:10px;height:50px;width:40%">Receipt No</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$model->pay_ref_id?></td></tr>
            <tr ><td style="padding-left:10px;height:50px">Received From</td><td style="padding-left:10px;text-transform:uppercase">: <?=$bill->payer_name?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Amount</td><td style="padding-left:10px;text-transform:uppercase">: <?=number_format($model->paid_amount,2).' '.$model->ccy?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Amount In Words</td><td style="padding-left:10px;text-transform:capitalize">: <?=Common::numberTowords($model->paid_amount)?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Bill References</td><td style="padding-left:10px;text-transform:uppercase">: <?=$bill->bill_item_ref?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Payment Control Number</td><td style="padding-left:10px;text-transform:uppercase">: <?="<b>".$model->pay_control_num."</b>"?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Payment Date</td><td style="padding-left:10px;text-transform:uppercase">: <?="<b>".date('Y-m-d H:i:s',strtotime($model->trx_dt_tm))."</b>"?></td></tr>

        </table>
        


</div>
<div style="margin-top:15px;font-size:14px">       

        <table class="table" >
            <tr><td style="padding-left:10px;height:50px">Issued By</td><td style="padding-left:10px;text-transform:capitalize;font-weight:bold">: <?=Yii::$app->user->identity->username?></td></tr>
            <tr><td style="padding-left:10px;height:50px">Signature</td><td style="padding-left:10px;text-transform:uppercase">:______________</td></tr>   
            <tr><td colspan="2" style="padding:10px;margin-top:80px;font-size:14px">

     <p class="text-center"></p>
 </td></tr>
        </table>
        


</div>


