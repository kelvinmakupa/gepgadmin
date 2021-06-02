
<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 7/27/17
 * Time: 1:59 AM
 */


$obj=new OAS();      


$applications = mysqli_query($obj->con, "select * from allen");    

$year_id=4;  
              
$i=0;
while ($row = mysqli_fetch_assoc($applications)) {
$i++;
    try{
      $fee_array=array(['local_amount'=>'20000','acc_code'=>'45','description'=>'Quality Assurance','payment_type_id'=>'31'],['local_amount'=>'20000','acc_code'=>'15','description'=>'UDOSO FEE','payment_type_id'=>'32']);
    
        foreach( $fee_array as $fee){   
        
                $gepg_flag=false;    
                $currency='TZS';
                $bill_amount=$fee['local_amount'];      
                $bill_pay_opt='3';
        
                $payer='3';     
            
                $bill_expire=str_replace('+00:00', '', gmdate('c',strtotime(date('Y-m-d H:i:s', strtotime('+12 months')))));
                $bill_description=strtoupper($fee['description']);
                $bill_gen_by='System Admin';
                $bill_appr_by='System Admin';
                $phone=''; //$row['phone'];
                $email=$row['email'];
                $payment_type_id=$fee['payment_type_id'];
                $company_id='0';
                $bill_gen_date=date('Y-m-d H:i:s');
                $bill_eqv_amount=$bill_amount;
                $bill_item_ref=$row['reg_no'];
                $is_posted='2';   
                $is_cancelled='1';
                $control_number='';
                $payer_name=$row['names'];   
  
            $sql="insert into tbl_billing(payer, payer_name, bill_amount, bill_exp_date, bill_description, bill_gen_by, bill_appr_by, payer_cell_num, payer_email, bill_currency, 
                  payment_type_id, company_id, bill_gen_date, bill_pay_opt, use_on_pay, bill_eqv_amount, bill_item_ref, is_posted, is_cancelled,year_id,control_number)
                  VALUE('{$payer}','{$payer_name}','{$bill_amount}','{$bill_expire}','{$bill_description}','{$bill_gen_by}','{$bill_appr_by}','{$phone}','{$email}','{$currency}',
             '{$payment_type_id}','{$company_id}','{$bill_gen_date}','{$bill_pay_opt}','N','{$bill_eqv_amount}','{$bill_item_ref}','{$is_posted}','{$is_cancelled}','{$year_id}','{$control_number}');";

           if(mysqli_query($obj->con,$sql)){        
            
                $last_id = mysqli_insert_id($obj->con);
                $control_number=OAS::generateBill($last_id,$fee['acc_code']);
                $query="update tbl_billing set control_number='".$control_number."' where id='".$last_id."'";
                mysqli_query($obj->con,$query);
            
                print_r('Data was saved successfully '.$i.PHP_EOL);

            }else{
                print_r('Data was not saved successfully'.PHP_EOL);
            }
   
        }
    }catch(Exception $e){
        print_r($e);
        
    }
      
}

print PHP_EOL."Process was completed successfully".PHP_EOL;
class OAS
{
    public static $con;
    public function __construct(){
        $user_name = "gepg_admin";
        $password = 'g3pga6m1n$@321';
        $database = "gepg_admin";
        $server = "127.0.0.1";

        $this->con = mysqli_connect($server, $user_name, $password);
        mysqli_select_db($this->con, $database);
    }  

    public static function generateBill($bill_id,$payment_type){

        $choice=strlen($bill_id);
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
    
        return $control_number;
    }



}
