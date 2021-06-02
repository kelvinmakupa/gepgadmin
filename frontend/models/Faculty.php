<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_faculty".
 *
 * @property integer $faculty_id
 * @property integer $college_id
 * @property string $faculty_name
 * @property string $faculty_acronym
 */
class Faculty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_faculty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['college_id', 'faculty_name', 'faculty_acronym'], 'required'],
            [['college_id'], 'integer'],
            [['faculty_name'], 'string', 'max' => 100],
            [['faculty_acronym'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'faculty_id' => 'Faculty ID',
            'college_id' => 'Campus Name',
            'faculty_name' => 'Faculty/School/Institute/Campus Name',
            'faculty_acronym' => 'Faculty Acronym',
        ];
    }

    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
