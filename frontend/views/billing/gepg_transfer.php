<?php

use yii\widgets\DetailView;
use app\models\Common;
use yii\helpers\Html;
use Da\QrCode\QrCode;


$payload=[
    "opType"=>2,
    "shortCode"=>"001001",
    "billReference"=>$model->control_number,
    "amount"=>number_format($model->bill_amount,1,'.',''),
    "billCcy"=>$model->bill_currency,
    "billExprDt"=>date('Y-m-d',strtotime($model->bill_exp_date)),
    "billPayOpt"=>"{$model->bill_pay_opt}",
    "billRsv01"=>"The University of Dodoma|{$model->payer_name}"
];


$qrCode = (new QrCode(json_encode($payload)))
    ->setSize(150)
    ->setMargin(10)
    ->useLogo("logo/qr.png")
    ->setLogoWidth(50)
    ->useForegroundColor(0, 0,0);

?>
<div class="text-center text-bold"><img src="<?=Yii::getAlias("@web")?>/logo/qr.png" height="100px" width="100px"/></div>
<div class="text-center" style="font-size:18px;margin-top:5px"><span><b>THE UNIVERSITY OF DODOMA</b></div>
<div class="text-center" style="font-size:16px;margin-top:5px"><span>Order Form for Electronic Funds Transfer to <?=$bank->bank_name?></div>

<div style="border-top:dotted 2px #ccc;margin-top:5px;font-size:14px">

        <table class="table" >   
        <tr><td style="padding:10px 0 10px 5px;width:40%;font-weight:bold">(a). Remitter / Tax Payer Details</td><td style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">:-</td></tr>
       
        <tr><td style="padding:10px 0 10px 5px;width:40%">Name of Account Holder(s)</td><td colspan="2" style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">:........................................................................................................................................</td></tr>
        <tr><td style="padding:10px 0 10px 5px;width:40%">Name of Commercial Bank</td><td  colspan="2"  style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">:........................................................................................................................................</td></tr>
        <tr><td style="padding:10px 0 10px 5px;width:40%">Bank Account Number</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">:........................................................................................................................................</td></tr>
        <tr><td style="padding:10px 0 10px 5px;width:40%">Signatories</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">:................................................................... | ..................................................................</td></tr>
        <tr><td style="padding:10px 0 10px 5px;width:40%"></td><td colspan="2"  style="padding:10px 0 10px 5px;font-size:11px"> signature of the Transfer one        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      signature of the Transfer two</td></tr>

       
        <tr><td style="padding:10px 0 10px 5px;width:40%;font-weight:bold">(b). Beneficiary Details :-</td><td style="padding:10px 0 10px 5px;text-transform:capitalize;font-weight:bold">: <?=$bank->beneficiary_name?></td><td rowspan="5"><?='<img src="' . $qrCode->writeDataUri() . '">'?> <center style="font-size:7px;font-weight:bold">SCAN & PAY by M PESA or TIGO PESA APPs </center></td></tr>
        <tr><td style="padding:10px 0 10px 5px;width:40%"></td><td style="padding:10px 0 10px 5px;text-transform:capitalize;font-weight:bold">: <?=$bank->bank_name?></td></tr>
        <tr><td style="padding-left:60px;width:40%">Account Number</td><td style="padding:10px 0 10px 5px;font-weight:bold">: <?=$bank->account_number?></td></tr>
        <tr><td style="padding-left:60px;width:40%">SWIFT Code</td><td style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">: <?=$bank->swift_code?></td></tr>
        <tr><td style="padding-left:60px;width:40%">Control Number</td><td style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">: <?=$model->control_number?></td></tr>
        <tr><td style="padding:10px 0 10px 5px;width:40%">Beneficiary Account (Field 59 of MT103)</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">: /<?=$bank->account_number?></td></tr>
        <tr><td style="padding:10px 0 10px 5px;width:40%">Payment Reference (Field 70 of MT103)</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:uppercase;font-weight:bold">: /ROC/<?=$model->control_number?></td></tr>
        <tr><td style="padding:10px 0 10px 5px;">Transfer Amount</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:uppercase">: <?="<b>".number_format($model->bill_amount,2)."({$model->bill_currency})</b>"?></td></tr>
        <tr><td style="padding:10px 0 10px 5px;width:40%">Amount in Words</td><td colspan="2"  style="padding:10px 0 10px 5px">: <?="<b>".$amount_in_words."</b>"?></td></tr>
        <tr><td style="padding:10px 0 10px 5px;">Being payment for</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:capitalize">: <?=$model->bill_description?></td></tr>
            <tr><td colspan="3" style="border-bottom: 1px solid #cccccc;"></td></tr>
            <tr><td style="padding:10px;">Billed Item(1)</td><td style="padding-left:10px;width:55%"> : <?=\app\models\PaymentType::findOne($model->payment_type_id)->gfs_description?></td><td> :<?=number_format($model->bill_amount,2,'.','')?></td></tr>
            <tr><td colspan="3" style="border-bottom: 1px solid #cccccc"></td></tr>
            <tr><td style="padding:10px 0 10px 5px;width:40%">Expires on</td><td colspan="2"  style="padding:10px 0 10px 5px;">: <?=date('d-F-Y',strtotime($model->bill_exp_date))?></td></tr>
            <tr><td style="padding:10px 0 10px 5px;width:40%">Prepared By</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:capitalize;font-weight:bold">: <?=$model->bill_gen_by?></td></tr>
            <tr><td style="padding:0px 0 7px 5px">Collection Center</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:uppercase;">: HEAD QUARTER</td></tr>
            <tr><td style="padding:0px 0 7px 5px">Printed By</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:capitalize">: <?=Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name?></td></tr>
            <tr><td style="padding:0px 0 7px 5px">Printed On</td><td colspan="2"  style="padding:10px 0 10px 5px;">: <?=date('d-F-Y',time())?></td></tr>
            <tr><td style="padding:0px 0 7px 5px">Signature</td><td colspan="2"  style="padding:10px 0 10px 5px;text-transform:uppercase">:______________</td></tr>
            <tr><td colspan="3" style="font-size:12px;padding-top:10px">
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


