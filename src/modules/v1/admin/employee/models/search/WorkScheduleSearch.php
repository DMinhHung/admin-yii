<?php

namespace app\modules\v1\admin\employee\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\admin\employee\models\WorkSchedule;

class WorkScheduleSearch extends WorkSchedule
{
    public function rules()
    {
        return [
            [['employee_id', 'shift_id', 'work_date', 'repeat_weekly', 'repeat_days', 'end_date', 'apply_holiday', 'copied_from'], 'safe'],
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
        $query = WorkSchedule::find();

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

        $query->andFilterWhere(['like', 'work_date', $this->work_date])
            ->andFilterWhere(['like', 'end_date', $this->end_date]);

        return $dataProvider;
    }
}
