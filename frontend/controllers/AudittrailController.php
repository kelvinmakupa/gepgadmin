<?php

namespace frontend\controllers;

use Yii;
use app\models\AuditTrail;
use app\models\AuditTrailSearch;
use yii\web\Controller;
use app\models\Export;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AudittrailController implements the CRUD actions for AuditTrail model.
 */
class AudittrailController extends Controller
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
                        $route              = $module=="app-frontend"?$action."-".\frontend\components\Inflect::singularize($controller)."":$action."-".\frontend\components\Inflect::singularize($controller);
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
     * Lists all AuditTrail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuditTrailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuditTrail model.
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
     * Creates a new AuditTrail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuditTrail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    public function actionReport(){

        $model = new AuditTrail();
        $model->scenario='report';
        if($model->load(Yii::$app->request->post())&&$model->validate()){

            $start_date=$model->start_date;
            $end_date=$model->end_date;
            $user_id=$model->user_id;

            $data=Yii::$app->db->createCommand("SELECT first_name,last_name,surname,ip,request_method,route,action,model,model_id,field,old_value,new_value,ae.created 
                                                FROM audit_entry ae 
                                                INNER JOIN audit_trail au ON ae.id=au.entry_id
                                                INNER JOIN user u ON u.id=au.user_id 
                                                WHERE UNIX_TIMESTAMP(DATE( au.created )) <= UNIX_TIMESTAMP(DATE( '{$end_date}' )) 
                                                AND UNIX_TIMESTAMP(DATE( au.created )) >= UNIX_TIMESTAMP(DATE( '{$start_date}' )) AND au.user_id='{$user_id}'
                                            
                                                order by au.created asc")->queryAll();

            if(count($data)>0) {

                $obj = new Export();
                $obj->auditTrailReport($data, $start_date, $end_date);
                $obj->downloadBills('audittrail_'.date('Y_m_d_H_i_s').'.xls');
            }else{
                Yii::$app->session->setFlash('info','Notice! No data found between '.$start_date.' and '.$end_date);

                return $this->render('report', ['model' => $model]);
            }

        }else {

            return $this->render('report', ['model' => $model]);
        }



    }




    /**
     * Updates an existing AuditTrail model.
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
     * Deletes an existing AuditTrail model.
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
     * Finds the AuditTrail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuditTrail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuditTrail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
