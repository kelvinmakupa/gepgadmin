<?php

namespace frontend\controllers;

use app\models\Common;
use app\models\TblBilling;
use Yii;
use app\models\TblBillingTemp;
use app\models\BillingTempSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * BillingTempController implements the CRUD actions for TblBillingTemp model.
 */
class BillingTempController extends Controller
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
     * Lists all TblBillingTemp models.
     * @return mixed
     */
    public function actionVerified()
    {
        $searchModel = new BillingTempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tbl_billing_temp.status' => 2]);
        $dataProvider->query->andWhere(['is_deleted'=>1]);

        return $this->render('verified', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all TblBillingTemp models.
     * @return mixed
     */
    public function actionApproved()
    {
        $searchModel = new BillingTempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tbl_billing_temp.status' => 3]);
        $dataProvider->query->andWhere(['is_deleted'=>1]);

        return $this->render('approved', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single TblBillingTemp model.
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

    public function actionVerify($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        if ($model->save()) {
            $contents='Bill was successfully verified';
            Yii::$app->session->setFlash('info', $contents);
            return $this->redirect(['details', 'token' => base64_encode($model->file_uploaded_id)]);
        }

        return $this->redirect(['details', 'token' => base64_encode($model->file_uploaded_id)]);
    }

 public function actionVerifyall($token)
    {
        $file_id=base64_decode($token);
        $model = Yii::$app->db->createCommand("UPDATE tbl_billing_temp  SET status=:bill_status WHERE file_uploaded_id=:file_id AND is_deleted=:is_del");
        $model->bindValue(':bill_status',2);
        $model->bindValue(':is_del',1);
        $model->bindParam(':file_id',$file_id);

        if ($model->execute()) {
            return $this->redirect(['details', 'token' => base64_encode($file_id)]);
        }

        return $this->redirect(['details', 'token' => base64_encode($file_id)]);
    }

    public function actionApprove($id)
    {
        try {
            $model = $this->findModel($id);
            $bill = new TblBilling();

            $bill->payer = $model->payer;
            $bill->sp_system_id = ($model->payer == 3) ? 1 : '';
            $bill->payer_name = $model->payer_name;
            $bill->bill_description = $model->bill_description;
            $bill->bill_amount = $model->bill_amount;
            $bill->bill_exp_date = $model->bill_exp_date;
            $bill->bill_description = $model->bill_description;
            $bill->bill_gen_by = $model->bill_gen_by;
            $bill->bill_appr_by = Common::getOnlineUser();
            $bill->payer_cell_num = $model->payer_cell_num;
            $bill->payer_email = $model->payer_email;
            $bill->bill_currency = $model->bill_currency;
            $bill->payment_type_id = $model->payment_type_id;
            $bill->bill_gen_date = $model->bill_gen_date;
            $bill->bill_id = $model->bill_id;
            $bill->company_id = 0;
            $bill->control_number = $model->control_number;
            $bill->bill_pay_opt = $model->bill_pay_opt;
            $bill->use_on_pay = $model->use_on_pay;
            $bill->bill_eqv_amount = $model->bill_eqv_amount;
            $bill->bill_item_ref = $model->bill_item_ref;
            $bill->is_posted = 1;
            $bill->year_id = $model->year_id;
            $bill->is_cancelled = 1;

            if ($bill->save(false)) {
                $model->bill_id = $bill->id;
                $model->bill_appr_by = Common::getOnlineUser();
                $model->status = 3;
                $model->save(false);
                Yii::$app->session->setFlash('info','Bill was successfully approved and billed');
            }
            return $this->redirect(['verified']);
        } catch (\Exception $e) {
            return $this->redirect(['verified']);
        }
    }

    public function actionApproveall()
    {

        try {
            $data = TblBillingTemp::find()->where(['status' => 2])->andWhere(['is_deleted'=>1])->all();
            $counter=0;
            foreach ($data as $key => $model) {
                $bill = new TblBilling();
                $bill->payer = $model->payer;
                $bill->sp_system_id = ($model->payer == 3) ? 1 : '';
                $bill->payer_name = $model->payer_name;
                $bill->bill_description = $model->bill_description;
                $bill->bill_amount = $model->bill_amount;
                $bill->bill_exp_date = $model->bill_exp_date;
                $bill->bill_description = $model->bill_description;
                $bill->bill_gen_by = $model->bill_gen_by;
                $bill->bill_appr_by = Common::getOnlineUser();
                $bill->payer_cell_num = $model->payer_cell_num;
                $bill->payer_email = $model->payer_email;
                $bill->bill_currency = $model->bill_currency;
                $bill->payment_type_id = $model->payment_type_id;
                $bill->bill_gen_date = $model->bill_gen_date;
                $bill->bill_id = $model->bill_id;
                $bill->company_id = 0;
                $bill->control_number = $model->control_number;
                $bill->bill_pay_opt = $model->bill_pay_opt;
                $bill->use_on_pay = $model->use_on_pay;
                $bill->bill_eqv_amount = $model->bill_eqv_amount;
                $bill->bill_item_ref = $model->bill_item_ref;
                $bill->is_posted = 1;
                $bill->year_id = $model->year_id;
                $bill->is_cancelled = 1;

                if ($bill->save(false)) {
                    $model->bill_id = $bill->id;
                    $model->status = 3;
                    $model->save(false);
                    $counter++;
                }
            }

            return $this->redirect(['verified']);
        } catch (\Exception $e) {
            return $this->redirect(['verified']);
        }
    }


    /**
     * Deletes an existing TblBillingTemp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        if($model->status>2) {
            $model->is_deleted = 2;
            $model->update();
        }else{
            Yii::$app->session->setFlash('info',"Approved bills can't be deleted" );
        }
        return $this->redirect(['details','token'=>base64_encode($model->file_uploaded_id)]);
    }


    /**
     * @return mixed
     */
    public function actionDetails($token)
    {
        $searchModel = new BillingTempSearch();
        $searchModel['file_uploaded_id'] = base64_decode($token);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['is_deleted'=>1]);

        return $this->render('details', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploaded_file_id' => base64_decode($token)
        ]);
    }
    
    /**
     * Finds the TblBillingTemp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblBillingTemp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblBillingTemp::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
