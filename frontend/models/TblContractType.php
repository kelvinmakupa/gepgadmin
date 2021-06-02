<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_contract_type".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $description
 * @property int $created_by fk from tbl user
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblContract[] $tblContracts
 * @property User $createdBy
 */
class TblContractType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_contract_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'short_name', 'created_by'], 'required'],
            [['description'], 'string'],
            [['created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['short_name'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['short_name'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'description' => 'Description',
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
        return $this->hasMany(TblContract::className(), ['contract_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
