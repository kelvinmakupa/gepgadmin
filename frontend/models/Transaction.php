<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_transaction".
 *
 * @property int $id AI and primary key
 * @property int $bill_id Foreign Key from tbl_billing
 * @property string $trx_id Transaction id
 * @property string $pay_ref_id payment receipt issued by GePG
 * @property string $pay_control_num Payment Control Numbe in payment by payer
 * @property double $bill_amount bill amount
 * @property double $paid_amount paid amount
 * @property string $bill_pay_opt Bill payment option
 * @property string $ccy Currency
 * @property string $trx_dt_tm Transaction date and time
 * @property string $usd_pay_channel Payment provider payment channel used to pay the bill online bank,mobile bank,POS etc
 * @property string $payer_cell_num payer mobile number as received from the payment provider
 * @property string $payer_name payer name as received from payment provider
 * @property string $payer_email payer email as received from payment provider
 * @property string $psp_receipt_num Payment receipt issued by payment service provider
 * @property string $psp_name payment service provider name
 * @property string $ctr_acc_num Credited account number
 * @property string $received_date Our Received date
 */
class Transaction extends \yii\db\ActiveRecord
{


    public $payment_type,$start_date,$end_date;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_id', 'trx_id', 'pay_ref_id', 'pay_control_num', 'bill_amount', 'paid_amount', 'bill_pay_opt', 'ccy', 'trx_dt_tm', 'usd_pay_channel', 'payer_cell_num', 'payer_name', 'payer_email', 'psp_receipt_num', 'psp_name', 'ctr_acc_num'], 'required'],
            [['bill_id'], 'integer'],
            [['bill_amount', 'paid_amount'], 'number'],
            [['received_date'], 'safe'],
            [['payment_type','start_date','end_date'],'required','message'=>'Please choose {attribute}'],
            [['start_date', 'end_date'], 'safe'],
            ['start_date','validateDate'],
            [['trx_id', 'pay_ref_id', 'payer_email', 'psp_receipt_num', 'psp_name'], 'string', 'max' => 100],
            [['pay_control_num'], 'string', 'max' => 12],
            [['bill_pay_opt'], 'string', 'max' => 10],
            [['ccy'], 'string', 'max' => 3],
            [['trx_dt_tm'], 'string', 'max' => 20],
            [['usd_pay_channel'], 'string', 'max' => 2],
            [['payer_cell_num', 'ctr_acc_num'], 'string', 'max' => 30],
            [['payer_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bill_id' => 'Bill ID',
            'trx_id' => 'Transaction ID',
            'pay_ref_id' => 'Payment Receipt(GePG)',
            'pay_control_num' => 'Payment Control Number',
            'bill_amount' => 'Billed Amount',
            'paid_amount' => 'Paid Amount',
            'bill_pay_opt' => 'Bill Pay Option',
            'ccy' => 'Currency',
            'trx_dt_tm' => 'Transaction Date',
            'usd_pay_channel' => 'Payment Channel',
            'payer_cell_num' => 'Payer Mobile',
            'payer_name' => 'Payer Name',
            'payer_email' => 'Payer Email',
            'psp_receipt_num' => 'Payment Receipt(PSP)',
            'psp_name' => 'Payment Service Provider Name',
            'ctr_acc_num' => 'Credited Account Number',
            'received_date' => 'Received Date',
        ];
    }


    public function scenarios(){

        $scenarios=parent::scenarios();

        $scenarios['report']=['payment_type','start_date','end_date'];

        return $scenarios;
    }

    public function validateDate(){

        if(strtotime($this->start_date)>strtotime($this->end_date)){
    
            $this->addError('start_date','Please start date must be less or same/equal to the end date');
            $this->addError('end_date','Please end date must be greater or same/equal to start date');
    
    
        }
    }

    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
