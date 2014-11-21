<?php

namespace gxc\yii2base\models\tenant;

use Yii;

/**
 * This is the model class for table "base_tenant".
 *
 * @property string $id
 * @property string $app_store
 * @property string $content_store
 * @property string $resource_store
 * @property string $name
 * @property string $domain
 * @property string $system_domain
 * @property string $logo
 * @property integer $status
 */
class Tenant extends \yii\db\ActiveRecord
{
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
            [['app_store'], 'unique'],
            [['domain'], 'unique'],
            [['system_domain'], 'unique']
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

    public static function tenantStatuses()
    {
        return [
            '1' => Yii::t('base', 'Active'),
            '0' => Yii::t('base', 'Disabled'),            
        ];
    }
}
