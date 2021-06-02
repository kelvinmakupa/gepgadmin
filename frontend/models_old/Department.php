<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_department".
 *
 * @property integer $department_id
 * @property string $department_name
 * @property integer $faculty_id
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_name', 'faculty_id'], 'required'],
            [['faculty_id'], 'integer'],
            [['department_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department_id' => 'Department ID',
            'department_name' => 'Department Name',
            'faculty_id' => 'Faculty/School/Institute/Campus Name',
        ];
    }
}
