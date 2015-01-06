<?php

return [
	// Tenant Models	
	'Tenant' => [
		'class' => 'gxc\yii2base\models\tenant\Tenant',
		'store' => ''
	],
    'TenantForm' => [
        'class' => 'gxc\yii2base\models\tenant\TenantForm',
        'store' => ''
    ],
	'TenantContactForm' => [
		'class' => 'gxc\yii2base\models\tenant\TenantContactForm',
		'store' => ''
	],
    'TenantProfile' => [
        'class' => 'gxc\yii2base\models\tenant\TenantProfile',
        'store' => ''
    ],
	'TenantSearch' => [
		'class' => 'gxc\yii2base\models\tenant\TenantSearch',
		'store' => ''
	],
	'TenantAccess' => [
		'class' => 'gxc\yii2base\models\tenant\TenantAccess',
		'store' => 'content_store'
	],
	'TenantModule' => [
		'class' => 'gxc\yii2base\models\tenant\TenantModule',
		'store' => 'content_store'
	],
	'TenantModuleSearch' => [
		'class' => 'gxc\yii2base\models\tenant\TenantModuleSearch',
	],

	// User Models
	'User' => [
		'class' => 'gxc\yii2base\models\user\User',
		'store' => 'content_store'
	],
	'UserSearch' => [
		'class' => 'gxc\yii2base\models\user\UserSearch',
		'store' => 'content_store'
	],
	'UserConfirmation' => [
		'class' => 'gxc\yii2base\models\user\UserConfirmation',
		'store' => 'content_store'
	],
	'UserIdentity' => [
		'class' => 'gxc\yii2base\models\user\UserIdentity',
		'store' => 'content_store'
	],
	'UserLogin' => [
		'class' => 'gxc\yii2base\models\user\UserLogin',
		'store' => 'content_store'
	],
	'UserDisplay' => [
		'class' => 'gxc\yii2base\models\user\UserDisplay',
		'store' => 'content_store'
	],	
	'UserGroup' => [
		'class' => 'gxc\yii2base\models\user\UserGroup',
		'store' => 'content_store'
	],	
	'UserGroupAssign' => [
		'class' => 'gxc\yii2base\models\user\UserGroupAssign',
		'store' => 'content_store'
	],	
	'BackendLoginForm' => [
		'class' => 'gxc\yii2base\models\user\BackendLoginForm',
		'store' => ''
	],

	// Address Models
	'Address' => [
		'class' => 'gxc\yii2base\models\address\Address',
		'store' => ''
	]

];
