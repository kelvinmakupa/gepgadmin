<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "audit_trail".
 *
 * @property int $id
 * @property int $entry_id
 * @property int $user_id
 * @property string $action
 * @property string $model
 * @property string $model_id
 * @property string $field
 * @property string $old_value
 * @property string $new_value
 * @property string $created
 *
 * @property User $user
 */
class AuditTrail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_trail';
    }


    public function scenarios(){

        $scenarios=parent::scenarios();

        $scenarios['report']=['user_id','start_date','end_date'];

        return $scenarios;
    }


    public function validateDate(){

        if(strtotime($this->start_date)>strtotime($this->end_date)){

            $this->addError('start_date','Please start date must be less or same/equal to the end date');
            $this->addError('end_date','Please end date must be greater or same/equal to start date');


        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_id', 'user_id'], 'integer'],
            [['action', 'model', 'model_id', 'created'], 'required'],
            [['old_value', 'new_value'], 'string'],
            [['created'], 'safe'],
            [['action', 'model', 'model_id', 'field'], 'string', 'max' => 255],
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
            'entry_id' => 'Audit Entry',
            'user_id' => 'Username',
            'action' => 'Action',
            'model' => 'Model',
            'model_id' => 'Model ID',
            'field' => 'Field',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'created' => 'Created',
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





