<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['first_name', 'last_name', 'gender', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'index_number', 'phone', 'email', 'role_id', 'user_id', 'status', 'avatar', 'created_at', 'updated_at'], 'required'],
            [['gender'], 'string'],
            [['first_name', 'last_name', 'username', 'email', 'created_at'], 'string', 'max' => 250],
            [['auth_key', 'password_hash', 'password_reset_token', 'avatar'], 'string', 'max' => 255],
            [['index_number'], 'string', 'max' => 25],
            [['phone', 'updated_at'], 'string', 'max' => 30],
            [['role_id'], 'string', 'max' => 50],
            [['user_id'], 'string', 'max' => 150],
            [['status'], 'string', 'max' => 4],
          //  [['username'], 'unique'],
            [['email'], 'unique'],
            [['user_id'], 'unique'],
			['password_hash', 'validatePass'],
            [['index_number'], 'unique'],
        ];
    }

	
	public function validatePass($attribute, $params)
    {
        if (!$this->hasErrors()) {
		//	print(' Has no error pass');
		    $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password_hash)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

	public function attributeLabels(){
		
		return [
		
			'id'=>'ID',
			'username'=>'Username',
			'auth_key'=>'Auth Key',
			'password_hash'=>'Password Hash',
			'password_reset_token'=>'Password Reset Token',
			'first_name'=>'First Name',
			'last_name'=>'Last Name',
			'gender'=>'Gender',
			'index_number'=>'Index Number',
			'phone'=>'Phone Number',
			'email'=>'Email Address',
			'role'=>'Role',
			'user_id'=>'User ID',
			'created_at'=>'Created At',
			'updated_at'=>'Updated At',
			'status'=>'Status',
		];
			
	}
	
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


	
	}
