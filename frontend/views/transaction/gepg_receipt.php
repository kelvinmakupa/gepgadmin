<?php

use yii\widgets\DetailView;
use app\models\Common;
use yii\helpers\Html;

$currency=($model->ccy=='TZS')?' Tanzania Shillings only.':' USD Dollar only.';

?>
<div class="text-center text-bold"><img src="<?=Yii::getAlias("@web")?>/logo/qr.png" height="100px" width="100px"/></div>
<div class="text-center" style="font-size:18px;margin-top:6px"><span><b>THE UNIVERSITY OF DODOMA</b></div>
<div class="text-center" style="font-size:16px;margin-top:5px"><span>Stakabadhi ya Malipo ya Chuo Kikuu Dodoma</div>

<div style="border-top:dotted 2px #cccccc">
        <table class="table" >
            <tr><td style="padding:10px 0 10px 5px;width:25%">Receipt No</td><td colspan="3" style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$model->pay_ref_id?></td></tr>
            <tr ><td style="padding:10px 0 10px 5px;">Received From</td><td colspan="3" style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$bill->payer_name?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">Amount</td><td colspan="3" style="padding-left:10px;text-transform:uppercase">: <?=number_format($model->paid_amount,2)." ({$model->ccy})"?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">Amount In Words</td><td colspan="3" style="padding-left:10px;text-transform:capitalize">: <?=Common::numberTowords($model->paid_amount).$currency?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">Outstanding Balance</td><td colspan="3" style="padding-left:10px;text-transform:uppercase">: <?=number_format($data['balance'],2)." ({$model->ccy})"?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">In respect of</td><td colspan="2" style="padding:10px 0 10px 0;font-weight:bold">Item Description(s)</td><td style="text-align:right;font-weight:bold">Item Amount</td></tr>
            <tr><td colspan="4" style="border-top:solid 1px #cccccc"></td></tr>
            <tr><td style="padding:10px 0 10px 0"></td><td colspan="2" style="padding:10px 0 10px 0"><?=$payment->gfs_code.' - '.$payment->gfs_description?></td><td style="text-align:right"><?=number_format($data['billed_amount'],2)?></td></tr>
            <tr><td></td><td colspan="3" style="border-top:solid 1px #cccccc"></td></tr>
            <tr><td colspan="2" style="padding:10px 0 10px 0"></td><td style="padding:10px 0 10px 0">Total Billed Amount</td><td style="text-align:right"><?=number_format($data['billed_amount'],2)."({$model->ccy})"?></td></tr>
            <tr><td colspan="2"></td><td colspan="2" style="border-top:solid 1px #cccccc"></td></tr>

            <tr><td style="padding:10px 0 10px 5px;">Bill References</td><td colspan="2" style="padding-left:10px;text-transform:uppercase">: <?=$bill->bill_item_ref?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">Payment Control Number</td><td colspan="2" style="padding-left:10px;text-transform:uppercase">: <?="<b>".$model->pay_control_num."</b>"?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">Payment Date</td><td colspan="2" style="padding-left:10px">: <?=date('d-F-Y',strtotime($model->trx_dt_tm))?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">Issued By</td><td colspan="2" style="padding-left:10px;text-transform:capitalize">: <?=Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">Date Issued</td><td colspan="2" style="padding-left:10px">: <?=date('d-F-Y',time())?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;">Signature</td><td colspan="2" style="padding-left:10px;text-transform:uppercase">:______________</td></tr>

        </table>
        


</div>


