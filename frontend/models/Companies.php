<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property int $id Auto increment
 * @property string $company_code company code
 * @property string $full_name company full name
 * @property string $phone_number company phone number
 * @property int $email_address company email address
 * @property int $is_active company status
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_code', 'full_name', 'is_active'], 'required'],
            [['is_active'], 'integer'],
            [['company_code'], 'string', 'max' => 15],
            [['company_code'], 'unique'],
            [['email_address'], 'string', 'max' => 100],
            [['full_name'], 'string', 'max' => 200],
            [['phone_number'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_code' => 'Company Code',
            'full_name' => 'Full Name',
            'phone_number' => 'Phone Number',
            'email_address' => 'Email Address',
            'is_active' => 'Status',
        ];
    }



    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
