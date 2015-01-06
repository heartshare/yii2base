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
 * This is the model class for table "base_user_profile".
 *
 * @property string $id
 * @property string $store
 * @property string $zone
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property integer $gender
 * @property string $location
 * @property string $company
 * @property string $bio
 * @property datetime $registered_at
 * 
 * 
 * @author  Triet Nguyen <minhtriet1989@gmail.com>
 * @since  2.0
 */
class UserProfile extends TbActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
            [['user_id', 'gender'], 'integer'],
            [['store', 'zone'], 'string', 'max' => 64],
            [['first_name', 'last_name'], 'string', 'max' => 128],
            [['store', 'user_id', 'zone'], 'unique', 'targetAttribute' => ['store', 'user_id', 'zone'], 'message' => 'The combination of Store, Zone and User ID has already been taken.'],
            [['birthday'], 'safe']
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
            'first_name' => Yii::t('base', 'First Name'),
            'last_name' => Yii::t('base', 'Last Name'),
            'gender' => Yii::t('base', 'Gender'),
            'location' => Yii::t('base', 'Location'),
            'company' => Yii::t('base', 'Company'),
            'birthday' => Yii::t('base', 'Birthday'),
            'bio' => Yii::t('base', 'Bio'),
        ];
    }
}
