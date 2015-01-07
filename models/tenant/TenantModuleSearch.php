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

/**
 * TenantModuleSearch represents the model behind the search form about `gxc\yii2base\models\tenant\TenantModule`.
 *
 * @author  Tung Mang Vien<tungmv7@gmail.com>
 * @since  2.0
 */
class TenantModuleSearch extends Tenant
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
        // params['id'] is tenant id - required to load all modules of this tenant
        if (isset($params['id'])) {
            $tenantClass = Yii::$app->tenant->createModel('Tenant');
            // find tenant
            $tenant = $tenantClass::findOne(['id' => $params['id']]);
            if (!empty($tenant)) {
                $tenantModuleClass = Yii::$app->tenant->createModel('TenantModule');
                // get tenant module store settings
                $tenantModuleStore = \Yii::$app->tenant->getModel((new \ReflectionClass($tenantModuleClass))->getShortName(), 'store');
                // find tenant module
                $query = $tenantModuleClass::find();
                $query->andWhere(['store' => $tenant->$tenantModuleStore]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 10
                    ]
                ]);
                if (!($this->load($params) && $this->validate())) {
                    return $dataProvider;
                }
                return $dataProvider;
            } else
                return false;
        } else {
            return false;
        }
    }
}
