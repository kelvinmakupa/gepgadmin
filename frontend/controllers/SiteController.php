<?php

namespace frontend\controllers;

use Yii;
use app\models\AcademicYear;
use app\models\Capplication;
use app\models\ProgrammesSearch;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\Certificates;
use app\models\CertificatesSearch;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use app\models\Accounts;
use app\models\Signup;
use app\models\Login;
use frontend\models\ContactForm;
use yii\helpers\Json;
use yii\helpers\Console;
use app\models\OASMODEL;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $message;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'contactus'],
                'rules' => [
                    [
                        'actions' => ['register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['graduate'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['programmes'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['forgot'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                //'class' => 'mdm\captcha\CaptchaAction',
                //'level' => 1, // avaliable level are 1,2,3 :D
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(Yii::$app->urlManager->createUrl('site/dashboard'));
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {

        $this->layout = 'non_auth_layout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $data = Yii::$app->request->get();
        $flag = false;
        $username = '';
        if (isset($data['uid'])) {
            $email = base64_decode($data['uid']);
            if ($m = Signup::find()->where(['email' => $email])->andWhere(['status' => '0'])->one()) {
                $username = $m->username;
                $m->status = '10';
                if ($m->save(false)) {
                    $flag = true;
                }

            }
        }

        $model = new Login();
        $model->scenario = 'auth';
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goHome();
        } else {
            if ($flag) {
                $model->username = $username;
                Yii::$app->session->setFlash('success', 'You have successfully activated your account.');
            }
             return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionActivate()
    {

        $data = Yii::$app->request->get();
        $email = base64_decode($data['uid']);
        /* $m=Accounts::find()->where(['username'=>$email])->one();
         $m->status='10';
         $m->update();
         print_r(base64_decode($data['uid']));
        */
        Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');

        $this->redirect(array("site/login"));

    }


    public function actionProgrammes()
    {

        $this->layout = 'main-programmes';
        $searchModel = new ProgrammesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('programmes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        //   return $this->render('programmes');
    }
public function actionApply()
    {

        $this->layout = 'non_auth_layout';

        return $this->render('apply');
    }

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


    public function actionWelcome()
    {
        $this->layout = 'non_auth_layout';
        return $this->render('welcome');
    }


    public function actionTabs() {
      // $html = $this->renderPartial('welcome');
       $searchModel = new CertificatesSearch();
        $model=new Certificates();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['user_id'=>(Yii::$app->user->isGuest)?'':Yii::$app->user->identity->user_id]);
       $html= $this->render('create1',['model'=>$model,'dataProvider'=>$dataProvider]);

        return Json::encode($html);
    }


    public function actionCreate1()
    {


        $model = new Certificates();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $image_link=$model->uploadImage();
            $req=Yii::$app->request->post();
            //print_r(end(explode('.',$image_link)));
            if ($image_link <> false) {
                if($model->certificate_name=='Bank Slip'){
                    if(!Certificates::find()->where(['user_id'=>Yii::$app->user->identity->user_id])->andWhere(['certificate_name'=>'Bank Slip'])->one()){
                        $file_path='attachment/'.Yii::$app->security->generateRandomString().'.'.end(explode('.',$image_link));
                        $path = Yii::$app->basePath.'/web/'.$file_path;
                        $image_link->saveAs($path);
                        $model->user_id=Yii::$app->user->identity->user_id;
                        $model->certificate_name=$model->certificate_name;
                        $model->image_url=$file_path;
                        $model->save();
                    }else{
                        return $this->redirect('index');
                    }
                }else{
                    $file_path='attachment/'.Yii::$app->security->generateRandomString().'.'.end(explode('.',$image_link));
                    $path = Yii::$app->basePath.'/web/'.$file_path;
                    $image_link->saveAs($path);
                    $model->user_id=Yii::$app->user->identity->user_id;
                    $model->certificate_name=$model->certificate_name;
                    $model->image_url=$file_path;
                    $model->insert();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                $model->addError('image_url','Please select certificate to Upload require(pdf,jpg,jp)');
                return $this->render('create',['model'=>$model,]);
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            $searchModel = new CertificatesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('create1', [
                'model' => $model,'dataProvider'=>$dataProvider]);
        }
    }


    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionContactus()
    {
        $this->layout = 'non_auth_layout';
        return $this->render('contactus');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionRegister()
    {
	
        $this->layout = 'non_auth_layout';
        $model = new Signup();
        $model->scenario = 'register';
     
		
	 if ($model->load(Yii::$app->request->post())&& $model->validate()){	//&& $model->validate()){
			
		    $number = Capplication::find()->where(['academic_year' => AcademicYear::find()->where(['status' => '1'])->one()->academic_year])->andWhere(['status' => '1'])->one()->reg_number;
            $initial = '';
            $user = $number + 1;
            $choice = strlen($user);
            switch ($choice) {
                case 1:
                    $initial = "0000";
                    break;
                case 2:
                    $initial = "000";
                    break;
                case 3:
                    $initial = "00";
                    break;
                case 4:
                    $initial = "0";
                    break;
                case 5:

                case 6:

                default:
                    break;
            }

            $user_id = "A/UDOM/" . date('Y') . "/" . $initial . $user;
            $model->user_id = $user_id;
            $model->created_at = strval(time());
            $model->updated_at = strval(time());
            $model->status = '10';
            $model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
            $model->auth_key = Yii::$app->security->generateRandomString();
            $pass = $model->password_hash;
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            try {

                if ($model->save(false)) {

                    OASMODEL::setAuthAssignment($model->role_id,$model->id);
                    //Yii::$app->db->createCommand("insert into auth_assignment values('" . AccountRole::getRole($model->role_id) . "','" . $model->id . "'," . time() . ")")->execute();
                    OASMODEL::updateRegCount($user);
                    //Yii::$app->db->createCommand("update capplication set reg_number='" . $user . "' where status='1' and academic_year='" . AcademicYear::find()->where(['status' => '1'])->one()->academic_year . "'")->execute();

                    $model1 = new Login();
                    $model1->scenario='auth';
                    $model1->username=$model->username;
                    $model1->password_hash=$pass;
                if ($model1->login()) {
                    Yii::$app->getSession()->setFlash('success','Welcome to University of Dodoma Online Application System');
                    return $this->goHome();
                } else {
                    Yii::$app->getSession()->setFlash('success','You have successfully registered');
                    return $this->render('login', [
                        'model' => $model,
                    ]);
                }
					/*
							   $obj = Yii::$app->mailer->compose()
					                        ->setFrom('udom.oas2017@gmail.com')
					                        ->setTo($model->email)
					                        ->setSubject('The University of Dododoma Online Application System')
					                        ->setTextBody("Dear " . $model->first_name . ' ' . $model->last_name . "\n Welcome to The University of Dodoma Online Admission System ,\n In order to continue with your application you have to activate your account, please click the link below to activate your account \n" . $url);

					                    if ($obj->send()) {
					                        $mod = new Signup();
					                        $mod->scenario = 'register';
					                        Yii::$app->getSession()->setFlash('success', 'Activation link has already been sent to your email account');
					                        return $this->render('register', ['model' => $mod,]);
					                    } else {
					                        Yii::$app->getSession()->setFlash('success', 'Operation was not successfully');
					                        return $this->render('register', ['model' => $model,]);
					                    }
					*/

                } else {

                    $model->password_hash = '';
                    $model->password_repeat = '';
                    return $this->render('register', ['model' => $model,]);
                }
            } catch (\Exception $e) {
                // print_r($e);
                $mod = new Signup();
                $mod->scenario = 'register';
              //  Yii::$app->getSession()->setFlash('success', 'Demo '.$e->getMessage());
                // echo $e;
                return $this->render('register', ['model' => $mod,]);
            }
        } else {

            return $this->render('register', ['model' => $model,]);
        }

    }


    public function generatePassword($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function actionForgot()
    {
        $this->layout = 'non_auth_layout';
        $model = new Accounts();
        $model->scenario = 'recover';
        if ($model->load(Yii::$app->request->post())) {
            $newpass = $this->generatePassword();
            if ($recover = Accounts::find()->where(['email' => $model->email])->one()) {
                $url = Yii::$app->urlManager->createAbsoluteUrl(['site/recover', 'auth_key' => $recover->auth_key, 'tm' => base64_encode(time()), 'el' => base64_encode($recover->email)]);

                try {
                    echo $url;
//						$obj = Yii::$app->mailer->compose()
//                        ->setFrom('oas@udom.ac.tz')
//                        ->setTo($recover->email)
//                        ->setSubject('Recover Password')
//                        ->setTextBody("Please click the link " . $url . " to recover your password");
//                    if ($obj->send()) {
//                        Yii::$app->getSession()->setFlash('success', 'The link for password reset has already been sent to your email');
//                        return $this->render('forgot', ['model' => $model,]);
//                    } else {
//                        $model->addError('email', 'Sorry! Process failed, try again later ');
//                        return $this->render('forgot', ['model' => $model,]);
//                    }
                } catch (Exception $e) {

                    Yii::$app->session->setFlash('info', 'Process was not successful,please try again later ');
                    //return $this->render('forgot', ['model' => $model,]);
                }
            } else {
                Yii::$app->session->setFlash('warning', 'Sorry! Email address was not found');
                return $this->render('forgot', ['model' => $model,]);
            }
        } else {
		
			
            return $this->render('forgot', ['model' => $model,]);
        }

    }


    public function actionRecover()
    {
        $this->layout = 'non_auth_layout';
        $model = new Accounts();
        $model->scenario = 'forgot';
        if ($model->load(Yii::$app->request->post())&$model->validate()) {
            $data = Yii::$app->request->post();
            $model2 = Accounts::find()->where(['email' => $data['Accounts']['email']])->one();
            if ($data['Accounts']['password_hash'] <> $data['rpassword']) {
                Yii::$app->session->setFlash('error','Password and Retyped Password must match');
                return $this->render('recover', ['model' => $model, 'model2' => $model2]);
            } else {
                if (Accounts::resetPassword($data['Accounts']['email'], $data['Accounts']['password_hash'])) {
                    Yii::$app->session->setFlash('success','Your have successfully reset your password');
                    return $this->render('recover', ['model' => $model, 'model2' => $model2]);
                } else {
                    Yii::$app->session->setFlash('error','Operation failed, Please try again later');
                    return $this->render('recover', ['model' => $model, 'model2' => $model2]);
                }
            }
        } else {
            $data = Yii::$app->request->get();
            if ($this->getDiff($data['tm'])) {
                if ($model2 = Accounts::find()->where(['email' => base64_decode($data['el'])])->one()) {
                    //  print_r($model2);
                    return $this->render('recover', ['model' => $model, 'model2' => $model2]);
                } else {
                    return $this->render('forgot', ['model' => $model,]);
                }
            } else {
                return $this->render('forgot', ['model' => $model,]);
            }
        }

    }

    public function actionSubcat()
    {
        $out = array();
        if (isset($_GET['code'])) {
            $cat_id = $_GET['code'];
            $list = \app\models\Programmes::find()->select('code,programme_name')->where(['<>', 'code', $cat_id])->all();

            $selected = null;
            if (count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['code' => $account['code'], 'name' => $account['programme_name']];
                    // $out[$i] = [$account['programmes']];
                    if ($i == 0) {
                        $selected = $account['code'];
                    }
                }
            }
            //ArrayHelper::map($list,'code','programme_name')
            print_r($out);
            print("<br/>");
            print("<br/>");
            print("<br/>");
            print_r(json_encode($out));

        }
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $parent = $parents[0];

                // $out = self::getSubCatList($cat_id);
                //$out = \yii\helpers\ArrayHelper::map(\app\models\Programmes::find()->where(['<>','code',$cat_id])->all(),'code','programme_name');
// the getSubCatList function will query the database based on the
// cat_id and return an array like below:
// [
// ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
// ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
// ]            print("<script>alert('Yes');</script>");
                $list = null;
                if (empty($parents[1])) {
                    $list = \app\models\Programmes::find()->select('code,programme_name')->where(['=', 'level', $parent])->all();
                } else {
                    if (empty($parents[2])) {
                        $list = \app\models\Programmes::find()->select('code,programme_name')->where(['=', 'level', $parent])->all();

                    } else {
                        $list = \app\models\Programmes::find()->select('code,programme_name')->where(['=', 'level', $parent])->all();
                    }
                }

                $selected = null;
                if (count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[$i] = ['id' => $account['code'], 'name' => $account['programme_name']];
                        if ($i == 0) {
                            $selected = $account['code'];
                        }
                    }
                }

                // out[]=\yii\helpers\ArrayHelper::map(\app\models\Programmes::find()->where(['<>','code',$cat_id])->all(),'code','programme_name');
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionFirst()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $parent = $parents[0];

                $list = null;
                if (empty($parents[1])) {
                    $list = \app\models\Programmes::find()->select('code,programme_name')->where(['=', 'level', $parent])->andWhere(['status' => '1'])->all();
                } else {
                    if (empty($parents[2])) {
                        $code = $parents[1];
                        if (($parent <= 3) && !empty($code)) {
                            $list = \app\models\Programmes::find()->select('code,programme_name')->where(['level' => $parent])->andWhere(['<>', 'code', $code])->andWhere(['status' => '1'])->all();
                        }
                    } else {
                        $code = $parents[1];
                        $code2 = $parents[2];
                        if (($parent <= 3) && !empty($code) && !empty($code2)) {
                            $list = \app\models\Programmes::find()->select('code,programme_name')->where(['level' => $parent])->andWhere(['<>', 'code', $code])->andWhere(['<>', 'code', $code2])->andWhere(['status' => '1'])->all();
                        }
                    }
                }
                $selected = null;
                if (count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['code'], 'name' => $account['programme_name']];
                        if ($i == 0) {
                            $selected = $account['code'];
                        }
                    }
                }


                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionSecond()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $parent = $parents[0];

                $list = null;
                       if (!empty($parents[1])) {
                           $code = $parents[1];
                           if (($parent <= 3) && !empty($code)) {
                               $list = \app\models\Programmes::find()->select('code,programme_name')->where(['level' => $parent])->andWhere(['<>', 'code', $code])->andWhere(['status' => '1'])->all();
                           }
                    }

                $selected = null;
                if (count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['code'], 'name' => $account['programme_name']];
                        if ($i == 0) {
                            $selected = $account['code'];
                        }
                    }
                }


                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

 public function actionThird()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $parent = $parents[0];

                $list = null;
                if (!empty($parents[2])) {
                        $code = $parents[1];
                        $code2 = $parents[2];
                        if (($parent <= 3) && !empty($code) && !empty($code2)) {
                            $list = \app\models\Programmes::find()->select('code,programme_name')->where(['level' => $parent])->andWhere(['<>', 'code', $code])->andWhere(['<>', 'code', $code2])->andWhere(['status' => '1'])->all();
                        }
                    }

                $selected = null;
                if (count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['code'], 'name' => $account['programme_name']];
                        if ($i == 0) {
                            $selected = $account['code'];
                        }
                    }
                }


                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
 public function actionFourth()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $parent = $parents[0];

                $list = null;
                if (!empty($parents[3])) {
                        $code = $parents[1];
                        $code2 = $parents[2];
                        $code3 = $parents[3];
                        if (($parent <= 3) && !empty($code) && !empty($code2)&& !empty($code3)){
                            $list = \app\models\Programmes::find()->select('code,programme_name')->where(['level' => $parent])->andWhere(['<>', 'code', $code])->andWhere(['<>', 'code', $code2])->andWhere(['<>', 'code', $code3])->andWhere(['status' => '1'])->all();
                        }
                    }

                $selected = null;
                if (count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['code'], 'name' => $account['programme_name']];
                        if ($i == 0) {
                            $selected = $account['code'];
                        }
                    }
                }


                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
public function actionFifth()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $parent = $parents[0];

                $list = null;
                if (!empty($parents[4])) {
                        $code = $parents[1];
                        $code2 = $parents[2];
                        $code3 = $parents[3];
                        $code4 = $parents[4];
                        if (($parent <= 3) && !empty($code) && !empty($code2)&& !empty($code3)&&!empty($code4)){
                            $list = \app\models\Programmes::find()->select('code,programme_name')->where(['level' => $parent])->andWhere(['<>', 'code', $code])->andWhere(['<>', 'code', $code2])->andWhere(['<>', 'code', $code3])->andWhere(['<>', 'code', $code4])->andWhere(['status' => '1'])->all();
                        }
                    }

                $selected = null;
                if (count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['code'], 'name' => $account['programme_name']];
                        if ($i == 0) {
                            $selected = $account['code'];
                        }
                    }
                }


                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function getDiff($date)
    {
        $flag = false;
        $datediff = time() - base64_decode($date);
        if (floor($datediff / (60 * 60 * 24)) <= 1) {
            $flag = true;
        }

        return $flag;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
