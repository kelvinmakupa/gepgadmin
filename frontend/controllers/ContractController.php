<?php

namespace frontend\controllers;

use app\models\Query;
use app\models\TblContract;
use app\models\TblContractSearch;
use app\models\TblContractType;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ContractController implements the CRUD actions for TblContract model.
 */
class ContractController extends Controller
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
     * Lists all TblContract models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblContractSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblContract model.
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

    public function actionCreate()
    {
        $model = new TblContract();

        if (count(Query::getMaxContractValue()['max_value']) > 0) {
            $maxValue = Query::getMaxContractValue()['max_value'];
        } else {
            $maxValue = count(Query::getMaxContractValue()['max_value']);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->file_upload = UploadedFile::getInstance($model, 'file_upload');

            $contractType = TblContractType::findOne($model->contract_type_id);

            $contractTypeShortname = $contractType->short_name;

            $inst_shortname = 'UDOM';

            if ($model->file_upload) {

                $file_name = Yii::$app->security->generateRandomString() . '_' . time() . '.' . $model->file_upload->extension;

                $ContractFilePath = Yii::$app->basePath . '/web/uploads/documents/contracts/' . $file_name;

                $model->contract_no = Query::getContractNo($maxValue, $contractTypeShortname, $inst_shortname)['contract_no'];
                $model->attachment = $file_name;
                $model->created_by = Yii::$app->user->identity->id;

                if ($model->save()) {

                    $model->file_upload->saveAs($ContractFilePath);
                    Yii::$app->session->setFlash('success', 'Successfully registered');
                    return $this->redirect('index');

                }

            } else {
                Yii::$app->session->setFlash('error', 'Please attach file');
                return $this->redirect('create');
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblContract model.
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
     * Deletes an existing TblContract model.
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
     * Finds the TblContract model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblContract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblContract::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
