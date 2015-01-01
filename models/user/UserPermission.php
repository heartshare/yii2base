<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;
use gxc\yii2base\classes\TbActiveRecord;

/**
 * This is the model class for table "base_user_permission".
 *
 * @property string $id
 * @property string $store
 * @property integer $user_id
 * @property string $item_name
 * @property datetime $date_created
 * 
 * 
 * @author  Triet Nguyen <minhtriet1989@gmail.com>
 * @since  2.0
 */
class UserPermission extends TbActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
            [['user_id'], 'integer'],
            [['store'], 'string', 'max' => 64],
            [['item_name'], 'string', 'max' => 128],
            [['store', 'user_id'], 'unique', 'targetAttribute' => ['store', 'user_id'], 'message' => 'The combination of Store and User ID has already been taken.']
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
            'user_id' => Yii::t('base', 'User ID'),
            'item_name' => Yii::t('base', 'Item Name'),
            'date_created' => Yii::t('base', 'Date Created'),
        ];
    }
}
