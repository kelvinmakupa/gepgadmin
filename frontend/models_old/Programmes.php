<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "programmes".
 *
 * @property integer $id
 * @property string $code
 * @property integer $level
 * @property string $programme_name
 * @property integer $department_id
 * @property string $admission_direct
 * @property string $admission_equiv
 * @property double $min_point
 * @property integer $programme_duration
 * @property integer $capacity
 * @property double $tuition_fee
 * @property string $loan_priority
 * @property string $status
 *
 * @property Application[] $applications
 * @property EligibleStudents[] $eligibleStudents
 * @property QualificationType $level0
 * @property SelectedStudents[] $selectedStudents
 */
class Programmes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'programmes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'level', 'programme_name', 'department_id', 'admission_direct', 'admission_equiv', 'min_point', 'programme_duration', 'capacity','direct_capacity','equivalent_capacity', 'local_amount', 'foreign_amount', 'loan_priority', 'status'], 'required'],
            [['level', 'department_id', 'programme_duration','direct_capacity','equivalent_capacity', 'capacity'], 'integer'],
            [['admission_direct', 'admission_equiv'], 'string'],
            [['local_amount','foreign_amount'], 'number'],
            [['code', 'programme_name','min_point'], 'string', 'max' => 250],
            [['loan_priority'], 'string', 'max' => 100],
            [['direct_capacity','capacity'], 'integer', 'min' => 10],
            [['status'], 'string', 'max' => 12],
            [['code'], 'unique'],
            [['level'], 'exist', 'skipOnError' => true, 'targetClass' => QualificationType::className(), 'targetAttribute' => ['level' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Programme Code',
            'level' => 'Level',
            'programme_name' => 'Programme Name',
            'department_id' => 'Department',
            'admission_direct' => 'Admission Direct',
            'admission_equiv' => 'Admission Equiv',
            'min_point' => 'Minimum Point',
            'programme_duration' => 'Programme Duration',
            'capacity' => 'Total Capacity',
            'direct_capacity' => 'Direct Capacity',
            'equivalent_capacity' => 'Equivalent Capacity',
            'local_amount' => 'Local Amount (TZS)',
            'foreign_amount' => 'Foreign Amount (USD)',
            'loan_priority' => 'Loan Priority',
            'status' => 'Status',
        ];
    }

    public function scenarios(){

        $scenarios=parent::scenarios();
        $scenarios['update']=['local_amount', 'foreign_amount'];
        return $scenarios;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['first_choice' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEligibleStudents()
    {
        return $this->hasMany(EligibleStudents::className(), ['course_code' => 'code']);
    }


    public static function getProgrammeName($programme_code){



        return ($obj=Programmes::find()->where(['code'=>$programme_code])->one())?$obj->programme_name:'-';
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel0()
    {
        return $this->hasOne(QualificationType::className(), ['id' => 'level']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSelectedStudents()
    {
        return $this->hasMany(SelectedStudents::className(), ['course_code' => 'code']);
    }
}
