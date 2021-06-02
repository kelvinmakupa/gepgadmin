<?php

namespace app\models;

use Yii;
use DOMDocument;
use SimpleXMLElement;
/**
 * This is the model class for table "necta_credentials".
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $host_address
 * @property string $token
 */
class GePG
{

    const ACC_CODE='12099';
    const USERNAME='oas';
    const KEY='12345';



    public static function auth()
    {

        $link='http://gepg.udom.ac.tz/public/api/auth';

        $credentials=array('user'=>self::USERNAME,'key'=>self::KEY);
        $credentials_json=json_encode($credentials);

        $response=self::fetchData($link,$credentials_json);

        try {

            if ($response) {
                $obj=json_decode($response);
                if ($model=\app\models\GepgCredentials::find()->orderBy('id asc')->one()) {
                    Yii::$app->db->createCommand()->update(
                        'gepg_credentials',
                        [
                            'token' => $obj->token,
                            'created_at' => date('Y-m-d h:i:s'),
                        ],
                        'id=:id', array(':id' => $model->id)
                    )->execute();
                } else {
                    Yii::$app->db->createCommand()->insert('gepg_credentials',
                        [
                            'token' => $obj->token,
                            'created_at' => date('Y-m-d h:i:s'),

                        ]
                    )->execute();
                }

            }

        }catch(Exception $e){
            print_r($e->getMessage());

        }
    }


    public static function postRequest($bill_id){

        $response=json_encode(array("statusCode"=>'480'));

        $link='http://gepg.udom.ac.tz/public/api/udomBillSubReq';
        $bill=TblBilling::find()->where('id=:bill_id',[':bill_id'=>$bill_id])->one();
        $model=GepgCredentials::find()->orderBy('id asc')->one();

        $data = array(
            'token' => $model->token,
            'callBackUrl' => Yii::$app->urlManager->createAbsoluteUrl('transaction/gepgtransaction'),
            'data' => [
                'billAmt' => (double)$bill->bill_amount,
                'miscAmt' => (double)$bill->bill_amount,
                'billExpDate' => $bill->bill_exp_date,
                'payerId' => (string)$bill->id,
                'payerName' => self::xmlPurifier((string)$bill->payer_name),
                'billDesc'  => self::xmlPurifier((string)$bill->bill_description),
                'billGenDate' => $bill->bill_gen_date,
                'billGenBy' => (string)$bill->bill_gen_by,
                'billApprBy' =>(string)$bill->bill_appr_by,
                'payerCellNum' => (string)$bill->payer_cell_num,
                'payerEmail' => (string)$bill->payer_email,
                'Ccy' => $bill->bill_currency,
                'billEqvAmt' =>(double)$bill->bill_eqv_amount,
                'remFlag' => true,
                'billPayOpt' => $bill->bill_pay_opt,
                'billItermRef' => (string)$bill->bill_item_ref,
                'useItemRefOnPay' => $bill->use_on_pay,
                'billItemAmt' => (double)$bill->bill_amount,
                'billItemEqvAmt' => (double)$bill->bill_amount,
                'billItemMiscAmt' =>(double) $bill->bill_amount,
                'accCode' => (string)PaymentType::find()->where('id=:id',[':id'=>$bill->payment_type_id])->one()->acc_code

            ]
        );

        $payload=json_encode($data);
//
//        return $payload;
        $datax=json_decode(self::fetchData($link,$payload));

        if($datax){
            if($datax->statusCode==463) {
                self::auth();
                $model = GepgCredentials::find()->orderBy('id asc')->one();

                $data = array(
                    'token' => $model->token,
                    'callBackUrl' => Yii::$app->urlManager->createAbsoluteUrl('transaction/gepgtransaction'),
                    'data' => [
                        'billAmt' => (double)$bill->bill_amount,
                        'miscAmt' => (double)$bill->bill_amount,
                        'billExpDate' => $bill->bill_exp_date,
                        'payerId' => (string)$bill->id,
                        'payerName' => self::xmlPurifier((string)$bill->payer_name),
                        'billDesc' =>self::xmlPurifier((string)$bill->bill_description),
                        'billGenDate' => $bill->bill_gen_date,
                        'billGenBy' => (string)$bill->bill_gen_by,
                        'billApprBy' =>(string)$bill->bill_appr_by,
                        'payerCellNum' => (string)$bill->payer_cell_num,
                        'payerEmail' =>   (string)$bill->payer_email,
                        'Ccy' => $bill->bill_currency,
                        'billEqvAmt' =>(double)$bill->bill_eqv_amount,
                        'remFlag' => true,
                        'billPayOpt' => $bill->bill_pay_opt,
                        'billItermRef' => (string)$bill->bill_item_ref,
                        'useItemRefOnPay' => $bill->use_on_pay,
                        'billItemAmt' => (double)$bill->bill_amount,
                        'billItemEqvAmt' => (double)$bill->bill_eqv_amount,
                        'billItemMiscAmt' =>(double) $bill->bill_amount,
                        'accCode' => (string)PaymentType::find()->where('id=:id',[':id'=>$bill->payment_type_id])->one()->acc_code

                    ]
                );




                 $payload = json_encode($data);


                $datax2=json_decode(self::fetchData($link,$payload));
                if($datax2){
                    if($datax->statusCode==200) {
                        $response=json_encode(array("statusCode"=>'200'));
                    }
                }

            }else if($datax->statusCode==200) {
                $response=json_encode(array("statusCode"=>'200'));
            }

        }

        return $datax;

    }
    public static function reconciliation($reconcopt,$tnxdt,$requestedBy)
    {

        $link = 'http://gepg.udom.ac.tz/public/api/udomReconcReq';
        $model = GepgCredentials::find()->orderBy('id asc')->one();

        $data = array(
            'token' => $model->token,
            'callBackUrl' => Yii::$app->urlManager->createAbsoluteUrl('transaction/gepgtransaction'),
            'tnxDt' => $tnxdt,
            'reconcopt' => $reconcopt,
            'requestedBy' => $requestedBy,
        );

        $payload = json_encode($data);

        $response = json_decode(self::fetchData($link, $payload));


        if($response){
            if($response->statusCode==463) {
                self::auth();
                $model = GepgCredentials::find()->orderBy('id asc')->one();
                $data = array(
                    'token' => $model->token,
                    'callBackUrl' => Yii::$app->urlManager->createAbsoluteUrl('transaction/gepgtransaction'),
                    'tnxDt' => $tnxdt,
                    'reconcopt' => $reconcopt,
                    'requestedBy' => $requestedBy
                );
                $payload = json_encode($data);
                $resp = json_decode(self::fetchData($link, $payload));
                return $resp;
            }
                return $response;

        }


    }
  
        public static function cancellMultipleBills($billIds,$reason,$cancelledBy){

        $response=json_encode(array("statusCode"=>'480'));

        $link='http://gepg.udom.ac.tz/public/api/udomBillCancelReq';
        $model=GepgCredentials::find()->orderBy('id asc')->one();

        $data = array(
            'token' => $model->token,
            'callBackUrl' => Yii::$app->urlManager->createAbsoluteUrl('transaction/gepgtransaction'),
            'cancelledBy'=>$cancelledBy,
            'reason'=>$reason,
            'BillIds' => $billIds

        );

        $payload=json_encode($data);

        $datax=json_decode(self::fetchData($link,$payload));

        if($datax){
            if($datax->statusCode==463) {
                self::auth();
                $model = GepgCredentials::find()->orderBy('id asc')->one();

                $data = array(
                    'token' => $model->token,
                    'callBackUrl' => Yii::$app->urlManager->createAbsoluteUrl('transaction/gepgtransaction'),
                    'cancelledBy'=>$cancelledBy,
                    'reason'=>$reason,
                    'BillIds' => $billIds

                );

                 $payload = json_encode($data);
                $datax2=json_decode(self::fetchData($link,$payload));
                if($datax2){
                    if($datax->statusCode==200) {
                        $response=json_encode(array("statusCode"=>'200'));
                    }
                }

            }else if($datax->statusCode==200) {
                $response=json_encode(array("statusCode"=>'200'));
            }

        }

        return $datax;

    }


    public static function xmlPurifier($string) {

        return strtr(
            $string,
            array(
                "<" => "&lt;",
                ">" => "&gt;",
                '"' => "&quot;",
                "'" => "&apos;",
                "&" => "&amp;",
            )
        );
    }




    public static function fetchData($url,$payload){

        $ch = curl_init($url);
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




}
