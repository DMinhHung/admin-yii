<?php

namespace app\modules\v1\admin\brand\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\admin\brand\models\Brand;
class BrandSearch extends Brand
{
    public function rules()
    {
        return [
            ['name', 'string'],
            ['status', 'integer'],
            [['name', 'slug', 'description', 'logo', 'status'], 'safe'],
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
        $query = Brand::find();

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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            "status" => $this->status,
            'users.created_at' => $this->created_at,
            'users.updated_at' => $this->updated_at,
        ]);
        return $dataProvider;
    }
}
