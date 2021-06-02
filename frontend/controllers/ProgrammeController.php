<?php

namespace frontend\controllers;


use Yii;
use app\models\Programmes;
use app\models\ProgrammesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProgrammeController implements the CRUD actions for Programmes model.
 */
class ProgrammeController extends Controller
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
                        $route              = $module=="app-frontend"?$action."-".$controller:$module."-".$action."-".\frontend\components\Inflect::singularize($controller);
                        $post = Yii::$app->request->post();
                        //print_r($controller);
                        //exit;
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
     * Lists all Programmes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProgrammesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere('level<:level',[':level'=>'4']);
        $dataProvider->query->andWhere('status=:sts',[':sts'=>'1']);

        $dataProvider->pagination=array('pageSize'=>50);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionList()
    {
        $searchModel = new ProgrammesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionProgrammelist($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'programme_name' => '']];
        if (!is_null($q)) {
            $query = new yii\db\Query;
            $query->select('program_id as id, programme_name AS text')
                ->from('programmes')
                ->where(['like', 'programme_name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'programme_name' => Programmes::find($id)->programme_name];
        }
        return $out;
    }



    public function actionCriteria($id)
    {
        $model=new GeneralSetting();
        $subject=new RequiredSubjects();
        $subject_group=new SubjectGroup();
        $group_setting=new GroupSetting();
        $groups=new Groups();
        return $this->render('criteria',['program'=>$this->findModel($id),'general'=>$model,
            'subject'=>$subject,'groups'=>$groups,'subject_group'=>$subject_group,'group_setting'=>$group_setting]);
       /* return $this->render('criteria', [
            'model' => $this->findModel($id),
        ]);*/

    }

    public function actionGen()
    {
        $model = new GeneralSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->renderAjax('general_setting');
        } else {
            return $this->renderAjax('general_setting', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Displays a single Programmes model.
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
     * Creates a new Programmes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Programmes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

	
	
	public function actionLists($code)
    {
		
		//print("<script>alert('ok');</script>");
		//exit;
        $countPosts = Programmes::find()->count();
 
        $posts = Programmes::find()
                ->where(['code' => $code])
                ->orderBy('id DESC')
                ->all();
 
        if($countPosts>0){
            foreach($posts as $post){
                echo "<option value='".$post->code."'>".$post->programme_name."</option>";
            }
        }
        else{
            echo "<option>-</option>";
        }
 
    }
	
	
    /**
     * Updates an existing Programmes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario='update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Programmes model.
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
     * Finds the Programmes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Programmes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Programmes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
