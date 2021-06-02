<?php

namespace app\models;
use Yii;
use yii\web\UploadedFile;
date_default_timezone_set('Africa/Kampala');

class Common extends \yii\db\ActiveRecord
{

    public static  function numberTowords($num)
    { 
        
    $ones = array(
        0 => '',
        1 => "ONE", 
        2 => "TWO", 
        3 => "THREE", 
        4 => "FOUR", 
        5 => "FIVE", 
        6 => "SIX", 
        7 => "SEVEN", 
        8 => "EIGHT", 
        9 => "NINE", 
        10 => "TEN", 
        11 => "ELEVEN", 
        12 => "TWELVE", 
        13 => "THIRTEEN", 
        14 => "FOURTEEN", 
        15 => "FIFTEEN", 
        16 => "SIXTEEN", 
        17 => "SEVENTEEN", 
        18 => "EIGHTEEN", 
        19 => "NINETEEN",
        ); 
        $tens = array( 
        1 => "TEN",
        2 => "TWENTY",
        3 => "THIRTY", 
        4 => "FORTY", 
        5 => "FIFTY", 
        6 => "SIXTY", 
        7 => "SEVENTY", 
        8 => "EIGHTY", 
        9 => "NINETY" 
        ); 
    
        $hundreds = array(
        "HUNDRED", 
        "THOUSAND", 
        "MILLION", 
        "BILLION", 
        "TRILLION", 
        "QUARDRILLION" 
        ); /*limit t quadrillion */
        $num = number_format($num,2,".",","); 
        $num_arr = explode(".",$num); 
        $wholenum = $num_arr[0]; 
        $decnum = $num_arr[1]; 
        $whole_arr = array_reverse(explode(",",$wholenum)); 
    
    
        krsort($whole_arr,1); 
    
        // return $whole_arr;
    
        $rettxt = "";
    
    
        foreach($whole_arr as $key => $i){
    
            $i=(int)$i;
    //        echo $i."<br/>";
            
        if($i < 20){ 
        $rettxt .= $ones[(int)$i]; 
        }elseif($i < 100&& $i>=20){
    
    
            if(strlen($i)==1)
                $rettxt .= $ones[substr($i,0,1)];

                if(strlen($i)==2&&substr($i,1,1)=="0"){
                    $rettxt .= " ".$tens[substr($i,0,1)];
                }
    
            if(strlen($i)==2&&substr($i,1,1)!="0"){
                $rettxt .= " ".$tens[substr($i,0,1)];
                $rettxt .= " ".$ones[substr($i,1,1)];
            }    
        }else{ 
            if(substr($i,0,1)!="0")
                $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
                if(substr($i,1,1)!="0") $rettxt .= " ".$tens[substr($i,1,1)];
                if(substr($i,2,1)!="0") $rettxt .= " ".$ones[substr($i,2,1)];
        } 
            if($key > 0){
                if((int)$i>0){
                $rettxt .= " ".$hundreds[$key]." "; 
                }
                }
    
        } 
            if($decnum > 0){
                $rettxt .= " and ";
                if($decnum < 20){
                        $rettxt .= $ones[$decnum];
                }elseif($decnum < 100){
                        $rettxt .= $tens[substr($decnum,0,1)];
                        $rettxt .= " ".$ones[substr($decnum,1,1)];
                }
                }
    
        return  ucfirst(trim($rettxt));
    }
    


    public static function getOutstandingBalance($control_number){

        $billed_amount=TblBilling::find()->where('control_number=:cnumber',[':cnumber'=>$control_number])->one()->bill_amount;
        $paid_amount=Transaction::find()->where('pay_control_num=:cnumber',[':cnumber'=>$control_number])->sum('paid_amount');
        $balance=$billed_amount-$paid_amount;
        return [
                    'billed_amount'=>$billed_amount,
                    'paid_amount'=>$paid_amount,
                    'balance'=>$balance
                ];
    
    }
    
    



//              Bank Bill Codes Panel ---------



public static function GenerateBill($bill_id,$payment_type_id){

    $choice=strlen($bill_id);
    $payment_type=PaymentType::findOne($payment_type_id)->acc_code;
    switch($choice){
        case 1:
               $padding='00000';
                break;
        case 2:
                $padding='0000';
                break;
        case 3:
                $padding='000';
                break;
        case 4:
                $padding='00';
                break;
        case 5:
                $padding='0';
                break;
        case 6:
        default:
                $padding='';
                break;
    }

    $control_number='DM60'.$padding.$bill_id.$payment_type;


    $query=Yii::$app->db->createCommand("update tbl_billing set control_number=:control where id=:bill_id");
    $query->bindValues([':control'=>$control_number,':bill_id'=>$bill_id]);

    $query->execute();

}

//              Ends here       --------


public static function getTodayBankCollection($payment_channel,$color){


    if($payment_channel==2){
        $query="SELECT SUM(paid_amount) AS amount_paid FROM tbl_transaction WHERE psp_name LIKE 'CRDB%' AND ccy='TZS' AND DATE(trx_dt_tm)=:dt AND trx_status=1";
    }else if($payment_channel==3){
        $query="SELECT SUM(paid_amount) AS amount_paid FROM tbl_transaction WHERE (psp_name LIKE 'NMB%' OR psp_name like 'National Microfinance Bank%') AND ccy='TZS' AND DATE(trx_dt_tm)=:dt AND trx_status=1";
    }else if($payment_channel==4){
        $query="SELECT SUM(paid_amount) AS amount_paid FROM tbl_transaction WHERE psp_name LIKE '%EXIM%' AND ccy='TZS' AND DATE(trx_dt_tm)=:dt AND trx_status=1";
    }

    $trans=Yii::$app->db->createCommand($query)->bindValue(':dt',date('Y-m-d'))->queryOne();

    $transaction_amount=(float)$trans['amount_paid'];
    $total=Transaction::find()->where('DATE(trx_dt_tm)=:dt',[':dt'=>date('Y-m-d')])->andWhere('trx_status=:sts',[':sts'=>1])->sum('paid_amount');
    if (!$total) {
        $percentage=0;
        $total=0;
    }else{
        $percentage = number_format((float)($transaction_amount / $total) * 100, 2, '.', ',');
    }
    $total=number_format($total,2);
    $transaction_amount=number_format($transaction_amount,2);
    $html="<div class='progress-group'>
        <span class='progress-text'>".self::getChannelName($payment_channel)." BANK</span>
        <span class='progress-number'><b></b>{$transaction_amount}</span>

        <div class='progress sm'>
            <div class='progress-bar progress-bar-{$color}' style='width: {$percentage}%'></div>
        </div>
    </div>";



    return $html;

}



public static function getTodayCollection($currency){

    $siku=date('Y-m-d');

   $total_collection=Transaction::find()->where('DATE(trx_dt_tm)=:trx_dt',[':trx_dt'=>$siku])->andWhere('trx_status=:sts',[':sts'=>1])->andWhere('ccy=:ccy',[':ccy'=>$currency])->sum('paid_amount');

   return number_format($total_collection,2);
}

public static function getTodayNumberOfBills(){

    $siku=date('Y-m-d');

   $total_bills=TblBilling::find()->where('DATE(bill_gen_date)=:gen_dt',[':gen_dt'=>$siku])->count();

   return $total_bills;
}






    public static function getPaymentNameById($payment_type_id){

        return PaymentType::find()->where('id=:id',[':id'=>$payment_type_id])->one()->acc_description;

    }

   public static function getPaymentOption($id){
        $option_name='';
     switch($id){
        case 1:
            $option_name='Pay in Full Only';
            break;
        case 2:
            $option_name='Partial payment is allowed';
            break;
        case 3:
            $option_name='Exact bill (Same as full but does not allow over or under payment)';
            break;
         default:
             break;
     }

     return $option_name;
    }     

    public static function convertCurrency($bill_amount){

        $amount=floatval(ExchangeRate::find()->where('currency=:c',[':c'=>'USD'])->one()->amount) * floatval($bill_amount);

       return round((float)$amount,2) ;//number_format((float)$amount,2,'.',',');

    }  

    public static function getLast20(){

        $query=Yii::$app->db->createCommand("SELECT trx_id,pay_control_num,paid_amount,trx_dt_tm,psp_name,ctr_acc_num,acc_description,bill_item_ref,tr.payer_name FROM tbl_transaction tr
INNER JOIN (select acc_description,bill_item_ref,control_number from tbl_billing bill
        INNER JOIN tbl_payment_types as ptype ON ptype.id=bill.payment_type_id) AS A ON tr.pay_control_num=A.control_number 
ORDER BY tr.id DESC LIMIT 20")->queryAll();

        return $query;
    }


    public static function graduation(){

        $query=Yii::$app->db->createCommand("SELECT SUM(paid_amount) paid_amount FROM tbl_transaction tr
        INNER JOIN (select acc_description,bill_item_ref,control_number,year_id,ptype.id from tbl_billing bill
                INNER JOIN tbl_payment_types as ptype ON ptype.id=bill.payment_type_id) AS A ON tr.pay_control_num=A.control_number
        WHERE A.year_id=4 and (A.id=27 OR A.id=67)")->queryOne();


        return number_format($query['paid_amount'],2,".",",");
    }    

    public static function applicationFee(){   

        $query=Yii::$app->db->createCommand("SELECT SUM(paid_amount) paid_amount FROM tbl_transaction tr
        INNER JOIN (select acc_code,acc_description,bill_item_ref,control_number,year_id,ptype.id from tbl_billing bill
                INNER JOIN tbl_payment_types as ptype ON ptype.id=bill.payment_type_id) AS A ON tr.pay_control_num=A.control_number
        WHERE (A.acc_code='142202540002' OR A.acc_code='14230113' OR A.acc_code='12099' OR A.acc_code='14230106')")->queryOne();


        return number_format($query['paid_amount'],2,".",",");
    }    

    public static function getOnlineUser(){

        return str_replace('  ',' ',Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name.' '.Yii::$app->user->identity->surname);
    }

     public static function getReconOption($id){
        $option_name='';
     switch($id){
        case 1:
            $option_name='GePG successful transactions';
            break;
        case 2:
            $option_name='Exception report after reconciliation between GePG and bank';
            break;
         default:
             break;
     }

     return $option_name;     
    }
    

    public static function getRegisteredCompanies(){

        return Companies::find()->count();
       
    }


    public static function generatePassword($length = 8) {  //Generate Password
        $characters = '0123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }





    public function getBillIdFromIds($id){

        return TblBilling::find()->where('id=:id',[':id'=>$id])->one()->bill_id;
    }
   public function getIdFromBillId($bill_id){

        return TblBilling::find()->where('bill_id=:id',[':id'=>$bill_id])->one()->id;
    }

    public static function isPosted($id){
        $response='';
         switch($id){
             case 1:
                $response='Drafted';
                break;
             case 2:
                $response='Posted';
                break;
             default:
                 break;
         }

         return $response;
    }

    public static function isCancelled($id){
        $response='';
         switch($id){
             case 1:
                $response='Not Cancelled';
                break;
             case 2:
                $response='Cancelled';
                break;
             default:
                 break;
         }

         return $response;
    }


    public static function getStandardTime($muda){

        return str_replace('+00:00', '', gmdate('c',strtotime($muda)));
    }

    public static function getTime(){

        return str_replace('+00:00', '', gmdate('c',strtotime(date('Y-m-d H:i:s'))));
    }

    public static function getBillItemRef(){

        $model=GepgCredentials::find()->one();
        $switcher=strlen($model->reference_id);
        $padding='';

        switch($switcher){

            case 1:
                $padding='00000000';
                break;
            case 2:
                $padding='0000000';
                break;
            case 3:
                $padding='000000';
                break;
            case 4:
                $padding='00000';
                break;
            case 5:
                $padding='0000';
                break;
            case 6:
                $padding='000';
                break;
            case 7:
                $padding='00';
                break;
            case 8:
                $padding='0';
                break;
            default:   
                break;

        }    

       return 'TUDOM'.$padding.$model->reference_id;     

    }
    public static function updateBillItemRef(){

        $ref_id=GepgCredentials::find()->one()->reference_id;
        $new_id=$ref_id+1;
        $query=Yii::$app->db->createCommand("update gepg_credentials set reference_id=:new_id");
        $query->bindValue(':new_id',$new_id);
        $query->execute();

    }

   public static function updateBillIsCancelled($bill_id){
        $query=Yii::$app->db->createCommand("update tbl_billing set is_cancelled=:cancelled where bill_id=:bill");
        $query->bindValue(':cancelled','2');
        $query->bindValue(':bill',$bill_id);
        $query->execute();

    }

  public static function updateCancellation($bill_id,$resp,$message){
        $query=Yii::$app->db->createCommand("update tbl_cancellation set gepg_response=:resp,response_message=:msg where bill_id=:bill");
        $query->bindValue(':resp',$resp);
        $query->bindValue(':msg',$message);
        $query->bindValue(':bill',$bill_id);
        $query->execute();

    }



    public static function getUsers(){
        return User::find()->count();
    }

    public static function getNames($user_id){

        $model=\app\models\User::find()->where('id=:id',[':id'=>$user_id])->one();

        return $model->first_name.' '.$model->last_name;
    }

    public static function getRegisteredBanks(){
        return Bank::find()->count();
    }

    public static function getGraduationRevenue(){

        $query=Yii::$app->db->createCommand("SELECT sum(tr.paid_amount) as amount 
        FROM tbl_billing b
        INNER JOIN tbl_transaction tr ON tr.pay_control_num = b.control_number
        where b.payment_type_id=27
        ")->queryOne();


        return number_format($query['amount'],2,".",",");
    }



    /**
     * checkSpSystem string control_number
     */
    public static function checkSpSystem($control_number){

        $query=Yii::$app->db->createCommand("select * from tbl_billing b INNER JOIN sp_system sp ON sp.id=b.sp_system_id  WHERE b.control_number=:control_num");
        $query->bindValue(':control_num',$control_number);

        return $query->queryAll();
   }



    // public static function getTotalRevenue($currency){

    //     $query=Yii::$app->db->createCommand("SELECT sum(tr.paid_amount) as amount 
    //     FROM tbl_billing b
    //     INNER JOIN tbl_transaction tr ON tr.pay_control_num = b.control_number
    //     where b.bill_currency='{$currency}'")->queryOne();


    //     return number_format($query['amount'],2,".",",");
    // }


    public static function getTotalRevenue($currency){


        return number_format(Transaction::find()->andWhere('ccy=:currency',[':currency'=>$currency])->sum('paid_amount'),2,".",",");
    }
    
    public static function getTodayTransaction(){
           
        $siku=date('Y-m-d');
        
        $a=Yii::$app->db->createCommand("select * from tbl_transaction where trx_dt_tm like '%{$siku}%'")->queryAll();
        
       // Transaction::find()->where(['like','trx_dt_tm',$siku])->count();

       return count($a);
    }

    public static function getDailyReport(){  

            //        return Yii::$app->db->createCommand("SELECT payment_name,payment_channel,account_number,DATE(transaction_date) as 'date',sum(amount_paid) as 'total' FROM tbl_transaction t,tbl_billing b,tbl_fee_structure f,intermediate_payment_details ip where t.billing_id=b.id and b.fee_structure_id=f.id and ip.payment_type_id=f.payment_type_id AND ip.bank_id=t.payment_channel group by payment_channel,account_number,DATE(transaction_date) order by transaction_date desc limit 16
            //          ")->queryAll();

          //  return Yii::$app->db->createCommand("SELECT payment_type_id,payment_channel,DATE(transaction_date) as 'date',sum(amount_paid) as 'total' FROM tbl_transaction t,tbl_billing b,tbl_fee_structure f where t.billing_id=b.id and b.fee_structure_id=f.id group by payment_channel,payment_type_id,DATE(transaction_date) order by transaction_date desc limit 16")->queryAll();

    }



    public static function getBankDetails($channel_id,$payment_type_id){

        $bank_id=self::getChannelId($channel_id);
        return Yii::$app->db->createCommand("SELECT payment_name,account_number 
                                              FROM intermediate_payment_details ip
                                               WHERE ip.payment_type_id='$payment_type_id' 
                                               AND ip.bank_id='$bank_id' ")->queryOne();


    }

    public static function getEachBank($payment_channel,$color){
        $query="";
     if($payment_channel==2){
         $query="select sum(paid_amount) as amount_paid from tbl_transaction where psp_name like 'CRDB%'";
     }else if($payment_channel==3){
        $query="select sum(paid_amount) as amount_paid from tbl_transaction where psp_name like 'NMB%' OR psp_name like 'National Microfinance Bank%'";
    }else if($payment_channel==4){
        $query="select sum(paid_amount) as amount_paid from tbl_transaction where psp_name like '%EXIM%'";
    }

      $trans=Yii::$app->db->createCommand($query)->queryOne();


       $transaction_amount=number_format((float)$trans['amount_paid'], 2, '.', '');
       $total=Transaction::find()->sum('paid_amount');
       $percentage=number_format((float)($transaction_amount/$total)*100, 2, '.', ',');

       $html="<div class='info-box bg-{$color}'>
               <span class='info-box-icon'>
               <i class='ion fa fa-bank'></i></span>
               <div class='info-box-content'>
               <span class='info-box-text'><b>".self::getChannelName($payment_channel)." BANK</b></span>
               <span class='info-box-number'>".number_format((float)$transaction_amount,2,'.',',')."</span>

               <div class='progress'>
               <div class='progress-bar' style='width:{$percentage} %'></div>
               </div>
               <span class='progress-description'>{$percentage}% of total collection</span>
               </div></div>";

       return $html;

    }

    public static function getEachTotalCollection(){
        $data=null;

        foreach(Yii::$app->db->createCommand("SELECT sum(amount_paid) as 'collection' FROM `tbl_transaction` group by payment_channel order by payment_channel")->queryAll() as $key=>$value){
            $data[]=$value['collection'];
        }
        return $data;
    }


    public static function getDashChannel(){
        $data=null;
        foreach(Yii::$app->db->createCommand("select DISTINCT IF(t.payment_channel=2,'CRDB',IF(t.payment_channel=3,'NMB',IF(t.payment_channel=4,'EXIM',t.payment_channel))) as channel 
                  from tbl_transaction t order by payment_channel")->queryAll() as $key=>$value){
            $data[]=$value['channel'];
        }
        return $data;
    }







    public static function getChannels(){


        return array(['id'=>'1','name'=>'tigo Pesa'],['id'=>'2','name'=>'CRDB Bank'],['id'=>'3','name'=>'NMB Bank'],['id'=>'4','name'=>'EXIM Bank'],['id'=>'5','name'=>'Mpesa Bank']);
    }


    public static function getChannelName($channel_id){
        $channel='1';
        switch($channel_id){

            case 1:
                $channel='tigo Pesa';
                break;
            case 2:
                $channel='CRDB';
                break;
            case 3:
                $channel='NMB';
                break;
            case 4:
                $channel='EXIM';
                break;
            case 5:
                $channel='Mpesa';
                break;
            default:
                $channel='';
                break;

        }

        return $channel;

    }

    public static function resolveSex($sex){
        $p=$sex;
        if($p==='M'){
            $p='Male';
        }else if($p==='F'){
            $p='Female';
        }

        return $p;

    }


    public static function graph(){

        
        $months=array();
        $dataset=array();

        foreach(Yii::$app->db->createCommand("SELECT date(trx_dt_tm) as m  FROM tbl_transaction where trx_dt_tm >= (CURDATE() - INTERVAL 10 day) group by date(trx_dt_tm) order by date(trx_dt_tm)")->queryAll() as $key=>$value){

               $m=$value['m'];
               $datasets=Yii::$app->db->createCommand("SELECT SUM(paid_amount) as col
                FROM tbl_transaction 
                WHERE ccy='TZS' AND  date(trx_dt_tm) like '%{$m}%'")->queryOne();
            
            array_push($dataset,$datasets['col']);
            array_push($months,$m); 

        }

        return array("values"=>$dataset,'labels'=>$months);     

    }


    public static function prepareReport($payment_channel,$start_date,$end_date){

//        if(!empty($payment_channel)){
//            $bank_id=self::getChannelId($payment_channel);
//            $query= "SELECT  reg_no,payment_channel,first_name,middle_name,surname,sex,payment_name,
//                             invoice,amount_paid,transaction_ref,transaction_date,receipt_no,college_name,
//                             programme_name,yos,status ,account_number
//                    FROM tbl_transaction tra
//				LEFT JOIN intermediate_tr tr
//                ON tra.billing_id=tr.billing_id
//                where tr.bank_id=tra.payment_channel
//                AND tra.transaction_date
//                BETWEEN '{$start_date}' AND '{$end_date}' AND tr.bank_id='{$bank_id}'";
//        }else{
//            $query= "SELECT reg_no,payment_channel,first_name,middle_name,surname,sex,payment_name,
//                             invoice,amount_paid,transaction_ref,transaction_date,receipt_no,college_name,
//                             programme_name,yos,status ,account_number
//                      FROM tbl_transaction tra
//				LEFT JOIN intermediate_tr tr
//                ON tra.billing_id=tr.billing_id
//                where tr.bank_id=tra.payment_channel AND tra.transaction_date BETWEEN '{$start_date}' AND '{$end_date}'";
//        }
//
//         $result=Yii::$app->db->createCommand($query)->queryAll();

//        return $result;
    }




    public static function getStudentDetails($billing_id){
        return Yii::$app->db->createCommand("
SELECT b.reg_no as reg_no,first_name,middle_name,surname,sex,college_name,programme_name,yos,invoice 
from intermediate_student_details i,tbl_billing b 
where b.reg_no=i.reg_no AND b.id={$billing_id} ")->queryOne();

    }

    public static function generateDataForExcel($data){
        $i=1;
        $collected_data=array();
        foreach($data as $value){
            $query=Yii::$app->db->createCommand("SELECT reg_no,first_name,middle_name,surname,sex,college_name,programme_name,yos,invoice,payment_name,account_number 
FROM intermediate_tr WHERE bank_id='{$value['payment_channel']}' AND billing_id='{$value['billing_id']}'")->queryOne();
            $collected_data[]=[
                'amount_paid'=> $value['amount_paid'],
                'receipt_no'=>$value['receipt_no'],
                'transaction_ref'=>$value['transaction_ref'],
                'transaction_date'=>$value['transaction_date'],
                'status'=>$value['status'],
                'payment_channel'=>self::getChannelName($value['payment_channel']),
                'reg_no'=>$query['reg_no'],
                'account_number'=>$query['account_number'],
                'first_name'=>$query['first_name'],
                'middle_name'=>$query['middle_name'],
                'surname'=>$query['surname'],
                'sex'=>$query['sex'],
                'college_name'=>$query['college_name'],
                'programme_name'=>$query['programme_name'],
                'yos'=>$query['yos'],
                'invoice'=>$query['invoice'],
                'payment_name'=>$query['payment_name']];
        $i++;
          //  break;
        }
        //      ->setCellValue('B'.$i, $pay_details['reg_no'])
//                        ->setCellValue('C'.$i, $pay_details['first_name'])
//                        ->setCellValue('D'.$i, $pay_details['middle_name'])
//                        ->setCellValue('E'.$i, $pay_details['surname'])
//                        ->setCellValue('F'.$i, \app\models\Common::resolveSex($pay_details['sex']))
//                        ->setCellValue('G'.$i, $pay_details['college_name'])
//                        ->setCellValue('H'.$i, $pay_details['programme_name'])
//                        ->setCellValue('I'.$i, $pay_details['yos'])
//                        ->setCellValue('J'.$i, $pay_details['invoice'])
//                        ->setCellValue('K'.$i, $pay_details['payment_name'])
//                        ->setCellValue('L'.$i, \app\models\Common::getChannelName($value['payment_channel']))
//                        ->setCellValue('M'.$i, $pay_details['account_number'])
//                        ->setCellValue('N'.$i, $value['amount_paid'])
//                        ->setCellValue('O'.$i, $value['receipt_no'])
//                        ->setCellValue('P'.$i, $value['transaction_ref'])
//                        ->setCellValue('Q'.$i, $value['transaction_date'])
//                        ->setCellValue('R'.$i, \app\models\Common::getTransactionStatus($value['status']));


        return $collected_data;

    }



    public static function getData($model){



    }



    public static function getPaymentDetails($billing_id,$channel_id){
        $bank_id=self::getChannelId($channel_id);

//     return Yii::$app->db->createCommand("
//SELECT i.payment_type_id,payment_name,account_number
//from intermediate_payment_details i,tbl_billing b,tbl_fee_structure f
//where b.fee_structure_id=f.id
//AND i.payment_type_id=f.payment_type_id
//AND i.bank_id={$bank_id}
//AND b.id={$billing_id} ")->queryOne();

//        return Yii::$app->db->createCommand("
//SELECT b.reg_no as reg_no,first_name,middle_name,surname,sex,college_name,programme_name,yos,invoice,x.payment_name,x.account_number
//FROM intermediate_student_details i,tbl_billing b
//LEFT JOIN (
//SELECT b.id,i.payment_type_id,payment_name,account_number
//FROM intermediate_payment_details i,tbl_billing b,tbl_fee_structure f
//WHERE b.fee_structure_id=f.id
//AND i.payment_type_id=f.payment_type_id
//AND i.bank_id='{$bank_id}'
//AND b.id='{$billing_id}') AS x ON x.id=b.id where b.reg_no=i.reg_no AND b.id='{$billing_id}'")->queryOne();


        return Yii::$app->db->createCommand("
SELECT reg_no,first_name,middle_name,surname,sex,college_name,programme_name,yos,invoice,payment_name,account_number 
FROM intermediate_transaction WHERE bank_id='{$bank_id}' AND billing_id='{$billing_id}'")->queryOne();

    }


   public static function fetchStudentDetails($reg_no){

        $payload=json_encode(['registration_no'=>$reg_no]);
        $url='https://sr2.udom.ac.tz/api/web/v1/mobile/student-details';
        $access_token=SpSystem::findOne(['id'=>1])->sys_access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer {$access_token}",
                "Content-Length: " . strlen($payload))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;



    }













    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }







}
