<?php

namespace frontend\controllers;

use app\models\Security;
use app\models\GePG;
use Yii;
use app\models\TblBilling;
use app\models\TblBillingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Common;
use app\models\GepgBank; 
use kartik\mpdf\Pdf;
use app\models\TblCancellation;
use app\models\Export;
use app\models\TblPaymentTypes;

/**
 * BillingController implements the CRUD actions for TblBilling model.   
 */
class BillingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors=[];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
                'postbill' => ['POST'],
                'cancellbill' => ['POST'],
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
                    'actions' => ['srbill'],
//                    'ips' => array('127.0.0.1'),
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
        if($action->id == "srbill"){
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }      


	public function actionAutocomplete(){

        $reg_no =$_POST['registration_number'];

       return Common::fetchStudentDetails($reg_no);



    }



    /**
     * Lists all TblBilling models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblBillingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('is_cancelled=:c',[':c'=>1]);
        $dataProviderR = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination=[
            'pageSize'=>200
        ];
        $dataProvider->sort= [
            'defaultOrder' => ['id'=>SORT_DESC]
        ];



        if(isset($_GET['export'])&&($_GET['export']==11)){
            $dataProviderR->setPagination(false);
            $bills=$dataProviderR->getModels();
            $m=new Export();
            $m->generateData($bills);
            $file_name=date('Ymdhis').'_generated_bills_report.xls';
            $m->downloadBills($file_name);
            }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Send Bill to SP System
     */

    public function actionSpSystem($id){

        $model=new Security();
        $billObj=$this->findModel($id);

        $model->pushBill($billObj);

        Yii::$app->session->setFlash("success","Bill was successfull sent to SP System");

        return $this->redirect(['view','id'=>$id]);

    }



    /**
     * Displays a single TblBilling model.
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
     * Creates a new TblBilling model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  /*  public function actionCreate()
    {
        $model = new TblBilling();
        $model->scenario='individual';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            if(TblBilling::find()->where('payment_type_id=:ptype',[':ptype'=>$model->payment_type_id])->andWhere('year_id=:id',[':id'=>$model->year_id])->andWhere('bill_item_ref=:ref',[':ref'=>$model->bill_item_ref])->andWhere('is_cancelled=:cance',[':cance'=>'1'])->one()){
                Yii::$app->session->setFlash('info', "Duplicate entry");
                return $this->render('create', [
                    'model' => $model,
                    'model2' => $model,
                    'model3' => $model,   
                   ]);   
            }else{

            $model->bill_exp_date=Common::getStandardTime($model->bill_exp_date);

            $model->bill_item_ref=Common::getBillItemRef();
            if($model->bill_currency=='TZS'){
                $model->bill_eqv_amount=$model->bill_amount;
            }
            if($model->bill_currency=='USD'){
                $model->bill_eqv_amount=Common::convertCurrency($model->bill_amount);
            }

            if($model->save()){
              Common::updateBillItemRef();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        }

        return $this->render('create', [
                                         'model' => $model,
                                         'model2' => $model,
                                         'model3' => $model,
                                        ]);
    }
*/

public function actionCreate()
    {
        $model = new TblBilling();
        $model->scenario='individual';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            if(TblBilling::find()->where('payment_type_id=:ptype',[':ptype'=>$model->payment_type_id])->andWhere('year_id=:id',[':id'=>$model->year_id])->andWhere('bill_item_ref=:ref',[':ref'=>$model->bill_item_ref])->andWhere('is_cancelled=:cance',[':cance'=>'1'])->one()){
                Yii::$app->session->setFlash('info', "Duplicate entry");
                return $this->render('create', [
                    'model' => $model,
                    'model2' => $model,
                    'model3' => $model,   
                   ]);   
            }else{

            $model->bill_exp_date=Common::getStandardTime($model->bill_exp_date);

            $model->bill_item_ref=Common::getBillItemRef();
            if($model->bill_currency=='TZS'){   
                $model->bill_eqv_amount=$model->bill_amount;
            }
            if($model->bill_currency=='USD'){
                $model->bill_eqv_amount=Common::convertCurrency($model->bill_amount);
            }

            if($model->save(false)){
              Common::updateBillItemRef();
            }
            // else{
            //         echo "SAmple";   
            //         exit;
            // }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        }

        return $this->render('create', [
                                         'model' => $model,
                                         'model2' => $model,
                                         'model3' => $model,
                                        ]);
    }




// Bank Bill


 public function actionBankbill()
    {
        $model = new TblBilling();   
        $model->scenario='student';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if(TblBilling::find()->where('payment_type_id=:ptype',[':ptype'=>$model->payment_type_id])->andWhere('year_id=:id',[':id'=>'3'])->andWhere('bill_item_ref=:ref',[':ref'=>$model->id])->one()&&!(Yii::$app->user->can('duplicatebill'))){
                Yii::$app->session->setFlash('info', "Duplicate entry");
                return $this->render('bankbill', [
                    'model' => $model,
                   ]);
            }else{

            $model->bill_exp_date=Common::getStandardTime($model->bill_exp_date);

            if($model->bill_currency=='TZS'){
                $model->bill_eqv_amount=$model->bill_amount;
            }
//            if($model->bill_currency=='USD'){
//                $model->bill_eqv_amount=Common::convertCurrency($model->bill_amount);
//            }

            if($model->save()){
              Common::GenerateBill($model->id,$model->payment_type_id);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

        return $this->render('bankbill', [
            'model' => $model,
        ]);
    }









//Ends here








    public function actionCompany()
    {
        $model = new TblBilling();
        $model->scenario='company';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            /* This part was commented to allow duplicate bill to the companies */
            // if(TblBilling::find()->where('payment_type_id=:ptype',[':ptype'=>$model->payment_type_id])->andWhere('year_id=:id',[':id'=>'3'])->andWhere('bill_item_ref=:ref',[':ref'=>$model->bill_item_ref])->one()){
            //     Yii::$app->session->setFlash('info', "Duplicate entry");
            //     return $this->render('create', [
            //         'model' => $model,
            //        ]);
            // }else{

            $model->bill_exp_date=Common::getStandardTime($model->bill_exp_date);
            //$model->bill_item_ref=Common::getBillItemRef();
            if($model->bill_currency=='TZS'){
                $model->bill_eqv_amount=$model->bill_amount;
            }
            if($model->bill_currency=='USD'){
                $model->bill_eqv_amount=Common::convertCurrency($model->bill_amount);
            }

            if($model->save()){
            //Common::updateBillItemRef();
            }
            return $this->redirect(['view', 'id' => $model->id]);
       // }
    }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
 public function actionStudent()
    {
        $model = new TblBilling();
        $model->scenario='student';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if(TblBilling::find()->where('payment_type_id=:ptype',[':ptype'=>$model->payment_type_id])->andWhere('year_id=:id',[':id'=>$model->year_id])->andWhere('bill_item_ref=:ref',[':ref'=>$model->bill_item_ref])->andWhere('is_cancelled=:cance',[':cance'=>'1'])->one()&&!(Yii::$app->user->can('duplicatebill'))){
                Yii::$app->session->setFlash('info', "Duplicate entry");
                return $this->render('create', [
                    'model' => $model,    
                   ]);
            }else{

            $model->bill_exp_date=Common::getStandardTime($model->bill_exp_date);
            //$model->bill_item_ref=Common::getBillItemRef();
            if($model->bill_currency=='TZS'){
                $model->bill_eqv_amount=$model->bill_amount;
            }
            if($model->bill_currency=='USD'){
                $model->bill_eqv_amount=Common::convertCurrency($model->bill_amount);
            }

            if($model->save()){
            //Common::updateBillItemRef();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblBilling model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {    
        $model = $this->findModel($id);
        $model->scenario='update';
        if($model->payer==2){
            $this->redirect(['cupdate','id'=>$model->id]);
        }
        if($model->payer==3){
            $this->redirect(['supdate','id'=>$model->id]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->bill_exp_date=Common::getStandardTime($model->bill_exp_date);
            if($model->bill_currency=='TZS'){
                $model->bill_eqv_amount=$model->bill_amount;
            }
            if($model->bill_currency=='USD'){
                $model->bill_eqv_amount=Common::convertCurrency($model->bill_amount);
            }

            $model->save(false);

            return $this->redirect(['view', 'id' => $model->id]);     
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }




    public function actionUpdat($id)
    {    
        $model = $this->findModel($id);
        $model->scenario='updat';
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);     
        }

        return $this->render('updat', [
            'model' => $model,
        ]);
    }



    public function actionCupdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario='company';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->bill_exp_date=Common::getStandardTime($model->bill_exp_date);
            if($model->bill_currency=='TZS'){
                $model->bill_eqv_amount=$model->bill_amount;
            }
            if($model->bill_currency=='USD'){
                $model->bill_eqv_amount=Common::convertCurrency($model->bill_amount);
            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('cupdate', [
            'model' => $model,
        ]);
    }
    public function actionSupdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario='student';
       
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->bill_exp_date=Common::getStandardTime($model->bill_exp_date);
            
            if($model->bill_currency=='TZS'){
                $model->bill_eqv_amount=$model->bill_amount;
            }
            if($model->bill_currency=='USD'){
                $model->bill_eqv_amount=Common::convertCurrency($model->bill_amount);
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('supdate', [    
            'model' => $model,
        ]);      
    }
      
          
    public function actionCrashpost(){     
           // $data=TblBilling::find()->where(['LIKE','bill_item_ref','T/UDOM/2019'])->andWhere('control_number=:c',[':c'=>''])->all();  
           //haijamaliza commented by sila
		   $data=TblBilling::find()->where('payment_type_id=:ty',[':ty'=>161])->andWhere('id>=:bid',[':bid'=>648000])->andWhere('control_number=:c',[':c'=>''])->all();
    // $data=TblBilling::find()->where('payment_type_id=:ty',[':ty'=>141])->andWhere('id>=:bid',[':bid'=>607394])->andWhere('control_number=:c',[':c'=>''])->all();
       
	    
	 
        //    print_r(count($data));                         
        //    exit;                          
                  
           foreach($data as $key=>$value){  
                GePG::postRequest($value->id);
            }
           
                   
    }

  
    public function actionPostbill($id)
    {

      GePG::postRequest($id);   
    //exit;
        return $this->redirect(['view', 'id' => $id]);
    }

   public function actionCancellbills()
   {
    try{
        $bill_ids=array();     
 
        if (Yii::$app->request->isAjax){
            $data=Yii::$app->request->post('keyslist');
            $reason=urldecode(Yii::$app->request->post('reason'));
 
              foreach($data as $key=>$value){
                $billId=Common::getBillIdFromIds($value);
                if(($billId<>0)&&(trim($billId)!="")) {
                    if(!$mo=TblCancellation::find()->where('bill_id=:id',[':id'=>$billId])->one()){
                        array_push($bill_ids,$billId);
                        $query=new TblCancellation();
                        $query->user_id=Yii::$app->user->identity->id;
                        $query->bill_id=$billId;
                        $query->reason=$reason;
                        $query->date_cancelled=date('Y-m-d h:i:s');
                        $query->save(false);
 
                    }else{
                        if($mo->gepg_response!=200) {
                            array_push($bill_ids, $billId);
                        }
                    }
 
                }
            }
 
             if(count($bill_ids)>0){
                GePG::cancellMultipleBills($bill_ids,$reason,Yii::$app->user->identity->id);
                 return json_encode(array("code" => '200', 'message' => 'The Request to cancell bill ids '. implode(', ',$bill_ids).' was successfully sent'));
             }
            return json_encode(array("code" => '200', 'message' => 'Bills has already been cancelled'));
         }else{
            return json_encode(array("code" => '400', 'message' => 'Invalid data submission'));
 
        }
        }catch(\Exception $e){
          //  return $e->getMessage();
           return json_encode(array("code" => '200', 'message' => $e->getMessage()));
 
        }
    }

    public function actionPrintout($id)
    {

        $model=$this->findModel($id);

        if(trim($model->bill_id)==''){
            $content = $this->renderPartial('printoutnew', [
                'model' =>$model ,
            ]);
        }else{
            $content = $this->renderPartial('print_gepg_bill', [
                'model' => $model,
            ]);
        }
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename'=>'The University of Dodoma Bill.pdf',
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
                // 'title' => 'Billing System',
                // 'subject' => 'Udom Billing System',
                // 'keywords' => 'krajee, grid, export, yii2-grid, pdf'
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetTitle' => 'The University of Dodoma bill',
                'SetAuthor' => 'The University of Dodoma',
                'SetCreator' => 'The University of Dodoma',
                'SetKeywords' => 'The University of Dodoma',
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();

    }
   
    public function actionPrintoutnew($id)
    {

        $content = $this->renderPartial('printoutnew', [
            'model' => $this->findModel($id),
        ]);
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
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
             'subject' => 'Udom Billing System',
             'keywords' => 'krajee, grid, export, yii2-grid, pdf'
            ],
            // call mPDF methods on the fly
            'methods' => [
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();

    }

    public function actionTransfer()
    {


        if(Yii::$app->request->isPost){

       $request=Yii::$app->request->post();

        $bill_id=$request['bill_id'];    
        $bank_id=$request['id'];    
        $amount=$request['amount'];    

        $content = $this->renderPartial('gepg_transfer', [
            'model' => $this->findModel($bill_id),
            'amount_in_words'=>$amount,
            'bank'=>GepgBank::findOne($bank_id)
        ]);
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,

            //filename
            'filename'=>'Transfer Form'.date('Y-m-d h-i-s').'.pdf',
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,  
            // stream to browser inline  DEST_BROWSER
            'destination' => Pdf::DEST_DOWNLOAD, 
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
             'subject' => 'Udom Billing System',
             'keywords' => 'krajee, grid, export, yii2-grid, pdf'
            ],
            // call mPDF methods on the fly
            'methods' => [
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
        }

    }





    public function actionSrbill()
    {

       // $data = json_decode(file_get_contents("php://input"));
            
       // return json_encode($data->data);   

       // $this->layout='';    
        try {

            $data = json_decode(file_get_contents("php://input"));
            $model=new TblBilling();

            if($m=TblBilling::find()->where('bill_item_ref=:ref',[':ref'=>trim($data->data->billItermRef)])->andWhere('payment_type_id=:id',[':id'=>27])->andWhere('year_id=:id',[':id'=>4])->one()){
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
                $model->bill_item_ref=trim($data->data->billItermRef);
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



    /**
     * Deletes an existing TblBilling model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if($obj= $this->findModel($id)){
            if($obj->is_posted==1){
                $obj->delete();
            }else{
                Yii::$app->session->setFlash("danger","Bill can not be deleted after being posted");
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblBilling model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblBilling the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblBilling::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
