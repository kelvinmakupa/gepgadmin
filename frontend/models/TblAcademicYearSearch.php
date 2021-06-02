<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblAcademicYear;

/**
 * TblAcademicYearSearch represents the model behind the search form of `app\models\TblAcademicYear`.
 */
class TblAcademicYearSearch extends TblAcademicYear
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year_id', 'status', 'last_reg_no', 'last_reg_no_graduate'], 'integer'],
            [['year'], 'safe'],
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
        $query = TblAcademicYear::find();

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
            'year_id' => $this->year_id,
            'status' => $this->status,
            'last_reg_no' => $this->last_reg_no,
            'last_reg_no_graduate' => $this->last_reg_no_graduate,
        ]);

        $query->andFilterWhere(['like', 'year', $this->year]);

        return $dataProvider;
    }
}
