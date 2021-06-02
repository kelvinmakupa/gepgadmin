<?php

namespace frontend\controllers;

use Yii;
use app\models\BankerPayment;
use app\models\BankerPaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BankerPaymentController implements the CRUD actions for BankerPayment model.
 */
class BankerpController extends Controller
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
                        $route              = $module=="app-frontend"?$action."-".\frontend\components\Inflect::singularize($controller)."":$module."-".$action."-".\frontend\components\Inflect::singularize($controller);
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
     * Lists all BankerPayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BankerPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BankerPayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BankerPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BankerPayment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BankerPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BankerPayment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BankerPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BankerPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BankerPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
