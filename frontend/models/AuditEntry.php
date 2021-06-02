<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "audit_entry".
 *
 * @property int $id
 * @property string $created
 * @property int $user_id
 * @property double $duration
 * @property string $ip
 * @property string $request_method
 * @property int $ajax
 * @property string $route
 * @property int $memory_max
 *
 * @property User $user
 */
class AuditEntry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_entry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created'], 'required'],
            [['created'], 'safe'],
            [['user_id', 'ajax', 'memory_max'], 'integer'],
            [['duration'], 'number'],
            [['ip'], 'string', 'max' => 45],
            [['request_method'], 'string', 'max' => 16],
            [['route'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Created',
            'user_id' => 'Username',
            'duration' => 'Duration',
            'ip' => 'Ip Address',
            'request_method' => 'Request Method',
            'ajax' => 'Ajax',
            'route' => 'Route',
            'memory_max' => 'Memory Max',
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
