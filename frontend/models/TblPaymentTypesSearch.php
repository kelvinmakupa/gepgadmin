<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblPaymentTypes;

/**
 * TblPaymentTypesSearch represents the model behind the search form of `app\models\TblPaymentTypes`.
 */
class TblPaymentTypesSearch extends TblPaymentTypes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'acc_code', 'gfs_code'], 'integer'],
            [['acc_description', 'gfs_description', 'created_at', 'updated_at'], 'safe'],
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
        $query = TblPaymentTypes::find();

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
            'acc_code' => $this->acc_code,
            'gfs_code' => $this->gfs_code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'acc_description', $this->acc_description])
            ->andFilterWhere(['like', 'gfs_description', $this->gfs_description]);

        return $dataProvider;
    }
}
