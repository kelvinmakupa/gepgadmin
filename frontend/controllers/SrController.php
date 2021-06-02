<?php

namespace frontend\controllers;

use app\models\GePG;
use Yii;
use app\models\TblBilling;
use app\models\TblBillingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Common;
use app\models\GepgBank; 
use kartik\mpdf\Pdf;
use app\models\TblCancellation;
use app\models\Export;
use app\models\TblPaymentTypes;

/**
 * BillingController implements the CRUD actions for TblBilling model.   
 */
class SrController extends Controller
{

    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'only' => ['srbill'],
    //             'rules' => [
    //                 [
    //                     'actions' => ['srbill'],
    //                     'allow' => true,
    //                     'roles' => ['?'],
    //                 ]
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'logout' => ['post', 'get'],
    //             ],
    //         ],
    //     ];
    // }   

    public function beforeAction($action) {
        if($action->id == "srbill")
            $this->enableCsrfValidation = false;
        
        return parent::beforeAction($action);
    }                 

    public function actionSrbill()
    {
   
         

     //  $this->layout='';
        try {


            
            $data = file_get_contents("php://input");
            
            return $data;

            $model=new TblBilling();

            if($m=TblBilling::find()->where('bill_item_ref=:ref',[':ref'=>$data->data->billItermRef])->andWhere('payment_type_id=:id',[':id'=>'27'])->one()){
              //  GePG::postRequest($m->id);
                $response = array('statusCode' => 400, 'message' => 'Duplicate Entry');
                return $response;
            }else{
                $model->payer = 3;
                $model->payer_name = $data->data->payerName;
                $model->bill_amount = $data->data->billAmt;
                $model->bill_exp_date = $data->data->billExpDate;
                $model->bill_description = $data->data->billDesc;
                $model->bill_gen_by = $data->data->billGenBy;
                $model->bill_appr_by = $data->data->billApprBy;
                $model->payer_cell_num = $data->data->payerCellNum;
                $model->payer_email = $data->data->payerEmail;
                $model->bill_currency = $data->data->Ccy;
                $model->payment_type_id = TblPaymentTypes::find()->where('acc_code=:code', [':code' => $data->data->accCode])->one()->id;
                $model->company_id = 0;
                $model->bill_gen_date = $data->data->billGenDate;
                $model->bill_id = '';
                $model->control_number = '';
                $model->use_on_pay = 'N';             
                $model->bill_item_ref=$data->data->billItermRef;
                $model->bill_eqv_amount=$data->data->billEqvAmt;
                $model->bill_pay_opt = 3;

                if ($model->save(false)) {
                    // GePG::postRequesttest($model->id);     

                    GePG::postRequest($model->id);

                    $response = array('statusCode' => 200, 'message' => 'Ok');
                    return $response;
                } else {

                    $response = array('statusCode' => 400, 'message' => 'Please check your data');
                    return $response;
                }
            }

        } catch (Exception $e) {

                //print_r($e);
                $response=array('statusCode'=>400,'message'=>$e->getMessage());
        }
       
    }

    protected function findModel($id)
    {
        if (($model = TblBilling::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
