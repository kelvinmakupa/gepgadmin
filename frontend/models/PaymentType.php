<?php

namespace app\models;

use Yii;
use app\models\Currency;
/**
 * This is the model class for table "tbl_payment_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $status
 * @property integer $currency_flag
 *
 * @property TblBankerPayment[] $tblBankerPayments
 */
class PaymentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_payment_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['status', 'currency_flag'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['code'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Payment Code',
            'description' => 'Description',
            'status' => 'Status',
            'currency_flag' => 'Currency',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblBankerPayments()
    {
        return $this->hasMany(TblBankerPayment::className(), ['payment_type_id' => 'id']);
    }


    public static function getStatus($id=1,$flag=true){

        $status=array(['id'=>'0','name'=>'Inactive'],['id'=>'1','name'=>'Active']);
        if($flag){

            return $status;
        }

        return $status[$id]['name'];
    }

    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }



}
