<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_payment_types".
 *
 * @property int $id Auto increment value
 * @property int $acc_code Account Code
 * @property string $acc_description Account Description
 * @property int $gfs_code GFS Code
 * @property string $gfs_description GFS Description
 * @property string $created_at Created At
 * @property string $updated_at Updated at
 */
class TblPaymentTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_payment_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['acc_code', 'acc_description', 'gfs_code', 'gfs_description', 'updated_at'], 'required'],
            [['acc_code', 'gfs_code'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['acc_description', 'gfs_description'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'acc_code' => 'Acc Code',
            'acc_description' => 'Acc Description',
            'gfs_code' => 'Gfs Code',
            'gfs_description' => 'Gfs Description',
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
