<?php

namespace gxc\yii2base\models\tenant;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gxc\yii2base\models\tenant\Tenant;

/**
 * TenantSearch represents the model behind the search form about `gxc\yii2base\models\tenant\Tenant`.
 */
class TenantSearch extends Tenant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['app_store', 'content_store', 'resource_store', 'name', 'domain', 'system_domain', 'logo'], 'safe'],
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
        $query = Tenant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'app_store', $this->app_store])
            ->andFilterWhere(['like', 'content_store', $this->content_store])
            ->andFilterWhere(['like', 'resource_store', $this->resource_store])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'system_domain', $this->system_domain])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}
