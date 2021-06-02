<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeeStructure;

/**
 * FeeStructureSearch represents the model behind the search form of `app\models\FeeStructure`.
 */
class FeeStructureSearch extends FeeStructure
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_type_id', 'academic_year_id', 'programme_id', 'year_of_study', 'local_amount', 'foreign_amount'], 'integer'],
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
        $query = FeeStructure::find();

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
            'payment_type_id' => $this->payment_type_id,
            'academic_year_id' => $this->academic_year_id,
            'programme_id' => $this->programme_id,
            'year_of_study' => $this->year_of_study,
            'local_amount' => $this->local_amount,
            'foreign_amount' => $this->foreign_amount,
        ]);

        return $dataProvider;
    }
}
