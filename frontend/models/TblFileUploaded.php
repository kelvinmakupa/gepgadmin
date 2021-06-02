<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_file_uploaded".
 *
 * @property int $id
 * @property int $user_id User uploaded the file
 * @property string $file_name file name
 * @property string $created_at Uploaded at
 * @property string $update_at Updated at
 *
 * @property User $user
 */
class TblFileUploaded extends \yii\db\ActiveRecord
{

    public $payer,$payment_type,$payment_option,$academic_year,$bill_currency,$bill_expire_date,$file_import;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_file_uploaded';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id','payer','payment_type','payment_option','academic_year','bill_currency','bill_expire_date'], 'required'],
            [['user_id','payment_type','payer','payment_option','academic_year',], 'integer'],
            [['created_at', 'update_at','bill_expire_date'], 'safe'],
            [['file_import'],'file','skipOnEmpty' => false,'extensions'=>'xls','checkExtensionByMimeType'=>false],
            [['file_name'], 'string', 'max' => 300],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    /**
     * @param $header
     * @return bool
     */
    public static function checkHeader($header){
        $flag=false;

        if((trim($header['A'])=="payer_name")&&(trim($header['B'])=='registration_no')&&(trim($header['C'])=='bill_description')&&(trim($header['D'])=='bill_amount')){
            $flag=true;
        }

        return $flag;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_option'=>'Payment Option',
            'payer'=>'Payer',
            'payment_type'=>'Payment Type',
            'academic_year'=>'Academic Year',
            'bill_currency'=>'Bill Currency',
            'bill_expire_date'=>'Bill Expire Date',
            'file_import'=>'Import File',
            'user_id' => 'Uploaded By',
            'file_name' => 'File Name',
            'created_at' => 'Uploaded At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
