<?php

namespace frontend\controllers;

use app\models\Common;
use app\models\TblBillingTemp;
use Yii;
use app\models\TblFileUploaded;
use app\models\FileUploadedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use app\models\Export;

/**
 * FileUploaderController implements the CRUD actions for TblFileUploaded model.
 */
class FileUploaderController extends Controller
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
                'delete' => ['post'],
                'delete-multiple' => ['post'],
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
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {

                        $module             = Yii::$app->controller->module->id;
                        $action             = Yii::$app->controller->action->id;
                        $controller         = Yii::$app->controller->id;
                        $route              = $action."-".\frontend\components\Inflect::singularize($controller);
                        $post = Yii::$app->request->post();

                        if (\Yii::$app->user->can($route)) {
                            return true;
                        }
                    }
                ],
            ],
        ];

        return $behaviors;

    }

    /**
     * Lists all TblFileUploaded models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileUploadedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['id' => SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblFileUploaded model.
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
     * Creates a new TblFileUploaded model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblFileUploaded();
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {

            $model->file_import = UploadedFile::getInstance($model, 'file_import');

            if ($model->validate()) {

                $file_name = $model->file_import->baseName . '_' . date('Y-m-d_H_i_s') . '.' . $model->file_import->extension;

                $inputFileName = Yii::$app->basePath . '/web/uploads/documents/uploaded_bills/' . $file_name;

                $model->file_import->saveAs($inputFileName);

                $inputFileType = IOFactory::identify($inputFileName);
                $reader = IOFactory::createReader($inputFileType);
                $spreadsheet = $reader->load($inputFileName);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(true, true, true, true, true, true, true, true, true, true);

                $row = 0;
                $counter = 1;
                $fail_counter = 0;
                $success_counter = 0;
                $uploads = array();
                $upload_data=array();


                $model->file_name = $file_name;

                $model->save(false);


                foreach ($sheetData as $data) {
                    if ($row == 0) {

                        if (!TblFileUploaded::checkHeader($data)) {

                            $model->addError('file_import', 'Invalid Bulk bill template file');
                            return $this->render('create', [
                                'model' => $model,
                            ]);
                        }
                    } else {

                        $payer_name = trim($data['A']);
                        $registration_no = trim($data['B']);
                        $bill_description = trim($data['C']);
                        $bill_amount = floatval(trim($data['D']));

                        $billingTemp = new TblBillingTemp();
                        $billingTemp->file_uploaded_id = $model->id;
                        $billingTemp->sp_system_id = ($model['payer'] == 3) ? 1 : null;
                        $billingTemp->payer = $model['payer'];
                        $billingTemp->payer_name = $payer_name;
                        $billingTemp->bill_description = $bill_description;
                        $billingTemp->bill_amount = $bill_amount;
                        $billingTemp->payer_cell_num = '';
                        $billingTemp->payer_email = '';
                        $billingTemp->bill_currency = $model['bill_currency'];
                        $billingTemp->bill_eqv_amount = ($model['bill_currency'] == 'TZS') ? $bill_amount : Common::convertCurrency($bill_amount);
                        $billingTemp->payment_type_id = $model['payment_type'];
                        $billingTemp->bill_pay_opt = $model['payment_option'];
                        $billingTemp->bill_item_ref = ($model['payer'] == 3) ? $registration_no : Common::getBillItemRef();
                        $billingTemp->use_on_pay = 'N';
                        $billingTemp->bill_id = '';
                        $billingTemp->status = 1;
                        $billingTemp->year_id = $model['academic_year'];
                        $billingTemp->control_number = '';
                        $billingTemp->bill_gen_by = Common::getOnlineUser();
                        $billingTemp->bill_appr_by = null;
                        $billingTemp->bill_exp_date = Common::getStandardTime($model['bill_expire_date']);
                        $billingTemp->bill_gen_date = Common::getStandardTime(date('Y-m-d H:i:s'));

                      // $response= json_decode(Common::fetchStudentDetails($billingTemp->bill_item_ref));

                        //print_r($response->statusCode);
                        if($model['payer'] == 3){

                            //if($response->statusCode==200){
                            if(true){
                            if ($billingTemp->save(false)) {
                                $success_counter++;

                                array_push($upload_data,[
                                    'payer_name'=>trim($data['A']),
                                    'registration_no' => trim($data['B']),
                                    'bill_description' => trim($data['C']),
                                    'bill_amount' => floatval(trim($data['D'])),
                                    'status'=>'Sucessful'
                                ]);
                            } else {
                                $fail_counter++;

                                array_push($upload_data,[
                                    'payer_name'=>trim($data['A']),
                                    'registration_no' => trim($data['B']),
                                    'bill_description' => trim($data['C']),
                                    'bill_amount' => floatval(trim($data['D'])),
                                    'status'=>'Failed'
                                ]);
                            }}else{

                                array_push($upload_data,[
                                    'payer_name'=>trim($data['A']),
                                    'registration_no' => trim($data['B']),
                                    'bill_description' => trim($data['C']),
                                    'bill_amount' => floatval(trim($data['D'])),
                                    'status'=>'Invalid Registration number'
                                ]);
                            }
                        }else{
                        if ($billingTemp->save(false)) {
                            $success_counter++;
                            array_push($upload_data,[
                                'payer_name'=>trim($data['A']),
                                'registration_no' => trim($data['B']),
                                'bill_description' => trim($data['C']),
                                'bill_amount' => floatval(trim($data['D'])),
                                'status'=>'Sucessful'
                            ]);
                        } else {
                            $fail_counter++;

                            array_push($upload_data,[
                                'payer_name'=>trim($data['A']),
                                'registration_no' => trim($data['B']),
                                'bill_description' => trim($data['C']),
                                'bill_amount' => floatval(trim($data['D'])),
                                'status'=>'Failed'
                            ]);
                        }

                        }

                    }
                    $row++;
                    $counter++;
                }

                $contents = 'File was uploaded with successful entries : ' . $success_counter . ' and failed entries : ' . $fail_counter;
                Yii::$app->session->setFlash('info', $contents);

//                $export=new Export();
//                $export->uploadedData($upload_data);
//                $export->saveFile($model->file_import->name);

                return $this->render('create', [
                    'model' => new TblFileUploaded(),
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);


    }

    /**
     * Updates an existing TblFileUploaded model.
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

    /**
     * @param $token
     * @return mixed
     */
    public function actionDownload($token)
    {


        Yii::$app->db->createCommand("UPDATE tbl_billing_temp temp INNER JOIN tbl_billing b ON b.id=temp.bill_id SET temp.control_number=b.control_number")->execute();

        $query = Yii::$app->db->createCommand("SELECT te.bill_gen_date,te.bill_exp_date,te.bill_pay_opt, ptype.acc_description payment_type,te.payer_name,te.bill_gen_by,te.bill_appr_by,te.bill_item_ref   ,te.bill_description,te.bill_amount,te.bill_currency,te.control_number FROM tbl_file_uploaded fu 
                        INNER JOIN tbl_billing_temp te ON fu.id=te.file_uploaded_id
                        INNER JOIN tbl_payment_types ptype ON ptype.id=te.payment_type_id
                        WHERE fu.id=:file_id");
        $query->bindValue(':file_id',base64_decode($token));
        $data=$query->queryAll();

        $obj = new Export();
        $obj->uploadedBills($data);

        $obj->downloadBills('uploaded_bills_'.date('Y_m_d_H_i_s').'.xls');

    }


    /**
     * Deletes an existing TblFileUploaded model.
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

    /**
     * Finds the TblFileUploaded model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblFileUploaded the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblFileUploaded::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
