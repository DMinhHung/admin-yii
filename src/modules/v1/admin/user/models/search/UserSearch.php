<?php

namespace app\modules\v1\admin\user\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\admin\user\models\User;

/**
 * UserSearch represents the model behind the search form of `app\modules\v1\admin\user\models\User`.
 */
class UserSearch extends User
{

    public $firstname;
    public $lastname;
    public $gender;
    public $role_input;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'is_verify'], 'integer'],
            [['access_token', 'token', 'auth_key', 'email', 'username', 'oauth_client', 'oauth_client_user_id', 'password_hash', 'logged_at', 'created_at', 'updated_at', 'lastname', 'firstname', 'gender', 'role_input'], 'safe'],
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
        $query = User::find()
            ->joinWith("profile")
            ->joinWith("authAssignment")
            ->notDelete()
            ->groupBy("users.id");
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'params' => $params,
                'defaultOrder' => ['updated_at' => SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'users.id' => $this->id,
            'status' => $this->status,
            'is_verify' => $this->is_verify,
            'logged_at' => $this->logged_at,
            'users.created_at' => $this->created_at,
            'users.updated_at' => $this->updated_at,
            'user_profiles.firstname' => $this->firstname,
            "user_profiles.lastname" => $this->lastname,
            'auth_assignment.item_name' => $this->role_input
        ]);

        $query
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'oauth_client', $this->oauth_client])
            ->andFilterWhere(['like', 'oauth_client_user_id', $this->oauth_client_user_id]);

        return $dataProvider;
    }
}
