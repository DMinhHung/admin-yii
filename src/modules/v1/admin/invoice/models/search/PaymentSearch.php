<?php


namespace app\modules\v1\admin\invoice\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\admin\invoice\models\Payment;

class PaymentSearch extends Payment
{
    public function rules()
    {
        return [
            [['payment_no', 'date', 'payee_name', 'payee_phone', 'reason', 'amount', 'payment_method', 'invoice_id', 'status'], 'default', 'value' => null],
            [['date'], 'safe'],
            [['reason'], 'string'],
            [['amount'], 'number'],
            [['payment_method', 'invoice_id', 'status'], 'integer'],
            [['payment_no', 'payee_name', 'payee_phone'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = Payment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'params' => $params,
                'defaultOrder' => ['updated_at' => SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'payment_no', $this->payment_no])
            ->andFilterWhere(['like', 'payee_name', $this->payee_name])
            ->andFilterWhere(['like', 'payee_phone', $this->payee_phone])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
