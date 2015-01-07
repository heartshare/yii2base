<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */
namespace gxc\yii2base\models\tenant;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gxc\yii2base\models\tenant\Tenant;

/**
 * Tenant Search | use to search on Tenant
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class TenantSearch extends Tenant
{
    public $keywords;
    public $field;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['keywords', 'string'],
            ['field', 'string']
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
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        if (!empty($this->keywords))
            switch ($this->field) {
                case 'name':
                    $query->andFilterWhere(['like', 'name', $this->keywords]);
                    break;

                case 'domain':
                    $query->andFilterWhere(['like', 'domain', $this->keywords]);
                    break;

                case 'system_domain':
                    $query->andFilterWhere(['like', 'system_domain', $this->keywords]);
                    break;

                default:
                    $query->orFilterWhere(['like', 'name', $this->keywords]);
                    $query->orFilterWhere(['like', 'domain', $this->keywords]);
                    $query->orFilterWhere(['like', 'system_domain', $this->keywords]);
            }


        if ($this->status == 'active')
            $query->andFilterWhere(['status' => Tenant::TENANT_STATUS_ACTIVE]);
        elseif ($this->status == 'inactive')
            $query->andFilterWhere(['status' => Tenant::TENANT_STATUS_INACTIVE]);

        return $dataProvider;
    }

    public function getTenantSearchFields()
    {
        return [
            'all' => Yii::t('base', 'All'),
            'name' => Yii::t('base', 'Name'),
            'domain' => Yii::t('base', 'Domain'),
            'system_domain' => Yii::t('base', 'System Domain'),
        ];
    }
}
