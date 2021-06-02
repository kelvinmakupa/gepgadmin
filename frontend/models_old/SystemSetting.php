<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_setting".
 *
 * @property int $id
 * @property string $acronym
 * @property string $sys_name System Name
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $avatar
 * @property string $welcome_note
 * @property string $created_at
 */
class SystemSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['acronym', 'sys_name', 'full_name', 'email', 'phone', 'avatar', 'welcome_note', 'created_at'], 'required'],
            [['welcome_note'], 'string'],
            [['acronym'], 'string', 'max' => 50],
            [['sys_name'], 'string', 'max' => 200],
            [['full_name', 'avatar'], 'string', 'max' => 250],
            [['email'], 'string', 'max' => 150],
            [['phone', 'created_at'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'acronym' => 'Acronym',
            'sys_name' => 'Sys Name',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'avatar' => 'Avatar',
            'welcome_note' => 'Welcome Note',
            'created_at' => 'Created At',
        ];
    }
}
