<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\tenant;

use Yii;
use yii\helpers\BaseFormatConverter;
use yii\helpers\Html;
use yii\i18n\I18N;
use yii\web\View;

use gxc\yii2base\classes\TbActiveRecord;
use gxc\yii2base\helpers\BaseHelper;
use gxc\yii2base\helpers\UtilHelper;

/**
 * This is the model class for table "base_tenant_module".
 *
 * @author  Triet Nguyen <minhtriet1989@gmail.com>
 * @since  2.0
 */
class TenantModule extends TbActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_tenant_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permissions'], 'string'],
            [['expiry_mode', 'status'], 'integer'],
            [['expired_at'], 'safe'],
            [['store', 'module', 'plan'], 'string', 'max' => 64],
            [['store', 'module'], 'unique', 'targetAttribute' => ['store', 'module'], 'message' => 'The combination of Store and Module has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base', 'ID'),
            'store' => Yii::t('base', 'Store'),
            'module' => Yii::t('base', 'Module'),
            'plan' => Yii::t('base', 'Plan'),
            'permissions' => Yii::t('base', 'Permissions'),
            'expiry_mode' => Yii::t('base', 'Expired Mode'),
            'expired_at' => Yii::t('base', 'Expired At'),
            'status' => Yii::t('base', 'Status'),
        ];
    }
}
