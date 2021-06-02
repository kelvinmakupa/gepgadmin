<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_academic_year".
 *
 * @property int $year_id
 * @property string $year
 * @property int $status
 * @property int $last_reg_no
 * @property int $last_reg_no_graduate
 */
class TblAcademicYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_academic_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'status', 'last_reg_no_graduate'], 'required'],
            [['status', 'last_reg_no', 'last_reg_no_graduate'], 'integer'],
            [['year'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'year_id' => 'Year ID',
            'year' => 'Year',
            'status' => 'Status',
            'last_reg_no' => 'Last Reg No',
            'last_reg_no_graduate' => 'Last Reg No Graduate',
        ];
    }
}
