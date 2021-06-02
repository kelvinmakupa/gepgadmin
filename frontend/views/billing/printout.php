<?php

use yii\widgets\DetailView;
use app\models\Common;
use yii\helpers\Html;
?>
<div class="text-center text-bold"><img src="<?=Yii::getAlias("@web")?>/logo/logo.png" height="100px" width="100px"/></div>
<div class="text-center"><span><b>THE UNIVERSITY OF DODOMA</b></div>

<div class="panel panel-info">

        <table class="table table-bordered" >
            <tr ><td style="padding-left:10px;height:30px;font-weight: bold">Item Reference</td><td style="padding-left:10px"><?=$model->bill_item_ref?></td></tr>
            <tr><td style="padding-left:10px;height:30px;font-weight: bold">Control Number</td><td style="padding-left:10px"><?=$model->control_number?></td></tr>
            <tr><td style="padding-left:10px;height:30px;font-weight: bold">Payer Name</td><td style="padding-left:10px"><?=$model->payer_name?></td></tr>
            <tr><td style="padding-left:10px;height:30px;font-weight: bold">Payment Type</td><td style="padding-left:10px"><?=Common::getPaymentNameById($model->payment_type_id)?></td></tr>
            <tr><td style="padding-left:10px;height:30px;font-weight: bold">Bill Amount</td><td style="padding-left:10px"><?=$model->bill_amount?></td></tr>
            <tr><td style="padding-left:10px;height:30px;font-weight: bold">Bill Equivalent Amount<br/> <span style="font-weight:normal">(<i>Applicable for non TZS</i>)</span></td><td style="padding-left:10px"><?=$model->bill_eqv_amount?></td></tr>
            <tr><td style="padding-left:10px;height:30px;font-weight: bold">Bill Currency</td><td style="padding-left:10px"><?=$model->bill_currency?></td></tr>
            <tr><td style="padding-left:10px;height:30px;font-weight: bold">Bill Description</td><td style="padding-left:10px"><?=$model->bill_description?></td></tr>
            <tr><td colspan="2" style="padding:10px">

                    <p ><b>Note:</b></p>
                    <p>Payment can be made through the following channels:<b> CRDB Bank, NMB Bank, EXIM Bank, MPesa, TigoPesa or Airtel Money.</b> </p>

                </td></tr>

        </table>


        </div>



