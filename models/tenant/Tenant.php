<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\tenant;

use gxc\yii2base\classes\TbActiveRecord;
use gxc\yii2base\components\Hashids;
use gxc\yii2base\helpers\UtilHelper;
use Yii;

/**
 * This is the model class for table "base_tenant".
 *
 * @author  Tung Mang Vien<tungmv7@gmail.com>
 * @since  2.0
 */
class Tenant extends TbActiveRecord
{
    // define tenant status constant
    const TENANT_STATUS_INACTIVE = 0;
    const TENANT_STATUS_ACTIVE = 1;

    const TENANT_HASH_TOKEN = '28A053DAD374';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_tenant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['app_store', 'content_store', 'resource_store'], 'string', 'max' => 64],
            [['name', 'domain', 'system_domain', 'logo'], 'string', 'max' => 128],
            [['app_store', 'domain', 'system_domain'], 'unique'],
            [['domain', 'system_domain'], 'url'],
            [['name', 'domain', 'system_domain', 'status', 'app_store', 'content_store', 'resource_store'],'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base', 'ID'),
            'app_store' => Yii::t('base', 'App Store'),
            'content_store' => Yii::t('base', 'Content Store'),
            'resource_store' => Yii::t('base', 'Resource Store'),
            'name' => Yii::t('base', 'Name'),
            'domain' => Yii::t('base', 'Domain'),
            'system_domain' => Yii::t('base', 'System Domain'),
            'logo' => Yii::t('base', 'Logo'),
            'status' => Yii::t('base', 'Status'),
        ];
    }

    /**
     * pre-init tenant store if empty
     *
     * @return bool|void
     */
    public function beforeValidate()
    {
        parent::beforeValidate();

        // generate encrypt id by time
        $hashIds = new Hashids(self::TENANT_HASH_TOKEN, 17);
        $encryptId = $hashIds->encrypt(time());

        // init app store code
        if(empty($this->app_store))
            $this->app_store = 'a.' . $encryptId;
        // init content store code
        if(empty($this->content_store))
            $this->content_store = 'c.' . $encryptId;
        // init resource store code
        if(empty($this->resource_store))
            $this->resource_store = 'r.' . $encryptId;

        return true;
    }

    /**
     * get all tenant store information by app | content | resource
     *
     * @param $which
     * @return array
     */
    public static function getTenantStores($which, $model = false)
    {
        $appStores = [];

        switch ($which) {
            case 'app':
                if ($model != false) {
                    $ternant = TenantSearch::findOne(['id' => $model->id]);
                    if (!empty($ternant))
                        $appStores[$ternant->app_store] = $ternant->name . ' - ' . $ternant->app_store;
                }
                break;

            case 'content':
                $tenantSearch = TenantSearch::findAll(['status' => self::TENANT_STATUS_ACTIVE]);
                foreach ($tenantSearch as $ternant) {
                    $appStores[$ternant->content_store] = $ternant->name . ' - ' . $ternant->content_store;
                }
                break;

            case 'resource':
                $tenantSearch = TenantSearch::findAll(['status' => self::TENANT_STATUS_ACTIVE]);
                foreach ($tenantSearch as $ternant) {
                    $appStores[$ternant->resource_store] = $ternant->name . ' - ' . $ternant->resource_store;
                }
                break;
        }

        return $appStores;

    }

    public static function renderTenantStatus($state)
    {
        switch($state) {
            case self::TENANT_STATUS_ACTIVE:
                return '<span class="label label-as-badge label-success">' . Yii::t('base', 'Active') . '</span>';

            case self::TENANT_STATUS_INACTIVE:
                return '<span class="label label-as-badge label-danger">' . Yii::t('base', 'Inactive') . '</span>';

            default:
                return '';
        }
    }

    /**
     * get all tenant statuses
     *
     * @return array
     */
    public static function getTenantStatuses()
    {
        return [
            self::TENANT_STATUS_ACTIVE => Yii::t('base', 'Active'),
            self::TENANT_STATUS_INACTIVE => Yii::t('base', 'Inactive'),
        ];
    }
}
