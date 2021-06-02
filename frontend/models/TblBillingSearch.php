<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblBilling;

/**
 * TblBillingSearch represents the model behind the search form of `app\models\TblBilling`.
 */
class TblBillingSearch extends TblBilling
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','payer','sys_bill_id', 'payment_type_id', 'company_id','year_id', 'bill_pay_opt', 'is_posted', 'is_cancelled'], 'integer'],
            [['payer_name','sp_system_id', 'bill_exp_date', 'bill_description', 'bill_gen_by', 'bill_appr_by', 'payer_cell_num', 'payer_email', 'bill_currency', 'bill_gen_date', 'bill_id', 'control_number', 'use_on_pay', 'bill_item_ref'], 'safe'],
            [['bill_amount', 'bill_eqv_amount'], 'number'],
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
        $query = TblBilling::find();

        $query->joinWith('sp');

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
            'payer' => $this->payer,
            'bill_amount' => $this->bill_amount,
            'bill_exp_date' => $this->bill_exp_date,
            'payment_type_id' => $this->payment_type_id,
            'company_id' => $this->company_id,
            'sys_bill_id' => $this->sys_bill_id,
            'bill_pay_opt' => $this->bill_pay_opt,
            'bill_eqv_amount' => $this->bill_eqv_amount,
            'is_posted' => $this->is_posted,
            'year_id'=>$this->year_id, 
            'is_cancelled' => $this->is_cancelled,
        ]);

        $query->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'bill_description', $this->bill_description])
            ->andFilterWhere(['like', 'bill_gen_by', $this->bill_gen_by])
            ->andFilterWhere(['like', 'bill_appr_by', $this->bill_appr_by])
            ->andFilterWhere(['like', 'payer_cell_num', $this->payer_cell_num])
            ->andFilterWhere(['like', 'payer_email', $this->payer_email])
            ->andFilterWhere(['like', 'bill_currency', $this->bill_currency])
            ->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'use_on_pay', $this->use_on_pay])
           ->andFilterWhere(['like', 'sp_system.system_name', $this->sp_system_id])
            ->andFilterWhere(['like', 'bill_item_ref', $this->bill_item_ref]);

        if(!empty($this->bill_gen_date) && strpos($this->bill_gen_date, '-') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->bill_gen_date);

            $query->andFilterWhere(['between','bill_gen_date',$start_date,$end_date]);
        }


        return $dataProvider;
    }
}
