<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_billing".
 *
 * @property int $id AI and primary key
 * @property string $payer_name Name of the payer
 * @property double $bill_amount billed amount
 * @property string $bill_exp_date bill expire date
 * @property string $bill_description bill description
 * @property string $bill_gen_by bill generated by
 * @property string $bill_appr_by bill approved by
 * @property string $payer_cell_num payer cell phone number
 * @property string $payer_email payer email address
 * @property string $bill_currency Bill Currency
 * @property int $payment_type_id Payment type id
 * @property int $company_id company id
 * @property string $bill_gen_date bill generated date
 * @property string $bill_id bill id
 * @property string $control_number control number for payment
 * @property int $bill_pay_opt Bill Payment Options 1-full,2-partial,3-Exactly
 * @property string $use_on_pay Use item reference on pay N-No, Y-Yes
 * @property double $bill_eqv_amount Equivalent amount applicable on none TZS
 * @property string $bill_item_ref
 * @property int $is_posted
 * @property int $is_cancelled  1 -Ok , 2- Cancelled
 */
class TblBilling extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_billing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payer_name','payer', 'bill_amount', 'bill_exp_date', 'bill_description', 'bill_gen_by', 'bill_appr_by', 'bill_currency', 'payment_type_id', 'company_id','year_id', 'bill_id', 'control_number', 'bill_pay_opt', 'use_on_pay', 'bill_eqv_amount', 'bill_item_ref', 'is_posted'], 'required'],
            [['bill_amount','bill_eqv_amount'], 'number'],
            ['payer_name', 'match', 'pattern' => '/^[a-zA-Z\' ]+$/', 'message' => 'Invalid characters in payer name. Only [a-zA-Z ] are allowed'],            
            ['payer_cell_num', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Only numbers are allowed.'],
            [['bill_exp_date', 'bill_gen_date'], 'safe'],
            [['payer_email'], 'email'],
            ['payer_email', 'filter', 'filter'=>'strtolower'],
            [['payer_name','bill_item_ref','bill_description'], 'filter', 'filter'=>'strtoupper'],
            [['payer','year_id'], 'integer'],
            [['payer'], 'integer','min'=>1,'max'=>3,'message'=>'Invalid entry'],
            [['payment_type_id', 'company_id','bill_pay_opt','sys_bill_id','sp_system_id', 'is_posted', 'is_cancelled'], 'integer'],
            [['payer_name', 'bill_description'], 'string', 'max' => 200],
            [['bill_description'], 'string', 'min' => 20], 
            [['bill_gen_by', 'bill_appr_by'], 'string', 'max' => 50],
            [['payer_cell_num', 'payer_email'], 'string', 'max' => 100],
            [['bill_currency'], 'string', 'max' => 5],
            [['bill_id'], 'string', 'max' => 100],
            [['control_number'], 'string', 'max' => 12],
            [['use_on_pay'], 'string', 'max' => 1],
            [['bill_item_ref'], 'string', 'max' => 100],
            [['sp_system_id'], 'exist', 'skipOnError' => false, 'targetClass' => SpSystem::className(), 'targetAttribute' => ['sp_system_id' => 'id']]
        ];
    }
          
    
    public function scenarios(){

        $scenarios=parent::scenarios();
        
        $scenarios['individual']=['payer_name','payer','payer_cell_num', 'payer_email','payment_type_id','bill_currency','bill_amount','bill_eqv_amount',
            'bill_exp_date','bill_description','bill_gen_date','bill_pay_opt','use_on_pay',
            'is_posted','is_cancelled','company_id','bill_gen_by','bill_appr_by'];
        
        
            $scenarios['company']=['company_id','payer','payer_name','payer_cell_num',
            'payer_email','payment_type_id','bill_currency','bill_amount','bill_eqv_amount',
            'bill_exp_date','bill_description','bill_gen_date','bill_pay_opt','use_on_pay',
            'is_posted','is_cancelled','company_id','bill_gen_by','bill_item_ref','bill_appr_by'];

        $scenarios['student']=['payer_name','payer','payer_cell_num','year_id', 'payer_email','payment_type_id','bill_currency','bill_amount','bill_eqv_amount',
            'bill_exp_date','bill_description','bill_gen_date','bill_pay_opt','use_on_pay',
            'is_posted','is_cancelled','company_id','bill_gen_by','bill_appr_by','bill_item_ref'];   

        $scenarios['update']=['payer_name','payer','payer_cell_num', 'payer_email','payment_type_id','bill_currency','bill_amount','bill_eqv_amount',
            'bill_exp_date','bill_description','bill_gen_date','bill_pay_opt','use_on_pay',
            'is_posted','is_cancelled','company_id','bill_gen_by','bill_appr_by'];
        
        $scenarios['updat']=['bill_item_ref','payment_type_id','year_id'];
        
        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payer' => 'Payer',
            'sys_bill_id'=>'SP Bill ID',
            'sp_system_id'=>'SP Name',
            'payer_name' => 'Payer Name',
            'bill_amount' => 'Bill Amount',
            'bill_exp_date' => 'Bill Expire Date',
            'bill_description' => 'Bill Description',
            'bill_gen_by' => 'Bill Genenerated By',
            'bill_appr_by' => 'Bill Approved By',
            'payer_cell_num' => 'Phone Number',
            'payer_email' =>    'Email Address',
            'bill_currency' => 'Bill Currency',
            'payment_type_id' => 'Payment Type',
            'company_id' => 'Company Name',
            'bill_gen_date' => 'Bill Generated Date',
            'bill_id' => 'Bill ID',
            'control_number' => 'Control Number',
            'bill_pay_opt' => 'Bill Payment Option',
            'use_on_pay' => 'Use On Pay',
            'bill_eqv_amount' => 'Bill Equivalent Amount',
            'bill_item_ref' => 'Bill Item Reference',
            'is_posted' => 'Is Posted',
            'year_id'=>'Academic Year',
            'is_cancelled' => 'Is Cancelled',
        ];
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSp()
    {
        return $this->hasOne(SpSystem::className(), ['id' => 'sp_system_id']);
    }



    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}