<?php

namespace app\modules\v1\end_user\cart\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\end_user\cart\models\Cart;
class CartSearch extends Cart
{
    public function rules()
    {
        return [
            [['customer_id', 'session_id', 'status'], 'safe'],
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
        $query = Cart::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'users.id' => $this->id,
            "status" => $this->status,
            'users.created_at' => $this->created_at,
            'users.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
