<?php

namespace app\modules\v1\admin\customer\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\admin\customer\models\Shift;

class ShiftSearch extends Shift
{
    public function rules()
    {
        return [
            [['name', 'start_time', 'end_time', 'checkin_start', 'checkin_end', 'duration'], 'safe'],
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
        $query = Shift::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'start_time', $this->start_time])
            ->andFilterWhere(['like', 'end_time', $this->end_time])
            ->andFilterWhere(['like', 'checkin_start', $this->checkin_start])
            ->andFilterWhere(['like', 'checkin_end', $this->checkin_end]);

        return $dataProvider;
    }
}
