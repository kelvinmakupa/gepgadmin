<?php

namespace frontend\controllers;

use app\models\Common;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         if(Yii::$app->user->identity->role_id==5){
            $dataProvider->query->andWhere('role_id=:id',[':id'=>5]);
         }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario='register';
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$image_link=$model->uploadImage();
		if ($image_link) {
            $filename = Yii::$app->security->generateRandomString() . '.' . $image_link->extension;
            $file_path = '/uploads/' . $filename;
            $path = Yii::getAlias('@web') . $file_path;
            $image_link->saveAs('uploads/' . $filename);
            $model->avatar = $filename;
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
            $model->created_at = time();
            $model->updated_at = time();
            if ($model->save()) {

                return $this->redirect(['view', 'id' => $model->id]);
            }
		}
            return $this->render('create',['model'=>$model,]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


	public function actionProfile(){

		$modelx=new User();
        $modelx->scenario='profile';
        if(!Yii::$app->user->isGuest){
        if ($modelx->load(Yii::$app->request->post())&& $modelx->validate()) {

            if (Yii::$app->security->validatePassword($modelx->current_password,User::find()->where('username=:user',[':user'=>Yii::$app->user->identity->username])->one()->password_hash)){
                $command = Yii::$app->db->createCommand("UPDATE user SET password_hash=:pass WHERE username=:username");
                $command->bindValue(':pass', Yii::$app->security->generatePasswordHash($modelx->password_hash));
                $command->bindValue(':username', Yii::$app->user->identity->username);
            if ($command->execute()) {
                Yii::$app->session->setFlash('success', 'You have successfully update your password');
            } else {
                Yii::$app->session->setFlash('warning', 'The operation was not successfully');
            }
            $mod = new User();
            $mod->scenario = 'profile';
            return $this->render('profile', ['model' => $mod]);
        }else{

//                Yii::$app->security->validatePassword()
                Yii::$app->session->setFlash('warning', User::find()->where('username=:user',[':user'=>Yii::$app->user->identity->username])->one()->password_hash.' Wrong password provided '.$modelx->current_password);
                return $this->render('profile', ['model' => $modelx]);

            }
        }else{
            return $this->render('profile',['model'=>$modelx]);
        }

	}else{
            return $this->render('profile',['model'=>$modelx]);
        }
	}

    public function actionPassword($id)
    {
        $new_password=Common::generatePassword(8);
        $model = $this->findModel($id);
        $model->scenario='reset';
        $model->password_hash=Yii::$app->security->generatePasswordHash($new_password);
        $model->update();
        Yii::$app->session->setFlash("success","Password was successfully updated for user with username ".$model->username.' New Password '.$new_password);
        return $this->redirect(['index']);
    }


    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAuth($id)
    {
        Yii::$app->db->insert('auth_assignment',[
            'user_id'=>$id,
            'created_at'=>time()
        ])->execute();
        return $this->redirect(['assignment/index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
