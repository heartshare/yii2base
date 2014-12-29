<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\tenant;
use yii\base\Model;
use Yii;

/**
 * TenantContact
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class TenantContactForm extends Model{

    public $first_name;
    public $last_name;
    public $email;
    public $company_name;
    public $address_1;
    public $address_2;
    public $city;
    public $state;
    public $postal_code;
    public $country;
    public $phone_1;
    public $phone_2;
    public $description;

    public function rules()
    {
        return [
            [['postal_code'], 'integer'],
            [['first_name', 'last_name', 'email', 'company_name', 'description', 'state', 'city'], 'string'],
            [['postal_code', 'phone_2', 'phone_1'], 'string', 'max' => 64],
            [['first_name', 'last_name', 'email', 'company_name'], 'string', 'max' => 128],
            [['first_name', 'last_name', 'email', 'company_name', 'address_1', 'city', 'country', 'phone_1'], 'required'],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('base', 'First Name'),
            'last_name' => Yii::t('base', 'Last Name'),
            'email' => Yii::t('base', 'Email'),
            'company_name' => Yii::t('base', 'Company Name'),
            'address_1' => Yii::t('base', 'Address 1'),
            'address_2' => Yii::t('base', 'Address 2'),
            'city' => Yii::t('base', 'City'),
            'state' => Yii::t('base', 'State'),
            'postal_code' => Yii::t('base', 'Postal Code'),
            'country' => Yii::t('base', 'Country'),
            'phone_1' => Yii::t('base', 'Phone number 1'),
            'phone_2' => Yii::t('base', 'Phone number 2'),
            'description' => Yii::t('base', 'Description'),
        ];
    }
}