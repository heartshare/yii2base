<?php

return [
	// Tenant Models	
	'Tenant' => [
		'class' => 'gxc\yii2base\models\tenant\Tenant',
		'store' => false
	],
	'TenantSearch' => [
		'class' => 'gxc\yii2base\models\tenant\TenantSearch',
		'store' => false
	],
	'TenantAccess' => [
		'class' => 'gxc\yii2base\models\tenant\TenantAccess',
		'store' => 'content'
	],
	'TenantModule' => [
		'class' => 'gxc\yii2base\models\tenant\TenantModule',
		'store' => 'content'
	],	

	// User Models
	'User' => [
		'class' => 'gxc\yii2base\models\user\User',
		'store' => 'content'
	],
	'UserSearch' => [
		'class' => 'gxc\yii2base\models\user\UserSearch',
		'store' => 'content'
	],
	'UserConfirmation' => [
		'class' => 'gxc\yii2base\models\user\UserConfirmation',
		'store' => 'content'
	],
	'UserIdentity' => [
		'class' => 'gxc\yii2base\models\user\UserIdentity',
		'store' => 'content'
	],
	'UserLogin' => [
		'class' => 'gxc\yii2base\models\user\UserLogin',
		'store' => 'content'
	],
	'UserGroup' => [
		'class' => 'gxc\yii2base\models\user\UserGroup',
		'store' => 'content'
	],	
	'UserGroupAssign' => [
		'class' => 'gxc\yii2base\models\user\UserGroupAssign',
		'store' => 'content'
	],	
];
