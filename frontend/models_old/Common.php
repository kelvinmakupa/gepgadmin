<?php

namespace app\models;
use Yii;
use yii\web\UploadedFile;

class Common extends \yii\db\ActiveRecord
{




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

    public static function getOnlineUser(){


        return Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name;
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

    public static function getTotalRevenue(){
        return number_format(Transaction::find()->sum('paid_amount'),2,".",",");
    }
    public static function getTodayTransaction(){

        return Transaction::find()->where(['like','trx_dt_tm',date('Y-m-d')])->count();
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

//        $transaction_amount=number_format((float)Transaction::find()->where(['payment_channel'=>$payment_channel])->sum('amount_paid'), 2, '.', '');
//        $total=Transaction::find()->sum('amount_paid');
//        $percentage=number_format((float)($transaction_amount/$total)*100, 2, '.', ',');
//
//        $html="<div class='info-box bg-{$color}'>
//                <span class='info-box-icon'>
//                <i class='ion fa fa-bank'></i></span>
//                <div class='info-box-content'>
//                <span class='info-box-text'><b>".self::getChannelName($payment_channel)." BANK</b></span>
//                <span class='info-box-number'>".number_format((float)$transaction_amount,2,'.',',')."</span>
//
//                <div class='progress'>
//                <div class='progress-bar' style='width:{$percentage} %'></div>
//                </div>
//                <span class='progress-description'>{$percentage}% of total collection</span>
//                </div></div>";
//
//        return $html;

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




























}
