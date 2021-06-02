<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_account".
 *
 * @property integer $account_id
 * @property string $username
 * @property string $password
 * @property integer $owner
 * @property string $first_name
 * @property string $middle_name
 * @property string $surname
 * @property string $gender
 * @property integer $status
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'owner', 'first_name', 'middle_name', 'surname', 'gender'], 'required'],
            [['owner', 'status'], 'integer'],
            [['gender'], 'string'],
            [['username', 'first_name', 'middle_name', 'surname'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'username' => 'Username',
            'password' => 'Password',
            'owner' => 'Owner',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'surname' => 'Surname',
            'gender' => 'Gender',
            'status' => 'Status',
        ];
    }


    public static function getName($account_id,$level){

        $response='';
        switch($level){

            case 1:
                $response=($mo=Account::find()->where(['account_id'=>$account_id])->one())?$mo->first_name:'-';
                break;
            case 2:
                $response=($mo=Account::find()->where(['account_id'=>$account_id])->one())?$mo->middle_name:'-';

                break;
            case 3:
                $response=($mo=Account::find()->where(['account_id'=>$account_id])->one())?$mo->surname:'-';

                break;
            case 4:
                $response=($mo=Account::find()->where(['account_id'=>$account_id])->one())?$mo->gender:'-';

                break;
            default:

                break;

        }

            return $response;
    }

    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }


}
