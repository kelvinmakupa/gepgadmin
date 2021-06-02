<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "theme_manager".
 *
 * @property integer $id
 * @property string $theme_name
 * @property string $status
 */
class ThemeManager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'theme_manager';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['theme_name', 'status'], 'required'],
            [['theme_name', 'status'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'theme_name' => 'Theme Name',
            'status' => 'Status',
        ];
    }

    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
