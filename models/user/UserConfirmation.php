<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;

/**
 * This is the model class for table "base_user_confirmation".
 *
 * @property string $id
 * @property string $store
 * @property string $zone
 * @property string $user_id
 * @property string $type
 * @property string $token
 * @property string $generated_at
 * @property string $recorded_at
 * @property string $expired_at
 * @property integer $status
 * 
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserConfirmation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_confirmation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'generated_at', 'recorded_at'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['generated_at', 'recorded_at', 'expired_at'], 'safe'],
            [['store', 'zone'], 'string', 'max' => 64],
            [['type'], 'string', 'max' => 128],
            [['token'], 'string', 'max' => 255],
            [['store', 'token'], 'unique', 'targetAttribute' => ['store', 'token'], 'message' => 'The combination of Store and Token has already been taken.']
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
            'type' => Yii::t('base', 'Type'),
            'token' => Yii::t('base', 'Token'),
            'generated_at' => Yii::t('base', 'Generated At'),
            'recorded_at' => Yii::t('base', 'Recorded At'),
            'expired_at' => Yii::t('base', 'Expired At'),
            'status' => Yii::t('base', 'Status'),
        ];
    }
}
