<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sp_system".
 *
 * @property int $id
 * @property string $system_acronym
 * @property string $system_name
 * @property string $access_token
 * @property string $bill_resp_url
 * @property string $pmt_info_url
 * @property string $sys_access_token
 * @property string $secret_key
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class SpSystem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_system';
    }

    public function rules()
    {
        return [
            [['system_acronym', 'system_name', 'access_token', 'bill_resp_url', 'pmt_info_url'], 'required'],
            [['status'], 'integer'],
            [['status'],'required','message'=>'Please choose any of the options'],
            [['created_at', 'updated_at'], 'safe'],
            ['access_token','unique'],
            [['bill_resp_url','pmt_info_url'],'url', 'defaultScheme' => 'http'],
            [['system_acronym'], 'string', 'max' => 100],
            [['system_name'], 'string', 'max' => 200],
            [['status'],'in','range'=>[0,9,10]],
            [['access_token','sys_access_token','secret_key'], 'string', 'max' => 256],
            [['bill_resp_url', 'pmt_info_url'], 'string', 'max' => 300],
        ];
    }


    public function scenarios(){

        $scenarios=parent::scenarios();
        $scenarios['create']=['system_acronym','sys_access_token','secret_key', 'system_name','bill_resp_url', 'pmt_info_url', 'status'];
        $scenarios['token']=['access_token'];
        $scenarios['key']=['secret_key'];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'system_acronym' => 'System Acronym',
            'system_name' => 'System Name',
            'access_token' => 'Access Token',
            'bill_resp_url' => 'Bill Response Callback URL',
            'pmt_info_url' => 'Payment Info Callback URL',
            'sys_access_token' => 'System Access Token',
            'secret_key' => 'Secret Key',
            'status' => 'System Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }








}
