<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role_id
 * @property string $avatar
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{

   public $repeat_password;
   public $current_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'username','surname','password_hash','repeat_password','current_password','sex','email', 'role_id'], 'required'],
            [['role_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name','surname', 'username', 'password_hash', 'password_reset_token', 'email', 'avatar'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            ['username', 'filter', 'filter'=>'strtolower'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
            ['repeat_password', 'compare','compareAttribute'=>'password_hash'],
            [['avatar'], 'file','extensions' => ['jpeg','jpg','png'], 'maxSize' => 1024 * 1024 *2],
        ];
    }


    public function scenarios(){

        $scenarios=parent::scenarios();
        $scenarios['profile']=['current_password','password_hash','repeat_password'];
        $scenarios['reset']=['password_hash'];
        $scenarios['register']=['first_name', 'last_name', 'username','surname','password_hash','sex','email', 'role_id','avatar','status','created_at','updated_at'];
        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Middle Name',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'repeat_password'=>'Repeat Password',
            'current_password'=>'Current Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email Address',
            'role_id' => 'Account Role',
            'avatar' => 'User Image',
            'status' => 'Account Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function uploadImage() {

        $image_link = UploadedFile::getInstance($this, 'avatar');

        return $image_link;
	}

	public static function getAccountStatus($status=1,$flag=false){
        if($flag){
            return array(['id'=>'0', 'name'=>'Inactive'],['id'=>'10', 'name'=>'Active']);
        }
	    return ($status>0)?'Active':'Inactive';
    }

    public static function getUsers($user_id,$flag=true){

        return ($flag)?User::find()->select('id,username')->all():User::find()->where(['id'=>$user_id])->one()->username;
    }


    // public function behaviors()
    // {
    //     return [
    //         'bedezign\yii2\audit\AuditTrailBehavior'
    //     ];
    // }

	
}
