<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblBillingTemp;

/**
 * BillingTempSearch represents the model behind the search form of `app\models\TblBillingTemp`.
 */
class BillingTempSearch extends TblBillingTemp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'file_uploaded_id', 'sp_system_id', 'payer', 'bill_pay_opt', 'year_id', 'is_deleted', 'status'], 'integer'],
            [['payment_type_id','payer_name', 'bill_exp_date', 'bill_description', 'bill_gen_by', 'bill_appr_by', 'payer_cell_num', 'payer_email', 'bill_currency', 'bill_gen_date', 'bill_id', 'control_number', 'use_on_pay', 'bill_item_ref', 'created_at', 'updated_at'], 'safe'],
            [['bill_amount', 'bill_eqv_amount'], 'number'],
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
        $query = TblBillingTemp::find();

        $query->joinWith('paymentType');
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
            'file_uploaded_id' => $this->file_uploaded_id,
            'sp_system_id' => $this->sp_system_id,
            'payer' => $this->payer,
            'bill_amount' => $this->bill_amount,
           // 'payment_type_id' => $this->payment_type_id,
            'bill_pay_opt' => $this->bill_pay_opt,
            'bill_eqv_amount' => $this->bill_eqv_amount,
            'year_id' => $this->year_id,
            'is_deleted' => $this->is_deleted,
            'tbl_billing_temp.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'bill_exp_date', $this->bill_exp_date])
            ->andFilterWhere(['like', 'bill_description', $this->bill_description])
            ->andFilterWhere(['like', 'bill_gen_by', $this->bill_gen_by])
            ->andFilterWhere(['like', 'bill_appr_by', $this->bill_appr_by])
            ->andFilterWhere(['like', 'payer_cell_num', $this->payer_cell_num])
            ->andFilterWhere(['like', 'payer_email', $this->payer_email])
            ->andFilterWhere(['like', 'bill_currency', $this->bill_currency])
            ->andFilterWhere(['like', 'bill_gen_date', $this->bill_gen_date])
            ->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'tbl_payment_type.acc_description', $this->payment_type_id])
            ->andFilterWhere(['like', 'use_on_pay', $this->use_on_pay])
            ->andFilterWhere(['like', 'bill_item_ref', $this->bill_item_ref]);

        return $dataProvider;
    }
}
