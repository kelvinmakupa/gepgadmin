<?php

namespace frontend\controllers;

use app\models\GePG;
use Yii;
use app\models\TblReconcilliation;
use app\models\TblReconcilliationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Export;
use app\models\Common;

/**
 * ReconcilliationController implements the CRUD actions for TblReconcilliation model.
 */
class ReconcilliationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TblReconcilliation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblReconcilliationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblReconcilliation model.
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
     * Creates a new TblReconcilliation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblReconcilliation();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $response=GePG::reconciliation($model->recon_opt,$model->trx_date,$model->user_id);

                    if($response->statusCode==200){
                            $model->reconc_id=$response->reconcReqId;
                            $model->save();
                            return $this->redirect(['view', 'id' => $model->id]);
                    }else{
                        $model->trx_date='';
                        $model->recon_opt='';
                        Yii::$app->session->setFlash('danger','The request for reconciliation was not successfully');
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }

        }
        return $this->render('create', [
        'model' => $model,
    ]);


    }

    
    public function actionDownload(){
        $file_name=base64_decode(Yii::$app->request->get('token'));
        $path=Yii::$app->basePath.'/web/recon_files/'.$file_name;
        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        } else {
            throw new \yii\web\NotFoundHttpException("{$path} is not found!");
        }

    }
    
    
    
    /**
     * Updates an existing TblReconcilliation model.
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
     * Deletes an existing TblReconcilliation model.
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
     * Finds the TblReconcilliation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblReconcilliation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblReconcilliation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
