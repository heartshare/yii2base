<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;

/**
 * This is the model class for table "base_user_group".
 *
 * @property string $id
 * @property string $store
 * @property string $zone
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property integer $status
 *
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status'], 'integer'],
            [['store', 'zone'], 'string', 'max' => 64],
            [['name', 'icon'], 'string', 'max' => 255],
            [['zone', 'name', 'store'], 'unique', 'targetAttribute' => ['zone', 'name', 'store'], 'message' => 'The combination of Store, Zone and Name has already been taken.']
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
            'zone' => Yii::t('base', 'Zone'),
            'name' => Yii::t('base', 'Name'),
            'description' => Yii::t('base', 'Description'),
            'icon' => Yii::t('base', 'Icon'),
            'status' => Yii::t('base', 'Status'),
        ];
    }
}
