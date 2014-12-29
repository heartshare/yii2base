<?php

namespace gxc\yii2base\models\address;

use Yii;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "{{%base_address}}".
 *
 * @property string $id
 * @property string $store
 * @property string $user_id
 * @property string $country_code
 * @property string $state_code
 * @property string $city_code
 * @property string $company
 * @property string $alias
 * @property string $first_name
 * @property string $last_name
 * @property string $address1
 * @property string $address2
 * @property string $postcode
 * @property string $phone
 * @property string $phone_mobile
 * @property string $registered_as
 * @property string $note
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 */
class Address extends \yii\db\ActiveRecord
{
    const REGISTERED_AS_TENANT_ADDRESS = 1;
    const REGISTERED_AS_USER_INFO = 2;
    const REGISTERED_AS_PRODUCT_SHIPPING = 3;
    const REGISTERED_AS_ORDER_BILLING = 4;

    const ALIAS_ADDRESS_1 = 1;
    const ALIAS_ADDRESS_2 = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%base_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['store', 'country_code', 'state_code', 'city_code', 'alias', 'postcode', 'phone', 'phone_mobile'], 'string', 'max' => 64],
            [['company'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['first_name', 'last_name', 'email', 'address1', 'address2', 'registered_as'], 'string', 'max' => 128],
            [['note'], 'string', 'max' => 500]
        ];
    }

    /**
     * init value before validate form address information
     */
    public function beforeValidate()
    {
        parent::beforeSave($this->isNewRecord);

        if ($this->isNewRecord) {
            $this->created_at = $this->updated_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
            $this->created_by = $this->updated_by= Yii::$app->user->info('id');
        } else {
            $this->updated_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->info('id');
        }
        return true;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store' => Yii::t('app', 'Store'),
            'user_id' => Yii::t('app', 'User ID'),
            'country_code' => Yii::t('app', 'Country Code'),
            'state_code' => Yii::t('app', 'State Code'),
            'city_code' => Yii::t('app', 'City Code'),
            'company' => Yii::t('app', 'Company'),
            'alias' => Yii::t('app', 'Alias'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'postcode' => Yii::t('app', 'Postcode'),
            'phone' => Yii::t('app', 'Phone'),
            'phone_mobile' => Yii::t('app', 'Phone Mobile'),
            'registered_as' => Yii::t('app', 'Registered As'),
            'note' => Yii::t('app', 'Note'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
