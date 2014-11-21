<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;

/**
 * This is the model class for table "base_user_display".
 *
 * @property string $id
 * @property string $store
 * @property string $zone
 * @property string $user_id
 * @property string $screen_name
 * @property string $display_name
 * @property string $tagline
 * @property string $avatar
 * 
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserDisplay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_display';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['store', 'zone'], 'string', 'max' => 64],
            [['screen_name', 'display_name'], 'string', 'max' => 128],
            [['tagline', 'avatar'], 'string', 'max' => 255],
            [['store', 'user_id', 'zone'], 'unique', 'targetAttribute' => ['store', 'user_id', 'zone'], 'message' => 'The combination of Store, Zone and User ID has already been taken.']
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
            'user_id' => Yii::t('base', 'User ID'),
            'screen_name' => Yii::t('base', 'Screen Name'),
            'display_name' => Yii::t('base', 'Display Name'),
            'tagline' => Yii::t('base', 'Tagline'),
            'avatar' => Yii::t('base', 'Avatar'),
        ];
    }
}
