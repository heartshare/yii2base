<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\tenant;

use gxc\yii2base\models\user\User;
use \Yii;
use yii\base\Model;

/**
 * TenantForm
 * use for Tenant new/update form
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class TenantForm extends Model{

    // tenant base
    public $id;
    public $name;
    public $domain;
    public $system_domain;
    public $status;

    public $app_store;
    public $content_store;
    public $resource_store;

    public $logo;

    // tenant profile;
    public $email;

    public function rules()
    {
        return [
            [['status', 'id'], 'integer'],
            [['app_store', 'content_store', 'resource_store'], 'string', 'max' => 64],
            [['name', 'domain', 'system_domain', 'logo'], 'string', 'max' => 128],
            [['domain', 'system_domain'], 'url'],
            [['name', 'domain', 'system_domain', 'status', 'email'], 'required'],
            [['email'], 'email'],
            [['email'], 'validateOwnerEmail'],
            [['app_store', 'content_store', 'resource_store'], 'required', 'on' => 'update']
        ];
    }

    public function validateOwnerEmail()
    {
        if(!$this->hasErrors()){
            $user = User::findOne(['email' => trim($this->email)]);
            if(!$user)
                $this->addError('email', 'Do not have any account match with this email.');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base', 'ID'),
            'app_store' => Yii::t('base', 'App Store'),
            'content_store' => Yii::t('base', 'Content Store'),
            'resource_store' => Yii::t('base', 'Resource Store'),
            'name' => Yii::t('base', 'Name'),
            'domain' => Yii::t('base', 'Domain'),
            'system_domain' => Yii::t('base', 'System Domain'),
            'logo' => Yii::t('base', 'Logo'),
            'status' => Yii::t('base', 'Status'),
            'email' => Yii::t('base', 'Account Owner Email'),
        ];
    }


}