<?php


namespace app\modules\v1\admin\news\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\admin\news\models\News;

class NewsSearch extends News
{
    public function rules()
    {
        return [
            [['title', 'slug', 'content', 'status'], 'safe'],
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
        $query = News::find()->andWhere(["<>", "status", News::STATUS_DELETED]);

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
            'slug' => $this->slug,
            "status" => $this->status,
            'users.created_at' => $this->created_at,
            'users.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
