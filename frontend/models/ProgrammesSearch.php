<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Programmes;

/**
 * ProgrammesSearch represents the model behind the search form about `app\models\Programmes`.
 */
class ProgrammesSearch extends Programmes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'department_id', 'programme_duration','direct_capacity','equivalent_capacity', 'capacity'], 'integer'],
            [['code', 'programme_name', 'admission_direct', 'admission_equiv', 'loan_priority', 'status'], 'safe'],
            [['min_point', 'local_amount','foreign_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Programmes::find();

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
            'level' => $this->level,
            'department_id' => $this->department_id,
            'min_point' => $this->min_point,
            'programme_duration' => $this->programme_duration,
            'capacity' => $this->capacity,
            'direct_capacity' => $this->direct_capacity,
            'equivalent_capacity' => $this->equivalent_capacity,
            'local_amount' => $this->local_amount,
            'foreign_amount' => $this->foreign_amount,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'programme_name', $this->programme_name])
            ->andFilterWhere(['like', 'admission_direct', $this->admission_direct])
            ->andFilterWhere(['like', 'admission_equiv', $this->admission_equiv])
            ->andFilterWhere(['like', 'loan_priority', $this->loan_priority])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
