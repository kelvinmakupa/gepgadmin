<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gepg_bank".
 *
 * @property int $id
 * @property string $beneficiary_name Beneficiary Name
 * @property string $bank_name Bank full name
 * @property string $account_name Account name
 * @property string $account_number Account Number
 * @property string $swift_code Swift Code
 * @property string $acc_currency
 * @property int $is_visible account visibility 0-Invisible 10-Visible
 * @property string $created_at created at
 */
class GepgBank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gepg_bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['beneficiary_name', 'bank_name', 'account_name', 'account_number', 'swift_code', 'acc_currency'], 'required'],
            [['is_visible'], 'integer'],
            [['created_at'], 'safe'],
            [['beneficiary_name', 'account_name'], 'string', 'max' => 255],
            [['bank_name', 'swift_code'], 'string', 'max' => 250],
            [['account_number'], 'string', 'max' => 30],
            [['acc_currency'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'beneficiary_name' => 'Beneficiary Name',
            'bank_name' => 'Bank Name',
            'account_name' => 'Account Name',
            'account_number' => 'Account Number',
            'swift_code' => 'Swift Code',
            'acc_currency' => 'Acc Currency',
            'is_visible' => 'Is Visible',
            'created_at' => 'Created At',
        ];
    }
}
