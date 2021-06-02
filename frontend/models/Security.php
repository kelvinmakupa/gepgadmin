<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 20/09/2019
 * Time: 20:30
 */

namespace app\models;

use Yii;
use api\models\User;
use app\models\SpSystem;

class Security
{

    public $content;
    public $access_token;
    public $payload;
    public $url;

    public function getKey($id){  // Retrieve private key

            return  User::findOne($id)->secret_key;
    }

    public function getAccessToken($system_id){  // Retrieve system access token

            return  User::findOne($system_id)->sys_access_token;
    }


    public function generateSignature($message,$id){  // Generate signature

        $key=$this->getKey($id);

        $signature = hash_hmac('sha256', json_encode($message),$key);

        return $signature;
    }

    public function validateSignature($request){  // validate signature

            $computed_signature=$this->generateSignature(json_encode($request['data']));

            return $request['signature']==$computed_signature;

    }

    public function pushBill($billObject){

        if($sp_system=User::findOne($billObject->sp_system_id)) {

            $this->url = $sp_system->bill_resp_url;
            $this->access_token=$sp_system->sys_access_token;
            $this->contents = [
                'sys_bill_id' => $billObject->sys_bill_id,
                'control_number' => $billObject->control_number,
                'statusCode' => 7101,
                'status' => 'Successfull'
            ];

            $this->payload = json_encode([
                "TrxResp" => $this->contents,
                "signature" => $this->generateSignature($this->contents, $billObject->sp_system_id)
            ]);


        return $this->sendRequest();
        }
    }

 public function pushTransaction($transObject){

        $billObject=TblBilling::findOne(['control_number'=>$transObject->pay_control_num]);

        if($sp_system=User::findOne($billObject->sp_system_id)) {
            $this->url = $sp_system->pmt_info_url;
            $this->access_token=$sp_system->sys_access_token;
            $this->contents = [
                'sys_bill_id' => $billObject->sys_bill_id,
                'payer_id'=>$billObject->bill_item_ref,
                'control_number' => $billObject->control_number,
                'pay_ref_id' => $transObject->pay_ref_id,
                'bill_amount' => $billObject->bill_amount,
                'paid_amount' => $transObject->paid_amount,
                'bill_pay_opt' => $transObject->bill_pay_opt,
                'ccy' => $transObject->ccy,
                'trx_dt_tm' => $transObject->trx_dt_tm,
                'usd_pay_channel' =>$transObject->usd_pay_channel,
                'payer_cell_num' =>$transObject->payer_cell_num,
                'payer_name' =>$transObject->payer_name,
                'payer_email' =>$transObject->payer_email,
                'psp_receipt_num' =>$transObject->psp_receipt_num,
                'psp_name' =>$transObject->psp_name,
                'statusCode' => 7101,
                'status' => 'Successfull'
            ];


            $this->payload = json_encode([
                "TrxResp" => $this->contents,
                "signature" => $this->generateSignature($this->contents, $billObject->sp_system_id)
            ]);


//         return $this->payload;

        return $this->sendRequest();
        }
    }



    public function sendRequest(){

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer {$this->access_token}",
                "Content-Length: " . strlen($this->payload))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;



    }




}