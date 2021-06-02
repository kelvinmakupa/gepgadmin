<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_cancellation".
 *
 * @property int $id
 * @property int $user_id
 * @property string $bill_id
 * @property string $reason
 * @property string $gepg_response
 * @property string $date_cancelled
 */
class TblCancellation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_cancellation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['bill_id'], 'string', 'max' => 100],
            [['reason', 'gepg_response','response_message'], 'string', 'max' => 200],
            [['date_cancelled'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'bill_id' => 'Bill ID',
            'reason' => 'Reason',
            'gepg_response' => 'Status Code',
            'response_message' => 'Response',
            'date_cancelled' => 'Date Cancelled',
        ];
    }

    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
