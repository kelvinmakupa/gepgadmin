<?php

namespace frontend\controllers;

use Yii;
use app\models\MenuPanel;
use app\models\MenuPanelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenupanelController implements the CRUD actions for MenuPanel model.
 */
class MenupanelController extends Controller
{


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
                        $route              = $module=="payment"?$action."-".\frontend\components\Inflect::singularize($controller)."":$action."-".\frontend\components\Inflect::singularize($controller);
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
     * Lists all MenuPanel models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!\Yii::$app->user->isGuest) {
            $searchModel = new MenuPanelSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            Yii::$app->user->logout();

            return $this->goHome();

        }
    }

    /**
     * Displays a single MenuPanel model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            Yii::$app->user->logout();

            return $this->goHome();
        }
    }

    /**
     * Creates a new MenuPanel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!\Yii::$app->user->isGuest) {
            $model = new MenuPanel();

            if ($model->load(Yii::$app->request->post())) {
               // $model->role_id=Yii::$app->user->identity->id;
                if($model->parent_id==null){
					$model->parent_id='0';
				}
				$model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }else{
            Yii::$app->user->logout();

            return $this->goHome();
        }
    }

    /**
     * Updates an existing MenuPanel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!\Yii::$app->user->isGuest) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else{
            Yii::$app->user->logout();

            return $this->goHome();
        }
    }

    /**
     * Deletes an existing MenuPanel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!\Yii::$app->user->isGuest) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            Yii::$app->user->logout();

            return $this->goHome();
        }
    }

    /**
     * Finds the MenuPanel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MenuPanel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (!\Yii::$app->user->isGuest) {
            if (($model = MenuPanel::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }else{
            Yii::$app->user->logout();

            return $this->goHome();
        }
    }
}
