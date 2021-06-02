<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_fee_structure".
 *
 * @property int $id AI and primary key
 * @property int $payment_type_id Foreign key from tbl_payment_type table
 * @property int $academic_year_id Foreign key from tbl_academic_year
 * @property int $programme_id Foreign key from tbl_programme
 * @property int $year_of_study Year of study
 * @property int $local_amount Amount in Tsh.
 * @property int $foreign_amount Amount in USD
 */
class FeeStructure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_fee_structure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_type_id', 'academic_year_id', 'programme_id', 'year_of_study', 'local_amount', 'foreign_amount'], 'required'],
            [['payment_type_id', 'academic_year_id', 'programme_id', 'year_of_study', 'local_amount', 'foreign_amount'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_type_id' => 'Payment Type',
            'academic_year_id' => 'Academic Year',
            'programme_id' => 'Programme',
            'year_of_study' => 'Year Of Study',
            'local_amount' => 'Local Amount',
            'foreign_amount' => 'Foreign Amount',
        ];
    }
}
