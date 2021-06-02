<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AuditEntry;

/**
 * AuditEntrySearch represents the model behind the search form of `app\models\AuditEntry`.
 */
class AuditEntrySearch extends AuditEntry
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ajax', 'memory_max'], 'integer'],
            [['created','user_id', 'ip', 'request_method', 'route'], 'safe'],
            [['duration'], 'number'],
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
        $query = AuditEntry::find();

        $query->joinWith('user');

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
            'created' => $this->created,
//            'user_id' => $this->user_id,
            'duration' => $this->duration,
            'ajax' => $this->ajax,
            'memory_max' => $this->memory_max,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'request_method', $this->request_method])
            ->andFilterWhere(['like', 'route', $this->route]);
        $query->andFilterWhere(['like', 'user.username',  $this->user_id]);


        return $dataProvider;
    }
}
