<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nhif_card_applicantion_status".
 *
 * @property int $id
 * @property string $BatchNo
 * @property string $FormFourIndexNo
 * @property string $IdentificationNo
 * @property string $ControlNo
 * @property string $InvoiceAmount
 */
class NhifCardApplicantionStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nhif_card_applicantion_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BatchNo', 'FormFourIndexNo', 'IdentificationNo', 'ControlNo', 'InvoiceAmount'], 'required'],
            [['BatchNo', 'FormFourIndexNo', 'IdentificationNo', 'ControlNo', 'InvoiceAmount'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'BatchNo' => 'Batch No',
            'FormFourIndexNo' => 'Form Four Index No',
            'IdentificationNo' => 'Identification No',
            'ControlNo' => 'Control No',
            'InvoiceAmount' => 'Invoice Amount',
        ];
    }
}
