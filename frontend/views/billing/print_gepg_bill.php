<?php

use yii\widgets\DetailView;
use app\models\Common;
use yii\helpers\Html;
use Da\QrCode\QrCode;
use yii\helpers\Url;





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


//print_r(Url::to('@web/logo/logo.png'));
$qrCode = (new QrCode(json_encode($payload)))
    ->setSize(150)
    ->setMargin(10)
    ->useLogo("logo/qr.png")
    ->setLogoWidth(50)
    ->useForegroundColor(0, 0,0);

$currency=($model->bill_currency=='TZS')?' Tanzania Shillings.':' USD Dollar.';
?>
<div class="text-center text-bold"><img src="<?=Yii::getAlias("@web")?>/logo/qr.png" height="100px" width="100px"/></div>
<div class="text-center" style="font-size:18px;margin-top:6px"><span><b>THE UNIVERSITY OF DODOMA</b></div>
<div class="text-center" style="font-size:16px;margin-top:5px"><span>The University of Dodoma Bill</div>

<div style="border-top:dotted 2px #ccc;margin-top:10px;font-size:10px">

        <table class="table" >
            <tr><td style="padding:10px;width:25%">Control Number</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$model->control_number?></td><td rowspan="6"><?='<img src="' . $qrCode->writeDataUri() . '">'?>
                <center style="font-size:7px;font-weight:bold">SCAN & PAY by M PESA or TIGO PESA APPs </center></td></tr>
            <tr><td style="padding:10px">Payment Ref</td><td style="padding-left:10px;text-transform:uppercase;font-weight:bold">: <?=$model->bill_item_ref?></td></tr>
            <tr><td style="padding:10px">Service Provider Code</td><td style="padding-left:10px;text-transform:uppercase">: <b>SP446</b></td></tr>
            <tr><td style="padding:10px">Payer Name</td><td style="padding-left:10px;text-transform:uppercase">: <?=$model->payer_name?></td></tr>
            <tr><td style="padding:10px">Payer Phone</td><td style="padding-left:10px;text-transform:uppercase">: <?=$model->payer_cell_num?></td></tr>
            <tr><td style="padding:10px">Bill Description</td><td style="padding-left:10px;text-transform:uppercase">: <?=$model->bill_description?></td></tr>
            <tr><td colspan="3" style="border-bottom: 1px solid #cccccc;"></td></tr>
            <tr><td style="padding:10px;width:25%;">Billed Item(1)</td><td style="padding-left:10px;width:55%"> : <?=\app\models\PaymentType::findOne($model->payment_type_id)->gfs_description?></td><td> :<?=number_format($model->bill_amount,2,'.','')?></td></tr>
            <tr><td colspan="3" style="border-bottom: 1px solid #cccccc"></td></tr>
            <tr><td style="padding:10px;width:25%"></td><td style="padding:10px;width:55%;font-weight:bold">  Total Billed Amount</td><td> :<b><?=number_format($model->bill_amount,2,'.','')." ({$model->bill_currency})"?></b></td></tr>

            <tr><td style="padding:10px;">Amount in Words</td><td  style="padding-left:10px;font-weight:bold;text-transform:capitalize" colspan="2">: <?=Common::numberTowords($model->bill_amount).$currency?></td></tr>
            <tr><td style="padding:10px;">Expires On</td><td style="padding-left:10px;">: <?=date('d-F-Y',strtotime($model->bill_exp_date))?></td></tr>
            <tr><td style="padding:10px;">Prepared By</td><td style="padding-left:10px;">: <b><?=$model->bill_gen_by?></b></td></tr>
            <tr><td style="padding:10px;">Collection Center</td><td style="padding-left:10px;">: HEAD QUARTER</td></tr>
            <tr><td style="padding:10px;">Printed By</td><td style="padding-left:10px;text-transform:capitalize;">: <?=Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name?></td></tr>
            <tr><td style="padding:10px;">Printed On</td><td style="padding-left:10px;">: <?=date('d-F-Y',time())?></td></tr>
            <tr><td style="padding:10px;">Signature</td><td style="padding-left:10px;">:_________________</td></tr>
            </table>
            <table class="table" style="margin-top:30px">
            <tr>
                <td  style="margin-top:80px;font-size:14px">
                <p style="font-weight:bold">Jinsi ya Kulipia</p>
                    <ol>
                        <li>Kupitia Benki: Fika tawi lolote au wakala wa benki ya CRDB,NMB,EXIM, BOT. Namba ya kumbukumbu:<b><?=$model->control_number?></b>.</li>
                        <li>Kupitia Mitandao ya Simu:

                            <ul type="circle">
                                <li>Ingia kwenye menyu ya mtandao husika</li>
                                <li>Chagua 4 (Lipia Bili)</li>
                                <li>Chagua 5 (Malipo ya Serikali</li>
                                <li>Ingiza <b><?=$model->control_number?></b> kama namba ya kumbukumbu</li>
                            </ul>


                        </li>
                    </ol>

                </td>
                <td  style="margin-top:80px;font-size:14px">
                    <p style="text-align:left;font-weight:bold">How to Pay</p>
                    <ol>
                        <li>Via Bank: Visit any branch or bank agent of CRDB, NMB,EXIM, BOT. Reference Number:<b><?=$model->control_number?></b>.</li>
                        <li>Via Mobile Network Operators (MNO): Enter to the respective USSD Menu of MNO
                        <ul>
                            <li>Select 4 (Make Payments)</li>
                            <li>Select 5 (Government Payments)</li>
                            <li>Enter <b><?=$model->control_number?></b> as reference number</li>
                        </ul>
                        </li>
                    </ol>


                </td>




            </tr>
        </table>
        


</div>


