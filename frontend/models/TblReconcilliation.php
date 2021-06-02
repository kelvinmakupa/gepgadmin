<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_reconcilliation".
 *
 * @property int $id
 * @property int $user_id
 * @property string $trx_date
 * @property int $recon_opt
 * @property string $file_name
 * @property string $created_at
 */
class TblReconcilliation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_reconcilliation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'trx_date', 'recon_opt'], 'required','message'=>'Please select {attribute}'],
            [['user_id','reconc_id', 'recon_opt'], 'integer'],
            [['trx_date', 'created_at'], 'safe'],
            [['file_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'trx_date' => 'Transaction Date',
            'reconc_id'=>'Reconciliation Id',
            'recon_opt' => 'Reconcilliation Option',
            'file_name' => 'File Name',
            'created_at' => 'Requested At',
        ];
    }

    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
