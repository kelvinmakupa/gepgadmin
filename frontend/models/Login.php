<?php

namespace app\models;
use Yii;
use common\models\User;
/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $index_number
 * @property string $phone
 * @property string $email
 * @property string $role_id
 * @property string $user_id
 * @property string $status
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 */
class Login extends \yii\db\ActiveRecord
{

    public $username;
    public $password_hash;
    public $rememberMe = true;

    private $_user;
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
            [['first_name', 'last_name', 'username', 'auth_key', 'password_hash', 'email', 'role_id', 'avatar', 'created_at', 'updated_at'], 'required'],
            [['role_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'username', 'password_hash', 'password_reset_token', 'email', 'avatar'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            //     [['username'], 'unique'],
            [['email'], 'unique'],
            ['password_hash','validatePass'],
            [['password_reset_token'], 'unique'],
        ];
    }

    public function scenarios(){

        $scenarios=parent::scenarios();
        $scenarios['auth']=['username','password_hash'];
        return $scenarios;
    }



    public function validatePass($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password_hash)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {

        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);

        } else {
            return false;
        }

    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }





    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'index_number' => 'Index Number',
            'phone' => 'Phone',
            'email' => 'Email',
            'role_id' => 'Role ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'avatar' => 'Avatar',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
