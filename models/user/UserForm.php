<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use \Yii;
use \yii\base\Model;

/**
 * Using for User new/update form
 *
 * @author Triet Nguyen <minhtriet1989@gmail.com>
 * @since 2.0
 */
class UserForm extends Model{

    // User base
    public $id;
    public $email;
    public $store;
    public $first_name;
    public $last_name;
    public $display_name;
    public $screen_name;
    public $password;
    public $zone;
    public $staff_zone;
    public $guest_zone;
    public $status;

    // User profile
    public $gender;
    public $location;
    public $timezone;
    public $birthdate;
    public $bio;

    public function rules()
    {
        return [
            [['status', 'id', 'gender'], 'integer'],
            [['first_name', 'last_name', 'display_name', 'screen_name'], 'string', 'max' => 128],
            [['store' ,'location'], 'string', 'max' => 64],
            [['email', 'status', 'zone'], 'required'],
            [['email'], 'email'],
            [['store'], 'required', 'on' => 'update']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('base', 'ID'),
            'first_name' => \Yii::t('base', 'First Name'),
            'last_name' => \Yii::t('base', 'Last Name'),
            'display_name' => \Yii::t('base', 'Display Name'),
            'screen_name' => \Yii::t('base', 'Screen Name'),
            'password' => \Yii::t('base', 'Password'),
            'zone' => \Yii::t('base', 'Zone'),
            'staff_zone' => \Yii::t('base', 'Staff Zone Roles'),
            'guest_zone' => \Yii::t('base', 'Guest Zone Roles'),
            'status' => \Yii::t('base', 'Status'),
            'gender' => \Yii::t('base', 'Gender'),
            'location' => \Yii::t('base', 'Location'),
            'timezone' => \Yii::t('base', 'Timezone'),
            'birthdate' => \Yii::t('base', 'Birthdate'),
            'bio' => \Yii::t('base', 'Bio'),
            'store' => \Yii::t('base', 'Store'),
        ];
    }
}