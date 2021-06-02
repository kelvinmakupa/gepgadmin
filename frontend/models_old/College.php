<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_college".
 *
 * @property integer $college_id
 * @property integer $institution_id
 * @property string $college_name
 * @property string $college_acronym
 */
class College extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_college';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['institution_id', 'college_name', 'college_acronym'], 'required'],
            [['institution_id'], 'integer'],
            [['college_name'], 'string'],
            [['college_acronym'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'college_id' => 'Campus Name',
            'institution_id' => 'Institution ID',
            'college_name' => 'Campus Name',
            'college_acronym' => 'Campus Acronym',
        ];
    }
}
