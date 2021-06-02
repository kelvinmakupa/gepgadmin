<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account_role".
 *
 * @property integer $role_id
 * @property string $role_name
 *
 * @property Accounts[] $accounts
 */
class AccountRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['role_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'role_name' => 'Role Name',
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(User::className(), ['role_id' => 'role_id']);
    }

    public static function getRoleName($id){
        return AccountRole::find()->where(['role_id'=>$id])->one()->role_name;
    }
}
