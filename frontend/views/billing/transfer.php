<?php

use yii\widgets\DetailView;
use app\models\Common;
use yii\helpers\Html;
?>
<div class="text-center text-bold"><img src="<?=Yii::getAlias("@web")?>/logo/logo.png" height="100px" width="100px"/></div>
<div class="text-center" style="font-size:18px;margin-top:6px"><span><b>THE UNIVERSITY OF DODOMA</b></div>
<div class="text-center" style="font-size:16px;margin-top:5px"><span>Order Form for Electronic Funds Transfer to <?=$bank->bank_name?></div>

<div style="border-top:dotted 2px #ccc;border-bottom:dotted 2px #ccc;margin-top:5px;font-size:14px">       

        <table class="table" >   
        <tr><td style="padding-left:10px;height:50px;width:40%;font-weight:bold">(a). Remitter / Tax Payer Details</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">:-</td></tr>
       
        <tr><td style="padding-left:10px;height:40px;width:40%">Name of Account Holder(s)</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">:..........................................................................................</td></tr>
        <tr><td style="padding-left:10px;height:40px;width:40%">Name of Commercial Bank</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">:..........................................................................................</td></tr>
        <tr><td style="padding-left:10px;height:40px;width:40%">Bank Account Number</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">:..........................................................................................</td></tr>

       
        <tr><td style="padding-left:10px;height:40px;width:40%;font-weight:bold">(b). Beneficiary Details :-</td><td style="padding-left:10px;text-transform:capitalize;font-weight:bold">: <?=$bank->beneficiary_name?></td></tr>
        <tr><td style="padding-left:10px;height:40px;width:40%"></td><td style="padding-left:10px;text-transform:capitalize;font-weight:bold">: <?=$bank->bank_name?></td></tr>
        <tr><td style="padding-left:60px;height:40px;width:40%">Account Number</td><td style="padding-left:10px;font-weight:bold">: <?=$bank->account_number?></td></tr>
        <tr><td style="padding-left:60px;height:40px;width:40%">SWIFT Code</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$bank->swift_code?></td></tr>
        <tr><td style="padding-left:60px;height:40px;width:40%">Control Number</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$model->control_number?></td></tr>

        <tr><td style="padding-left:10px;height:40px;width:40%">Beneficiary Account (Field 59 of MT103)</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: /<?=$bank->account_number?></td></tr>
        <tr><td style="padding-left:10px;height:40px;width:40%">Payment Reference (Field 70 of MT103)</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: /ROC/<?=$model->control_number?></td></tr>
        <tr><td style="padding-left:10px;height:40px">Transfer Amount</td><td style="padding-left:10px;text-transform:uppercase">: <?="<b>".$model->bill_currency." ".number_format($model->bill_amount,2)."</b>"?></td></tr>
        <tr><td style="padding-left:10px;width:40%">Amount in Words</td><td style="padding-left:10px">: <?="<b>".$amount_in_words."</b>"?></td></tr>
        <tr><td style="padding-left:10px;height:40px">Being payment for</td><td style="padding-left:10px;text-transform:uppercase">: <?=$model->bill_description?></td></tr>
        </table>
        


</div>
<div style="margin-top:5px;font-size:14px">       

        <table class="table" >
            <tr><td style="padding-left:10px;height:40px;width:40%">Generated on</td><td style="padding-left:10px;text-transform:uppercase">: <?=date('d-m-Y',strtotime($model->bill_gen_date))?></td></tr>
            <!--tr><td style="padding-left:10px;height:50px">Expire</td><td style="padding-left:10px;text-transform:uppercase">: <?=date('d-m-Y',strtotime($model->bill_exp_date))?></td></tr-->
            <tr><td style="padding-left:10px;height:40px">Printed By</td><td style="padding-left:10px;text-transform:capitalize;font-weight:bold">: <?=Yii::$app->user->identity->username?></td></tr>
            <tr><td style="padding-left:10px;height:40px">Signature</td><td style="padding-left:10px;text-transform:uppercase">:______________</td></tr>   
            <tr><td colspan="2" style="font-size:13px;padding-top:20px">
            <b>Note to Commercial Bank:</b>
     <p>
       <ol>
           <li>Please capture the above information correctly. Do not change or add any text, symbols or digits on the information provided.</li>
           <li>Field 59 of MT103 is an <b>"Account Number"</b> with value: <b>/<?=$bank->account_number?></b>. Must be captured correctly.
           <li>Field 70 of MT103 is an <b>"Control Number"</b> with value: <b>/ROC/<?=$model->control_number?></b>. Must be captured correctly.
</ol>    
    </p>
 </td></tr>
        </table>
        


</div>


