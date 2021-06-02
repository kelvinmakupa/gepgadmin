<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_location".
 *
 * @property int $id
 * @property string $name location name
 * @property string $short_name
 * @property string $description
 * @property int $organ_id fk from tbl college
 * @property int $created_by fk from tbl user
 * @property string $is_active 1:Yes, 2:No
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblAsset[] $tblAssets
 * @property User $createdBy
 * @property TblOrgan $organ
 */
class TblLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'organ_id', 'created_by'], 'required'],
            [['description', 'is_active'], 'string'],
            [['organ_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['short_name'], 'string', 'max' => 100],
            [['name'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['organ_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblOrgan::className(), 'targetAttribute' => ['organ_id' => 'id']],
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
            'organ_id' => 'Organ ID',
            'created_by' => 'Created By',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAssets()
    {
        return $this->hasMany(TblAsset::className(), ['location_id' => 'id']);
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
    public function getOrgan()
    {
        return $this->hasOne(TblOrgan::className(), ['id' => 'organ_id']);
    }
}
