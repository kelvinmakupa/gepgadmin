
<?php
/**
 * Created by PhpStorm.
 * User: Edward James
 * Date: 7/27/17
 * Time: 1:59 AM
 */      
/*
if (defined('STDIN')) {
    $q = $argv[1];
} else {   
    $sql_ = "";
}     

if($q == 1){
    $sql_ = "LIMIT 3000 , 3000 ";
}elseif($q == 2){
    $sql_ = " LIMIT 6000, 3000";
}elseif ($q == 3){
    $sql_ = " LIMIT 9000, 3000";
}elseif($q == 4){
    $sql_ = " LIMIT 12000, 3000";
}elseif($q == 5){
    $sql_ = " LIMIT 15000, 3000";
}     
*/     
  
$obj=new OAS();     
          
$applications = mysqli_query($obj->con, "SELECT UPPER(first_name) first_name,UPPER(middle_name) AS middle_name, programme_code,'' AS phone,'' AS email, IF( reg_no LIKE 'T/UDOM%', 'Tanzanian', '' ) AS citizenship, UPPER(surname) AS last_name, reg_no AS reg_number, '1' AS yos
FROM sila_continue
WHERE study_level =3 and reg_no='T/UDOM/2017/04450'");
   
/*
$applications = mysqli_query($obj->con, "SELECT *             
FROM `student_details`            
WHERE `study_level` LIKE '3'                
AND `academic_year` LIKE '2019/20' ORDER BY id ASC");         
*/        

$year_id=4;               
                                     
$token=OAS::getToken();                                   
            
$i=0;
while ($row = mysqli_fetch_assoc($applications)) {        
$i++;
    try{      
        $fee_array=OAS::getFeeStructure($row['programme_code'],$row['yos']);  

        while($fee=mysqli_fetch_assoc($fee_array)){     
            $gepg_flag=false;              

            if($fee['payment_type_id']==37){      

                $gepg_flag=true;
                if(($row['citizenship']=='Tanzanian')){
                    $currency='TZS';
                    $bill_amount=$fee['local_amount'];
                    $bill_eqv_amount=$bill_amount;
                }else{
                    $currency='USD';
                    $bill_amount=$fee['foreign_amount'];
                    $bill_eqv_amount=$bill_amount*2280.4;
                }
                $bill_pay_opt='2';    
                $control_number='';
            }
                    $currency='TZS';
                    $bill_amount=228500;
                    $bill_eqv_amount=$bill_amount;    

            $payer='3';
            $payer_name=str_replace("'","\'",$row['first_name'].' '.$row['middle_name'].' '.$row['last_name']);
            $bill_expire=str_replace('+00:00', '', gmdate('c',strtotime(date('Y-m-d H:i:s', strtotime('+12 months')))));
            $bill_description=$fee['description'];
            $bill_gen_by='System Admin';
            $bill_appr_by='Prof. Donald Gregory Mpanduji';
            $phone=str_replace('+','',$row['phone']);
            $email=str_replace("'","\'",$row['email']);
            $payment_type_id=$fee['payment_type_id']; 
            $company_id='0';
            $bill_gen_date=OAS::getTime();        
            $bill_item_ref=$row['reg_number'];
            $is_posted='1';
            $is_cancelled='1';      
  
            if(!OAS::checkData($bill_item_ref,$payment_type_id)){

            $sql="insert into tbl_billing(payer, payer_name, bill_amount, bill_exp_date, bill_description, bill_gen_by, bill_appr_by, payer_cell_num, payer_email, bill_currency, 
                  payment_type_id, company_id, bill_gen_date, bill_pay_opt, use_on_pay, bill_eqv_amount, bill_item_ref, is_posted, is_cancelled,year_id,control_number)
                  VALUE('{$payer}','{$payer_name}','{$bill_amount}','{$bill_expire}','{$bill_description}','{$bill_gen_by}','{$bill_appr_by}','{$phone}','{$email}','{$currency}',
             '{$payment_type_id}','{$company_id}','{$bill_gen_date}','{$bill_pay_opt}','N','{$bill_eqv_amount}','{$bill_item_ref}','{$is_posted}','{$is_cancelled}','{$year_id}','{$control_number}');";
             
            // print_r($sql);           
            // exit;   

            if(mysqli_query($obj->con,$sql)){

                if($gepg_flag) {
                    $last_id = mysqli_insert_id($obj->con);

                    $datax = mysqli_query($obj->con, "select b.id, payer, payer_name, bill_amount, bill_exp_date, bill_description, bill_gen_by, bill_appr_by, payer_cell_num, payer_email, 
                                                             bill_currency, payment_type_id, company_id, bill_gen_date, bill_id, control_number,bill_pay_opt, use_on_pay, bill_eqv_amount,
                                                              bill_item_ref,ptype.acc_code from tbl_billing b
                                               inner join tbl_payment_types ptype on b.payment_type_id=ptype.id
                                               where b.id='{$last_id}'");

                    $rowx = mysqli_fetch_assoc($datax);  

                    print_r(OAS::fetchData($rowx, $token));

                }
//                print_r('Reg Number:'.$row['reg_number'].' Bill Currency: '.$currency.' Amount '.$bill_amount.PHP_EOL);
                print_r($i.': Data was saved successfully '.PHP_EOL);

            }else{
                print_r('Data was not saved successfully'.PHP_EOL);
            }

            }else{
                print($i.': Data already exists'.PHP_EOL);
            }
   
        } 
    }catch(Exception $e){
        print_r($e);

    }

}

print PHP_EOL."Process was completed successfully".PHP_EOL;
class OAS
{
    public $con;
    const USERNAME='DM';
    const SessionToken='NXck5OVhpTGLq9MUYzaZ';        

    public function __construct(){    
        $user_name = "dev";
        $password = 'tmux@u90m';
        $database = "gepg_admin";
        $server = "localhost";

        $this->con = mysqli_connect($server, $user_name, $password);
        mysqli_select_db($this->con, $database);
    }

    public static function getFeeStructure($program_code,$yos){  


        if($yos>1){
            $yos=2;
        }

        /**
         *  For Non Degree students ids:2,33 : For Degree Programmes ids:1,37      
         */

        $obj=new OAS();
        $query=mysqli_query($obj->con,"SELECT payment_type_id, fee.local_amount, fee.foreign_amount, p.code, ptype.acc_description AS description,ptype.acc_code
                                    FROM tbl_fee_structure fee
                                    INNER JOIN programmes p ON p.program_id = fee.programme_id
                                    INNER JOIN tbl_payment_types ptype ON ptype.id = fee.payment_type_id
                                    WHERE p.code =  '{$program_code}'
                                    AND year_of_study =  '{$yos}'
                                    AND ptype.id=37 AND academic_year_id =3");
        //(ptype.id=1 OR ptype.id=37)
                                         
       return $query;    
    }                                         


    public static function checkData($reg_num,$payment_type_id){

            $obj=new OAS();
            $resp=mysqli_query($obj->con,"SELECT * FROM tbl_billing where bill_item_ref='{$reg_num}' and payment_type_id='{$payment_type_id}' AND year_id='4' AND is_cancelled=1");
            $flag=false;
            if(mysqli_num_rows($resp)>0){
                $flag=true;
            }
           
            return $flag;


    }


    public static function getStandardTime($muda){

        return str_replace('+00:00', '', gmdate('c',strtotime($muda)));
    }

    public static function getTime(){

        return str_replace('+00:00', '', gmdate('c',strtotime(date('Y-m-d H:i:s'))));
    }
    public static function fetchData($row,$token){

        $link='http://gepg.udom.ac.tz/public/api/udomBillSubReq';

        $data = array(
            'token' => $token,
            'callBackUrl' => 'https://gepgadmin.udom.ac.tz/transaction/gepgtransaction.aspx',
            'data' => [
                'billAmt' => $row['bill_amount'],
                'miscAmt' => 0,
                'billExpDate' => $row['bill_exp_date'],
                'payerId' => $row['id'],
                'payerName' => $row['payer_name'],
                'billDesc' => $row['bill_description'],
                'billGenDate' => $row['bill_gen_date'],
                'billGenBy' => $row['bill_gen_by'],
                'billApprBy' => $row['bill_appr_by'],
                'payerCellNum' => '',//str_replace('+','',str_replace('-','',$response['phone_number'])),
                'payerEmail' => '',//strtolower($response['email']),
                'Ccy' => $row['bill_currency'],
                'billEqvAmt' =>$row['bill_eqv_amount'],
                'remFlag' => true,
                'billPayOpt' => $row['bill_pay_opt'],
                'billItermRef' => $row['bill_item_ref'],
                'useItemRefOnPay' => 'N',
                'billItemAmt' => $row['bill_amount'],
                'billItemEqvAmt' => $row['bill_eqv_amount'],
                'billItemMiscAmt' => 0,
                'accCode' => $row['acc_code']

            ]
        );

        $payload=json_encode($data);
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }


    public static function getToken(){
        $link='http://gepg.udom.ac.tz/public/api/auth';

        $credentials=array('user'=>'oas','key'=>'12345');
        $payload=json_encode($credentials);

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        $obj=json_decode($result);

        $auth_token=$obj->token;

        return $auth_token;
    }



}
