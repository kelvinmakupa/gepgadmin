<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gepg_credentials".
 *
 * @property int $id
 * @property string $token
 * @property string $bill_appr_by
 * @property int $reference_id
 * @property string $created_at
 */
class GepgCredentials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gepg_credentials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'bill_appr_by', 'reference_id', 'created_at'], 'required'],
            [['reference_id'], 'integer'],
            [['token'], 'string', 'max' => 300],
            [['bill_appr_by'], 'string', 'max' => 30],
            [['created_at'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'bill_appr_by' => 'Bill Appr By',
            'reference_id' => 'Reference ID',
            'created_at' => 'Created At',
        ];
    }
}
