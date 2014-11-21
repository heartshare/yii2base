<?php

namespace gxc\yii2base\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gxc\yii2base\models\user\User;

/**
 * UserSearch represents the model behind the search form about `gxc\yii2base\models\user\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['store', 'email'], 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'store', $this->store])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
