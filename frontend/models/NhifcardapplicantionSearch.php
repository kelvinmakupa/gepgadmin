<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NhifCardApplicantionStatus;

/**
 * NhifcardapplicantionSearch represents the model behind the search form of `app\models\NhifCardApplicantionStatus`.
 */
class NhifcardapplicantionSearch extends NhifCardApplicantionStatus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['BatchNo', 'FormFourIndexNo', 'IdentificationNo', 'ControlNo', 'InvoiceAmount'], 'safe'],
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
        $query = NhifCardApplicantionStatus::find();

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
        ]);

        $query->andFilterWhere(['like', 'BatchNo', $this->BatchNo])
            ->andFilterWhere(['like', 'FormFourIndexNo', $this->FormFourIndexNo])
            ->andFilterWhere(['like', 'IdentificationNo', $this->IdentificationNo])
            ->andFilterWhere(['like', 'ControlNo', $this->ControlNo])
            ->andFilterWhere(['like', 'InvoiceAmount', $this->InvoiceAmount]);

        return $dataProvider;
    }
}
