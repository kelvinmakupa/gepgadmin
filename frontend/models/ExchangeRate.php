<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exchange_rate".
 *
 * @property int $id
 * @property string $currency
 * @property double $amount
 * @property string $updated_at
 */
class ExchangeRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exchange_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currency', 'amount'], 'required'],
            [['amount'], 'number'],
            [['updated_at'], 'safe'],
            [['currency'], 'unique','message'=>'{value} has aleady been registered'],
            [['currency'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency' => 'Currency',
            'amount' => 'Amount',
            'updated_at' => 'Updated At',
        ];
    }


    public static function convertCurrency($currency,$amount){



    }







    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
