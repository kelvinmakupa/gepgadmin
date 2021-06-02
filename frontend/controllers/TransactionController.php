<?php

namespace frontend\controllers;

use Yii;
use app\models\Security;
use app\models\Transaction;
use app\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TblBilling;
use app\models\Common;
use app\models\PaymentType;
use app\models\Export;
use kartik\mpdf\Pdf;
use app\models\TblReconcilliation;
date_default_timezone_set('Africa/Nairobi');

/**
 * TransactionController implements the CRUD actions for Transaction model.   
 */
class TransactionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        $behaviors=[];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];


        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::className(),
            // We will override the default rule config with the new AccessRule class
            // 'only'=>['index','create','delete','update','view'],
            'ruleConfig' => [
                'class' => \frontend\commands\rbac\rules\AccessRule::className(),
            ],
            'rules' => [
                [
                    'actions' => ['gepgtransaction'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        $action             = Yii::$app->controller->action->id;
                        $controller         = Yii::$app->controller->id;
                        $route              = $action."-".$controller;
                        if (\Yii::$app->user->can($route)) {
                            return true;

                        }
                    }
                ],
            ],
        ];


        return $behaviors;

    }

    public function beforeAction($action) {
        if($action->id == "gepgtransaction")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }



    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSpSystem($id){

        $model=new Security();

        $transObj=$this->findModel($id);

        $model->pushTransaction($transObj);

        Yii::$app->session->setFlash("success","Payment was successfull sent to SP System");

        return $this->redirect(['view','id'=>$id]);

    }





    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination=[
            'pageSize'=>200
        ];
        $dataProvider->sort= [
            'defaultOrder' => ['id'=>SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionGepgtransaction()
    {
        $sp=new Security();
        
        if(Yii::$app->request->isPost){
            try {

                $data = json_decode(file_get_contents("php://input"));

                $response_type=$data->responseType;             // 1-billing ; 2-control number ; 3-transaction ; 4-rencocilliation


                if($response_type==1){
                    $payer_id=$data->payerId;   //payer id is the billing id
                    if($data->statusCode==463){
                        GePG::auth();
                        $res2=GePG::postRequest($payer_id);
                        if($res2){
                            $response2=json_decode($res2);

                            if($response2->statusCode==200){
                                if($model=TblBilling::find()->where('id=:billing_id',[':billing_id'=>$payer_id])->one()){
                                    $model->bill_id=$response2->billId;
                                    $model->is_posted='2';
                                    if($model->update(false)){
                                        $response=array("statusCode"=>200);
                                    }else{
                                        $response=array("statusCode"=>200);
                                    }
                                }
                                return json_encode($response);

                            }else{
                                return json_encode(array("statusCode"=>480));
                            }

                        }

                    }else{
                        if($data->statusCode==200){

                            $response="";
                            if($model=TblBilling::find()->where('id=:billing_id',[':billing_id'=>$payer_id])->one()){
                                $model->bill_id=$data->billId;
                                $model->is_posted='2';
                                if($model->update(false)){
                                    $response=array("statusCode"=>200);
                                }else{
                                    $response=array("statusCode"=>200);
                                }
                            }

                            return json_encode($response);
                        }else{
                            return json_encode(array("statusCode"=>480));
                        }
                    }

                }else if($response_type==2){
                    $bill_id=$data->billId;
                    $control_number=$data->payCntrNum;
                    $query=Yii::$app->db->createCommand("UPDATE tbl_billing SET control_number=:control WHERE bill_id=:bill");
                    $query->bindValue(':bill',$bill_id);
                    $query->bindValue(':control',$control_number);

                    if($query->execute()){

                        $spBill=TblBilling::findOne(['bill_id'=>$bill_id]);
                        $sp->pushBill($spBill);
                        $sys_response=array("statusCode"=>200);
                    }else{
                        $sys_response=array("statusCode"=>480);
                    }

                    return json_encode($sys_response);

                }else if($response_type==3){

                    $transaction=$data->data;      
                    if(!Transaction::find()->where('trx_id=:id',[':id'=>$transaction->TrxId])->one()) {
                        $model = new Transaction();
                        $model->bill_id = $transaction->BillId;
                        $model->trx_id = $transaction->TrxId;
                        $model->pay_ref_id = $transaction->PayRefId;
                        $model->pay_control_num = $transaction->PayCtrNum;
                        $model->bill_amount = $transaction->BillAmt;
                        $model->paid_amount = $transaction->PaidAmt;
                        $model->bill_pay_opt = $transaction->BillPayOpt;
                        $model->ccy = $transaction->Ccy;
                        $model->trx_dt_tm = $transaction->TrxDtTm;
                        $model->usd_pay_channel = $transaction->UsdPayChnl;
                        $model->payer_cell_num = $transaction->PyrCellNum;
                        $model->payer_name = str_replace("'","\'",$transaction->PyrName);
                        $model->payer_email = $transaction->PyrEmail;
                        $model->psp_receipt_num = $transaction->PspReceiptNumber;
                        $model->psp_name = $transaction->PspName;
                        $model->ctr_acc_num = $transaction->CtrAccNum; 
                       // $model->received_date = Common::getStandardTime(date('Y-m-d H:i:s'));

                        if ($model->save(false)) {

                            $spTrans=Transaction::findOne(['trx_id'=>$transaction->TrxId]);
                            $sp->pushTransaction($spTrans);
                            $sys_response = array("statusCode" => 200);
                        } else {
                            $sys_response = array("statusCode" => 480);
                        }
                    }else{
                        $sys_response = array("statusCode" => 206);
                    }   

                    return json_encode($sys_response);
                }else if($response_type==4){

                    foreach($data->data as $c){

                        $bill_id=$c->billId;
                        $gepg_response=$c->statusCode;
                        if($gepg_response==200) {
                            Common::updateBillIsCancelled($bill_id);
                            Common::updateCancellation($bill_id, $gepg_response,'Cancelled Sucessfully');
                        }else{
                            Common::updateCancellation($bill_id, $gepg_response,'Cancellation Failed');
                        }

                    }

                }else if($response_type==5){

                    $reconc_id=$data->reconcReqId;
                   if($model=TblReconcilliation::find()->where('reconc_id=:reco',[':reco'=>$reconc_id])->one()) {
                       $rawdata = $data->data;
                       $m = new Export();
                       $m->dataPopulation($rawdata, $model->trx_date);
                       $file_name = str_replace(' ', '_', 'reconc_of_' . $model->trx_date . '_' . date('Y-m-dhis') . '.xls');
                       $m->download($file_name);
                       $query = Yii::$app->db->createCommand("update tbl_reconcilliation set file_name=:file where reconc_id=:id");
                       $query->bindValue(':file', $file_name);
                       $query->bindValue(':id', $reconc_id);
                       $query->execute();
                       return json_encode(array('statusCode'=>200));
                   }else{
                       return json_encode(array('statusCode'=>400));
                   }
                }

            } catch (yii\base\ErrorException $e) {
                return json_encode(array("statusCode"=>"469 ".$e));

            }

        }else{
            return json_encode(array("statusCode"=>400));
        }


    }


    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }




    public function actionReceipt($id)
    {

        $model=$this->findModel($id);

        /*
        $content = $this->renderPartial('receipt', [
            'model' => $model,
            'bill'=>TblBilling::find()->where('control_number=:c',[':c'=>$model->pay_control_num])->one()
        ]);
        */

        $bill=TblBilling::find()->where('control_number=:c',[':c'=>$model->pay_control_num])->one();
        if(trim($bill->bill_id)==''){
                $content = $this->renderPartial('receipt', [
                    'model' => $model,
                    'payment'=>PaymentType::findOne($bill->payment_type_id),
                    'data'=>Common::getOutstandingBalance($model->pay_control_num),
                    'bill'=>$bill
                ]);
            }else{
                $content = $this->renderPartial('gepg_receipt', [
                    'model' => $model,
                    'payment'=>PaymentType::findOne($bill->payment_type_id),
                    'data'=>Common::getOutstandingBalance($model->pay_control_num),
                    'bill'=>$bill
                ]);

            }

        // setup kart


        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,


            'filename'=>'Stakabadhi ya Malipo ya Chuo Kikuu Dodoma.pdf',
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' =>$content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => [
                'title' => 'Billing System',
                'subject' => 'UDOM Billing System',
                'keywords' => 'krajee, grid, export, yii2-grid, pdf'
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetTitle'=>'Stakabadhi ya Malipo ya Chuo Kikuu Dodoma'
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();

    }



    public function actionReverse($id,$trx_status){


        Yii::$app->db->createCommand()->update('tbl_transaction',
            [
                'trx_status'=>base64_decode($trx_status),
            ],
            [
                'id'=>$id
            ]
            )->execute();

        return $this->redirect(['view', 'id' => $id]);

    }











    public function actionReport(){

        $model = new Transaction();
        $model->scenario='report';
        if($model->load(Yii::$app->request->post())&&$model->validate()){

            $payments=implode(',',$model->payment_type);
            $start_date=$model->start_date;
            $end_date=$model->end_date;

            $data=Yii::$app->db->createCommand("SELECT trx_id,pay_ref_id,tr.ccy,tr.psp_name,tr.psp_receipt_num,tr.ctr_acc_num,UPPER(b.payer_name) AS payer_name,
                                                UPPER(bill_description) AS bill_description, b.payer_cell_num, control_number, bill_item_ref, paid_amount,
                                                tr.trx_dt_tm,pt.acc_code acc_code,pt.acc_description FROM tbl_transaction tr 
                                                INNER JOIN tbl_billing b ON tr.pay_control_num = b.control_number 
                                                INNER JOIN tbl_payment_types pt On pt.id=b.payment_type_id
                                                WHERE UNIX_TIMESTAMP(DATE( trx_dt_tm )) <= UNIX_TIMESTAMP(DATE( '{$end_date}' )) 
                                                AND UNIX_TIMESTAMP(DATE( trx_dt_tm )) >= UNIX_TIMESTAMP(DATE( '{$start_date}' )) 
                                                AND payment_type_id IN({$payments}) ORDER BY trx_dt_tm DESC")->queryAll();

            if(count($data)>0) {

                $obj = new Export();
                $obj->transactionReport($data, $start_date, $end_date);
                $obj->downloadBills('transaction'.date('Y_m_d_H_i_s').'.xls');
            }else{
                Yii::$app->session->setFlash('info','Notice! No data found between '.$start_date.' and '.$end_date);

                return $this->render('report', ['model' => $model]);
            }

        }else {

           return $this->render('report', ['model' => $model]);
        }



    }




    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
