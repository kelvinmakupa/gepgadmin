<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_organ".
 *
 * @property int $id
 * @property string $name organ name
 * @property string $short_name
 * @property string $description
 * @property int $organ_type_id fk from tbl organ type
 * @property string $is_active 1:Active, 2:Not Active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblOrganType $organType
 */
class TblOrgan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_organ';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'organ_type_id'], 'required'],
            [['description', 'is_active'], 'string'],
            [['organ_type_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['short_name'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['organ_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblOrganType::className(), 'targetAttribute' => ['organ_type_id' => 'id']],
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
            'organ_type_id' => 'Organ Type ID',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganType()
    {
        return $this->hasOne(TblOrganType::className(), ['id' => 'organ_type_id']);
    }
}
