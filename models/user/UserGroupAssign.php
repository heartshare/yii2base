<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;

/**
 * This is the model class for table "base_user_group_assign".
 *
 * @property string $id
 * @property string $store
 * @property string $group_id
 * @property string $user_id
 * 
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserGroupAssign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_group_assign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'user_id'], 'required'],
            [['group_id', 'user_id'], 'integer'],
            [['store'], 'string', 'max' => 64]
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
            'group_id' => Yii::t('base', 'Group ID'),
            'user_id' => Yii::t('base', 'User ID'),
        ];
    }
}
