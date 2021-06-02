<?php

/**
 * Created by PhpStorm.
 * User: edward
 * Date: 7/27/17
 * Time: 1:59 AM
 */
   
$obj=new OAS();
$token=OAS::getToken();                               

#$applications = mysqli_query($obj->con, "select * from madeni_2020 where id>1");            
    
$applications = mysqli_query($obj->con, "select * from continue_students where id>1");        
    

$year_id=5;            
                               
$token=OAS::getToken();      

            
$i=0;
while ($row = mysqli_fetch_assoc($applications)) {
$i++;
    try{         

                $gepg_flag=true;
                $currency='TZS';
                $bill_amount=20000;
			   // $bill_amount=$row['bill_amount'];
				$payment_type_id=159; //to change income_code  142=ada, 159=quality 
                $bill_pay_opt='3';    //3=full,2:partial   
                $control_number='';  
            
    
            $payer='3';
            $payer_name=str_replace("'","\'",$row['name']);
            $bill_expire=str_replace('+00:00', '', gmdate('c',strtotime(date('Y-m-d H:i:s', strtotime('+12 months')))));
            $bill_description='Quality Assurance Collection';       
            $bill_gen_by='System Admin';
            $bill_appr_by='System Admin'; 
            $phone='';
            $email='';            
             
            $company_id='0';
            $bill_gen_date=OAS::getTime();  
            $bill_eqv_amount=$bill_amount;
            $bill_item_ref=$row['check_no'];             
            $is_posted='1';
            $is_cancelled='1';      
  
            if(!OAS::checkData($bill_item_ref,$payment_type_id)){

            $sql="insert into tbl_billing(payer, payer_name, bill_amount, bill_exp_date, bill_description, bill_gen_by, bill_appr_by, payer_cell_num, payer_email, bill_currency, 
                  payment_type_id, company_id, bill_gen_date, bill_pay_opt, use_on_pay, bill_eqv_amount, bill_item_ref, is_posted, is_cancelled,year_id,control_number)
                  VALUE('{$payer}','{$payer_name}','{$bill_amount}','{$bill_expire}','{$bill_description}','{$bill_gen_by}','{$bill_appr_by}','{$phone}','{$email}','{$currency}',
             '{$payment_type_id}','{$company_id}','{$bill_gen_date}','{$bill_pay_opt}','N','{$bill_eqv_amount}','{$bill_item_ref}','{$is_posted}','{$is_cancelled}','{$year_id}','{$control_number}');";
           
             print_r($sql.PHP_EOL);         
         //    exit;
            
            if(mysqli_query($obj->con,$sql)){
				
/*
                    $last_id = mysqli_insert_id($obj->con);

                    $datax = mysqli_query($obj->con, "select b.id, payer, payer_name, bill_amount, bill_exp_date, bill_description, bill_gen_by, bill_appr_by, payer_cell_num, payer_email, 
                                                             bill_currency, payment_type_id, company_id, bill_gen_date, bill_id, control_number,bill_pay_opt, use_on_pay, bill_eqv_amount,
                                                              bill_item_ref,ptype.acc_code from tbl_billing b
                                               inner join tbl_payment_types ptype on b.payment_type_id=ptype.id
                                               where b.id='{$last_id}'");

                    $rowx = mysqli_fetch_assoc($datax);

                    print_r(OAS::fetchData($rowx, $token));

                    echo PHP_EOL;
                
                
//                print_r('Reg Number:'.$row['reg_number'].' Bill Currency: '.$currency.' Amount '.$bill_amount.PHP_EOL);
                print_r($i.': Data was saved successfully '.PHP_EOL);
*/
            }else{
                print_r('Data was not saved successfully'.PHP_EOL);
            }
			
            
            }else{
                print('Data already exists'.PHP_EOL);
            }

    }catch(Exception $e){
        print_r($e);

    }

}


print PHP_EOL."Process was completed successfully".PHP_EOL;
class OAS
{
    public static $con;
    const USERNAME='DM';
    const SessionToken='NXck5OVhpTGLq9MUYzaZ';

    public function __construct(){    
        $user_name = "gepg_admin";
        $password = 'g3pga6m1n$@321';
        $database = "gepg_admin";
        $server = "127.0.0.1";

        $this->con = mysqli_connect($server, $user_name, $password);
        mysqli_select_db($this->con, $database);
    }
                                         
    public static function checkData($reg_num,$payment_type_id){
            /*
                $obj=new OAS();
                $resp=mysqli_query($obj->con,"SELECT * FROM tbl_billing where bill_item_ref='{$reg_num}' and payment_type_id='{$payment_type_id}' AND year_id='4'");
                $flag=false;
                if(mysqli_num_rows($resp)>0){
                    $flag=true;
                }

                return $flag;  
            */

            return false;
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
            'callBackUrl' => 'http://gepgadmin.udom.ac.tz/transaction/gepgtransaction.aspx',
            'data' => [
                'billAmt' => $row['bill_amount'],
                'miscAmt' => $row['bill_amount'],
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
                'billEqvAmt' =>$row['bill_amount'],
                'remFlag' => true,
                'billPayOpt' => $row['bill_pay_opt'],
                'billItermRef' => $row['bill_item_ref'],
                'useItemRefOnPay' => 'N',
                'billItemAmt' => $row['bill_amount'],
                'billItemEqvAmt' => $row['bill_amount'],
                'billItemMiscAmt' => $row['bill_amount'],
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
   