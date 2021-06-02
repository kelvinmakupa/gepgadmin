<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_details".
 *
 * @property int $id Auto increment id
 * @property string $admission_number Admission number from OAS
 * @property string $reg_number Registration Number
 * @property string $first_name First Name
 * @property string $middle_name Middle Name
 * @property string $last_name Last Name
 * @property string $sex Sex
 * @property string $dob Date of birth
 * @property string $citizenship citizenship of student
 * @property string $email email address
 * @property string $phone phone number
 * @property string $f4indexno form four index number
 * @property string $other_f4indexno other form four index number
 * @property string $f6indexno form six index number
 * @property string $other_f6indexno other form six index number
 * @property string $programme_code programme code
 * @property string $study_level 1-certificate,2-diploma,3-Bachelor
 * @property int $yos Year of study
 * @property int $application_round Applicant's application round
 * @property string $academic_year Academic_year
 * @property int $is_delete 1-not deleted,2-deleted
 * @property string $created_at Created At
 * @property string $updated_at Updated At
 */
class StudentDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admission_number', 'reg_number', 'first_name', 'middle_name', 'last_name', 'sex', 'dob', 'citizenship', 'email', 'phone', 'f4indexno', 'other_f4indexno', 'f6indexno', 'other_f6indexno', 'programme_code', 'study_level', 'yos', 'application_round', 'academic_year', 'created_at'], 'required'],
            [['yos', 'application_round', 'is_delete'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['admission_number', 'reg_number'], 'string', 'max' => 30],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 50],
            [['sex'], 'string', 'max' => 15],
            [['dob', 'phone', 'f4indexno', 'other_f4indexno', 'f6indexno', 'other_f6indexno', 'academic_year'], 'string', 'max' => 20],
            [['citizenship', 'email'], 'string', 'max' => 100],
            [['programme_code'], 'string', 'max' => 10],
            [['study_level'], 'string', 'max' => 5],
            [['reg_number'], 'unique'],
            [['admission_number', 'academic_year'], 'unique', 'targetAttribute' => ['admission_number', 'academic_year']],
            [['f4indexno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admission_number' => 'Admission Number',
            'reg_number' => 'Reg Number',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'sex' => 'Sex',
            'dob' => 'Dob',
            'citizenship' => 'Citizenship',
            'email' => 'Email',
            'phone' => 'Phone',
            'f4indexno' => 'F4indexno',
            'other_f4indexno' => 'Other F4indexno',
            'f6indexno' => 'F6indexno',
            'other_f6indexno' => 'Other F6indexno',
            'programme_code' => 'Programme Code',
            'study_level' => 'Study Level',
            'yos' => 'Yos',
            'application_round' => 'Application Round',
            'academic_year' => 'Academic Year',
            'is_delete' => 'Is Delete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
