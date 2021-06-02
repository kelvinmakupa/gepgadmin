<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_organ_type".
 *
 * @property int $id
 * @property string $name organ type name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblOrgan[] $tblOrgans
 */
class TblOrganType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_organ_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblOrgans()
    {
        return $this->hasMany(TblOrgan::className(), ['organ_type_id' => 'id']);
    }
}
