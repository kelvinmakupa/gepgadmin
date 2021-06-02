<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nhif_member_registration".
 *
 * @property int $id
 * @property string $FormFourIndexNo
 * @property string $Remarks
 */
class NhifMemberRegistration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nhif_member_registration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FormFourIndexNo', 'Remarks'], 'required'],
            [['FormFourIndexNo'], 'string', 'max' => 45],
            [['Remarks'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'FormFourIndexNo' => 'Form Four Index No',
            'Remarks' => 'Remarks',
        ];
    }
}
