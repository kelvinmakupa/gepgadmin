<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `app\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bill_id'], 'integer'],
            [['trx_id', 'pay_ref_id', 'pay_control_num', 'bill_pay_opt', 'ccy', 'trx_dt_tm', 'usd_pay_channel', 'payer_cell_num', 'payer_name', 'payer_email', 'psp_receipt_num', 'psp_name', 'ctr_acc_num', 'received_date'], 'safe'],
            [['bill_amount', 'paid_amount'], 'number'],
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
        $query = Transaction::find();

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
            'bill_id' => $this->bill_id,
            'bill_amount' => $this->bill_amount,
            'paid_amount' => $this->paid_amount,
            'received_date' => $this->received_date,
        ]);

        $query->andFilterWhere(['like', 'trx_id', $this->trx_id])
            ->andFilterWhere(['like', 'pay_ref_id', $this->pay_ref_id])
            ->andFilterWhere(['like', 'pay_control_num', $this->pay_control_num])
            ->andFilterWhere(['like', 'bill_pay_opt', $this->bill_pay_opt])
            ->andFilterWhere(['like', 'ccy', $this->ccy])
            ->andFilterWhere(['like', 'trx_dt_tm', $this->trx_dt_tm])
            ->andFilterWhere(['like', 'usd_pay_channel', $this->usd_pay_channel])
            ->andFilterWhere(['like', 'payer_cell_num', $this->payer_cell_num])
            ->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'payer_email', $this->payer_email])
            ->andFilterWhere(['like', 'psp_receipt_num', $this->psp_receipt_num])
            ->andFilterWhere(['like', 'psp_name', $this->psp_name])
            ->andFilterWhere(['like', 'ctr_acc_num', $this->ctr_acc_num]);

        return $dataProvider;
    }
}
