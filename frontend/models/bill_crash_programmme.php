
<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 7/27/17
 * Time: 1:59 AM
 */


$obj=new OAS();
$token=OAS::getToken();                               
/*
while ($row = mysqli_fetch_assoc(mysqli_query($obj->con, "select * from tbl_billing where id=245717 "))) {
   // while ($row = mysqli_fetch_assoc(mysqli_query($obj->con, "select * from tbl_billing where id>=245717 AND id<=246029"))) {
     

$datax = mysqli_query($obj->con, "select b.id, payer, payer_name, bill_amount, bill_exp_date, bill_description, bill_gen_by, bill_appr_by, payer_cell_num, payer_email, 
bill_currency, payment_type_id, company_id, bill_gen_date, bill_id, control_number,bill_pay_opt, use_on_pay, bill_eqv_amount,
 bill_item_ref,ptype.acc_code from tbl_billing b
inner join tbl_payment_types ptype on b.payment_type_id=ptype.id
where b.id='".$row['id']."'");

$rowx = mysqli_fetch_assoc($datax);
   
print_r(OAS::fetchData($rowx, $token));
}
*/

$applications = mysqli_query($obj->con, "select * from extended_accomodation_");      

$year_id=3;            
                             
$token=OAS::getToken();                               
            
$i=0;
while ($row = mysqli_fetch_assoc($applications)) {
$i++;
    try{         

                $gepg_flag=true;
                $currency='TZS';
                $bill_amount=$row['tuition_fee'];
                $bill_pay_opt='2';    
                $control_number='';
            

            $payer='3';   
            $payer_name=str_replace("'","\'",$row['names']);
            $bill_expire=str_replace('+00:00', '', gmdate('c',strtotime(date('Y-m-d H:i:s', strtotime('+3 months')))));
            $bill_description='EXTENDED ACCOMMODATION';
            $bill_gen_by='Elia Mutalemwa';
            $bill_appr_by='Elia Mutalemwa'; 
            $phone='';
            $email='';
            $payment_type_id=6; 
            $company_id='0';
            $bill_gen_date=OAS::getTime();  
            $bill_eqv_amount=$bill_amount;
            $bill_item_ref=$row['reg_number'];
            $is_posted='1';
            $is_cancelled='1';      
  
            if(!OAS::checkData($bill_item_ref,$payment_type_id)){

            $sql="insert into tbl_billing(payer, payer_name, bill_amount, bill_exp_date, bill_description, bill_gen_by, bill_appr_by, payer_cell_num, payer_email, bill_currency, 
                  payment_type_id, company_id, bill_gen_date, bill_pay_opt, use_on_pay, bill_eqv_amount, bill_item_ref, is_posted, is_cancelled,year_id,control_number)
                  VALUE('{$payer}','{$payer_name}','{$bill_amount}','{$bill_expire}','{$bill_description}','{$bill_gen_by}','{$bill_appr_by}','{$phone}','{$email}','{$currency}',
             '{$payment_type_id}','{$company_id}','{$bill_gen_date}','{$bill_pay_opt}','N','{$bill_eqv_amount}','{$bill_item_ref}','{$is_posted}','{$is_cancelled}','{$year_id}','{$control_number}');";




            //print_r($sql.PHP_EOL);    

             
            if(mysqli_query($obj->con,$sql)){
                /*
                if($gepg_flag) {
                    $last_id = mysqli_insert_id($obj->con);

                    $datax = mysqli_query($obj->con, "select b.id, payer, payer_name, bill_amount, bill_exp_date, bill_description, bill_gen_by, bill_appr_by, payer_cell_num, payer_email, 
                                                             bill_currency, payment_type_id, company_id, bill_gen_date, bill_id, control_number,bill_pay_opt, use_on_pay, bill_eqv_amount,
                                                              bill_item_ref,ptype.acc_code from tbl_billing b
                                               inner join tbl_payment_types ptype on b.payment_type_id=ptype.id
                                               where b.id='{$last_id}'");

                    $rowx = mysqli_fetch_assoc($datax);

                    print_r(OAS::fetchData($rowx, $token));

                    echo PHP_EOL;
                }
                */
                
//                print_r('Reg Number:'.$row['reg_number'].' Bill Currency: '.$currency.' Amount '.$bill_amount.PHP_EOL);
                print_r($i.': Data was saved successfully '.PHP_EOL);

            }else{
                print_r('Data was not saved successfully'.PHP_EOL);
            }
            



            }else{
                print('Data already exists'.PHP_EOL);
            }

    

      
/*
//        if(!OAS::checkStudent($user_id)) {


//             $resp=OAS::tcuAddApplicant($user_id, strtoupper(str_replace("'","\'",$row['first_name'])), strtoupper(str_replace("'","\'",$row['middle_name'])), strtoupper(str_replace("'","\'",$row['last_name'])), $row['sex'],$dob,$row['citizenship'],$email,$phone,$f4index,$other_f4index,$f6index,$other_f6index,
//                 $row['code'],$row['study_level'],$row['yos'],$row['academic_year'],$row['citizenship']);
            //   print(OAS::tcuAddApplicant($user_id, $f4index, $f6index,$other_f4index, $other_f6index,$row['selected_programmes'],'',$dob,$phone,$row['nationality'],$row['disability'],$email,$reason));
           //    print(OAS::tcuAddApplicant($user_id, $f4index, $f6index,$other_f4index, $other_f6index,$row['selected_programmes'],$row['course_code'],$dob,$phone,$row['nationality'],$row['disability'],$email,$reason));

            /* $link = 'http://api.tcu.go.tz/applicants/add';
             $xml = new DOMDocument("1.0", "UTF-8");
             $xml_root_tag = $xml->createElement("Request");
             $credentials = $xml->createElement("UsernameToken");
             $xml_root_tag->appendChild($credentials);
             $credentials->appendChild($xml->createElement("username", OAS::USERNAME));
             $credentials->appendChild($xml->createElement("SessionToken", OAS::SessionToken));

             $data_root_tag = $xml->createElement("requestParameters");
             $xml_root_tag->appendChild($data_root_tag);
             $data_root_tag->appendChild($xml->createElement("institutionCode", OAS::USERNAME));
             $data_root_tag->appendChild($xml->createElement("f4indexno", $f4index));
             $data_root_tag->appendChild($xml->createElement("f6indexno", $f6index));
             $data_root_tag->appendChild($xml->createElement("Category", $category));
             $data_root_tag->appendChild($xml->createElement("Other_f4indexno", $other_f4index));
             $data_root_tag->appendChild($xml->createElement("Other_f6indexno", $other_f6index));

             $xml->appendChild($xml_root_tag);
             $xml_data = $xml->saveXML();

             $data = OAS::fetchData($link, $xml_data);

             $ob = new SimpleXMLElement($data, LIBXML_NOCDATA);


             $resp = $ob->RESPONSE->RESPONSEPARAMETERS;

             OAS::tcuUpdateApplicant($user_id, $f4index, (integer)$resp->ERROR_CODE, (string)$resp->STATUS_DESCRIPTION);
     */
//            print($i.":".$resp);

//        }else{
//            print_r('Else Part'.PHP_EOL);
//        }
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

    public static function getFeeStructure($program_code,$yos){

        if($yos>1){
            $yos=2;
        }


        $obj=new OAS();
        $query=mysqli_query($obj->con,"SELECT payment_type_id, fee.local_amount, fee.foreign_amount, p.code, ptype.acc_description AS description,ptype.acc_code
                                    FROM tbl_fee_structure fee
                                    INNER JOIN programmes p ON p.program_id = fee.programme_id
                                    INNER JOIN tbl_payment_types ptype ON ptype.id = fee.payment_type_id
                                    WHERE p.code =  '{$program_code}'
                                    AND year_of_study =  '{$yos}'
                                    AND ptype.id<>34
                                    AND academic_year_id =3");

       return $query;
    }                                         


    public static function checkData($reg_num,$payment_type_id){

            $obj=new OAS();
            $resp=mysqli_query($obj->con,"SELECT * FROM tbl_billing where bill_item_ref='{$reg_num}' and payment_type_id='{$payment_type_id}' AND year_id='3'");
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


    public static function getF4IndexNumber($user_id){
        $obj=new OAS();
        $query=mysqli_query($obj->con,"select * from ordinary_result r left join ordinary_level o on r.ordinary_level_id=o.id where r.user_id='{$user_id}' order by o.index_number desc limit 1");
        if($response=mysqli_fetch_assoc($query)) {
            return $response['index_number'];
        }else{
            return '';
        }

    }      

    public static function getOtherF4IndexNumbers($user_id){  
        $index_numbers=array();
        $form4=OAS::getF4IndexNumber($user_id);
        $obj=new OAS();
        $query=mysqli_query($obj->con,"select o.index_number as index_number from ordinary_result r left join ordinary_level o 
            on r.ordinary_level_id=o.id
            where r.user_id='{$user_id}' AND o.index_number<>'{$form4}'");

       if($data=mysqli_fetch_assoc($query)) {

         foreach ($data as $key => $value) {
             array_push($index_numbers, $value);
           }
       }
        return implode(',',$index_numbers);
    }

    public static function getF6IndexNumber($user_id){

        $obj=new OAS();
        $query=mysqli_query($obj->con,"select * from advance_result r left join advanced_level a on r.advance_level_id=a.id where r.user_id='{$user_id}' order by a.index_number desc limit 1");
        if($response=mysqli_fetch_assoc($query)) {
            return $response['index_number'];
        }
    }


    public static function getOtherF6IndexNumbers($user_id){
        $index_numbers=array();
        $obj=new OAS();
        $form6=OAS::getF6IndexNumber($user_id);
        $query=mysqli_query($obj->con,"select a.index_number from advance_result r left join advanced_level a 
            on r.advance_level_id=a.id
            where r.user_id='{$user_id}'  AND a.index_number<>'{$form6}'");

        if($data=mysqli_fetch_assoc($query)){
            foreach ($data as $key=>$value){
                array_push($index_numbers,$value);
            }
        }

        return implode(',',$index_numbers);
    }


    public static function getRemarks($user_id){

        $obj=new OAS();
        $query=mysqli_query($obj->con,"select * from eligible_students where elligibility_status='1' AND academic_year='2018/19' AND user_id='{$user_id}'");
        if(mysqli_num_rows($query)>0){
            return 'Capacity Full';
        }else{
           return 'Unqualified';
        }

    }

    public static function getQualification($user_id){

        $obj=new OAS();
        $query=mysqli_query($obj->con,"select * from qualification where qualification_type='2' AND user_id='{$user_id}'");
        if($row=mysqli_fetch_assoc($query)){
            return $row;
        }

    }

    public static function tcuAddApplicant($user_id, $first_name, $middle_name, $last_name, $sex,$dob,$citizenship,$email,$phone,$f4index,$other_f4index,$f6index,$other_f6index,$code,$study_level,$yos,$academic_year){

        $obj=new OAS();
        $reg_num=OAS::genRegNo(OAS::getReg(),$citizenship);
        $sql="insert into student_details(reg_number,admission_number,first_name,middle_name,last_name,sex,dob,citizenship,email,phone,f4indexno,other_f4indexno,
              f6indexno,other_f6indexno,programme_code,study_level,yos,academic_year,created_at)
             VALUE('{$reg_num}','{$user_id}','{$first_name}','{$middle_name}','{$last_name}','{$sex}','{$dob}','{$citizenship}','{$email}','{$phone}','{$f4index}','{$other_f4index}',
             '{$f6index}','{$other_f6index}','{$code}','{$study_level}','{$yos}','{$academic_year}',now())";

//        print_r($sql.PHP_EOL);

        if(mysqli_query($obj->con,$sql)){
           OAS::updateReg();
           return 'Row inserted successfully'.PHP_EOL;

       }else{
            $ad='Data was not inserted '.$sql.' Time generated:'.date('Y-m-d h:i:s').PHP_EOL;
            $log_file = 'student_details_log.txt';
            $handle = fopen($log_file, 'w') or die('Cannot open file:  '.$log_file);
            fwrite($handle, $ad);

           return $ad ;
       }


    }

    public static function updateReg(){
        $obj=new OAS();
        mysqli_query($obj->con,"update academic_year set under_reg=under_reg+1 where status=1");

    }
 public static function getReg(){
        $obj=new OAS();
        $query=mysqli_query($obj->con,"select under_reg from academic_year where status=1");

        if($response=mysqli_fetch_assoc($query)) {
            return $response['under_reg'];
        }
     }

    public static function checkTcuApplicant($user_id){
        $obj=new OAS();
        $flag=false;
        if(mysqli_fetch_assoc(mysqli_query($obj->con,"SELECT * FROM student_details where admission_number='{$user_id}'"))){
           $flag=true;
        }

        return $flag;

    }


    public static function genRegNo($num,$citizen){

        $choice=strlen($num);

        switch($choice){

            case 1:
                $number='0000'.$num;
                break;
            case 2:
                $number='000'.$num;
                break;
            case 3:
                $number='00'.$num;
                break;
            case 4:
                $number='0'.$num;
                break;
            case 5:
                $number=$num;
                break;
            default:
                $number=$num;
                break;
            }

        $nationality=strtoupper(substr($citizen,0,1));

        return $nationality.'/UDOM-SJUCHAS/'.date('Y').'/'.$number;

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
   