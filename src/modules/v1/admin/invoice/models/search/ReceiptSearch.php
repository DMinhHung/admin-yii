<?php


namespace app\modules\v1\admin\invoice\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\admin\invoice\models\Receipt;

class ReceiptSearch extends Receipt
{
    public function rules()
    {
        return [
            [['receipt_no', 'date', 'email', 'payer_name', 'payer_phone', 'reason', 'amount', 'payment_method', 'invoice_id', 'start_date', 'status'], 'default', 'value' => null],
            [['date'], 'safe'],
            [['reason'], 'string'],
            [['amount'], 'number'],
            [['payment_method', 'invoice_id', 'start_date', 'status'], 'integer'],
            [['receipt_no', 'email', 'payer_name', 'payer_phone'], 'string', 'max' => 255]
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
        $query = Receipt::find();

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

        $query->andFilterWhere(['like', 'receipt_no', $this->receipt_no])
            ->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'payer_phone', $this->payer_phone])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
