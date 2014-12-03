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
 * This is the model class for table "base_user".
 *
 * @property string $id
 * @property string $store
 * @property string $email
 * 
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class User extends TbActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store', 'email'], 'required'],
            [['store'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 128],
            [['store', 'email'], 'unique', 'targetAttribute' => ['store', 'email'], 'message' => \Yii::t('base','Email has already been taken.')]
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
            'email' => Yii::t('base', 'Email'),
        ];
    }

    /**
     * Finds user by email
     *
     * @param string Email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

}
