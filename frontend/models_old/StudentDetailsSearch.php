<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentDetails;

/**
 * StudentDetailsSearch represents the model behind the search form of `app\models\StudentDetails`.
 */
class StudentDetailsSearch extends StudentDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'yos', 'application_round', 'is_delete'], 'integer'],
            [['admission_number', 'reg_number', 'first_name', 'middle_name', 'last_name', 'sex', 'dob', 'citizenship', 'email', 'phone', 'f4indexno', 'other_f4indexno', 'f6indexno', 'other_f6indexno', 'programme_code', 'study_level', 'academic_year', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StudentDetails::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'yos' => $this->yos,
            'application_round' => $this->application_round,
            'is_delete' => $this->is_delete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'admission_number', $this->admission_number])
            ->andFilterWhere(['like', 'reg_number', $this->reg_number])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'dob', $this->dob])
            ->andFilterWhere(['like', 'citizenship', $this->citizenship])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'other_f4indexno', $this->other_f4indexno])
            ->andFilterWhere(['like', 'f6indexno', $this->f6indexno])
            ->andFilterWhere(['like', 'other_f6indexno', $this->other_f6indexno])
            ->andFilterWhere(['like', 'programme_code', $this->programme_code])
            ->andFilterWhere(['like', 'study_level', $this->study_level])
            ->andFilterWhere(['like', 'academic_year', $this->academic_year]);

        return $dataProvider;
    }
}
