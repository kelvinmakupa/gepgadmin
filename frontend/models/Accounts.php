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
class Accounts extends \yii\db\ActiveRecord
{
/**
	* @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
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
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['user_id'], 'unique'],
			['password_hash', 'validatePass'],
            [['index_number'], 'unique'],
        ];
    }
	
    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    
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
