<?php

return [
	
	'prefix' => 'base:',

	'general' => [
		// Models Class ans Store cache keys
		'models' => ['ge:models:', 0],
		'localization' => ['ge:localization', 0],
		'modules' => ['ge:modules', 0]
	],

	'menu' => [
		// Merged Menu for Admin Backend Zone
		'admin' => ['mn:ad:', 0],

		// Merged Menu of Site Frontend Zone
		'site' => ['mn:s:', 0]
	],

	'tenant' => [

		// All Tenants
		'all' => ['tn:all:', 0],

		//Combine with :tenant_id - Keys Store Page Detail of Tenant Based on Tenant Id
		'detail_id' => ['tn:dt:id:', 0],

		//Combine with :tenant_domain - Keys Store Page Detail of Tenant Based on Tenant Domain
		'detail_domain' => ['tn:dt:domain:',0]

	],
	
	'setting' => [

		// Keys Store All Settings of Tenant
		'all' => ['st:all:', 0],

		//Combine with :group:key:storage_id - Keys Store All Settings of Tenant
		'setting_tenant_all' => ['st:tn:all:', 0],

		//Combine with :group:key:storage_id - Keys Store Detail of Setting
		'setting_tenant_detail' => ['st:tn:dt:', 7200],
	],
	
	'resource' => [
		// Keys Store All Resource Storages	
		'all' => ['rs:all:', 0],		

		// Combine with :detail Keys Store Detail Content Type
		'detail' => ['rs:dt:', 0],
	],

	'language' => [
		// Key of available languages
		'all_id' => ['lang:all:id:', 0],

		// Key of available languages
		'all_code' => ['lang:all:code:', 0],				
	],


];
