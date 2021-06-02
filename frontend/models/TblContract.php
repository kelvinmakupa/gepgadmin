<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_contract".
 *
 * @property int $id
 * @property int $contract_no Contract Number
 * @property int $debtor_id fk from tbl debtor
 * @property int $contract_type_id fk from tbl contract type
 * @property string $start_date contract start date
 * @property string $end_date contract end date
 * @property int $duration contact duration
 * @property string $attachment contract attachment (PDF format)
 * @property int $created_by fk from tbl user
 * @property string $is_active 1:Yes, 2:No
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblContractType $contactType
 * @property User $createdBy
 * @property TblDebtor $debtor
 */
class TblContract extends \yii\db\ActiveRecord
{
    public $file_upload;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_contract';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_no', 'debtor_id', 'contract_type_id', 'start_date', 'end_date', 'duration', 'attachment', 'created_by','file_upload'], 'required'],
            [['debtor_id', 'contract_type_id', 'duration', 'created_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at','file_upload','contract_no'], 'safe'],
            [['attachment', 'is_active'], 'string'],
            [['contract_no'], 'unique'],
            [['contract_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblContractType::className(), 'targetAttribute' => ['contract_type_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['file_upload'], 'file','skipOnEmpty' => false,'extensions' => ['pdf'], 'maxSize' => 1024 * 1024 * 2],
            [['debtor_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblDebtor::className(), 'targetAttribute' => ['debtor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contract_no' => 'Contract No',
            'debtor_id' => 'Debtor ID',
            'contract_type_id' => 'Contact Type ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'duration' => 'Duration',
            'attachment' => 'Attachment',
            'created_by' => 'Created By',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContractType()
    {
        return $this->hasOne(TblContractType::className(), ['id' => 'contract_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtor()
    {
        return $this->hasOne(TblDebtor::className(), ['id' => 'debtor_id']);
    }
}
