<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_asset".
 *
 * @property int $id
 * @property int $asset_type_id fk from tbl asset
 * @property string $description
 * @property int $location_id fk from tbl location
 * @property string $asset_no asset number
 * @property string $block_no block number
 * @property string $is_active 1:Yes, 2:No
 * @property int $created_by fk from tbl user
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblAssetType $assetType
 * @property User $createdBy
 * @property TblOrgan $location
 */
class TblAsset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_asset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asset_type_id', 'location_id', 'asset_no', 'block_no', 'created_by'], 'required'],
            [['asset_type_id', 'location_id', 'created_by'], 'integer'],
            [['description', 'is_active'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['asset_no'], 'string', 'max' => 20],
            [['block_no'], 'string', 'max' => 50],
            [['asset_type_id', 'asset_no', 'block_no', 'location_id'], 'unique', 'targetAttribute' => ['asset_type_id', 'asset_no', 'block_no', 'location_id']],
            [['asset_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAssetType::className(), 'targetAttribute' => ['asset_type_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblOrgan::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset_type_id' => 'Asset Type ID',
            'description' => 'Description',
            'location_id' => 'Location ID',
            'asset_no' => 'Asset No',
            'block_no' => 'Block No',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetType()
    {
        return $this->hasOne(TblAssetType::className(), ['id' => 'asset_type_id']);
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
    public function getLocation()
    {
        return $this->hasOne(TblOrgan::className(), ['id' => 'location_id']);
    }
}
