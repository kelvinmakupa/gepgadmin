<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_debtor".
 *
 * @property int $id
 * @property string $company_name company name
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $sex 1:Female, 2:Male
 * @property string $phone phone number
 * @property string $email email address
 * @property string $postal_address postal address
 * @property int $debtor_type_id fk from tbl debtor type
 * @property string $tin_no Tin Number
 * @property string $check_no Check Number
 * @property string $is_active 1:Yes, 2:No
 * @property int $created_by fk from tbl user
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblContract[] $tblContracts
 * @property User $createdBy
 * @property TblDebtorType $debtorType
 */
class TblDebtor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_debtor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex', 'debtor_type_id', 'created_by'], 'required'],
            [['sex', 'is_active'], 'string'],
            [['debtor_type_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['company_name', 'tin_no', 'check_no'], 'string', 'max' => 200],
            [['first_name', 'middle_name', 'last_name', 'email', 'postal_address'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['tin_no'], 'unique'],
            [['check_no'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['debtor_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblDebtorType::className(), 'targetAttribute' => ['debtor_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'sex' => 'Sex',
            'phone' => 'Phone',
            'email' => 'Email',
            'postal_address' => 'Postal Address',
            'debtor_type_id' => 'Debtor Type ID',
            'tin_no' => 'Tin No',
            'check_no' => 'Check No',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblContracts()
    {
        return $this->hasMany(TblContract::className(), ['debtor_id' => 'id']);
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
    public function getDebtorType()
    {
        return $this->hasOne(TblDebtorType::className(), ['id' => 'debtor_type_id']);
    }
}
