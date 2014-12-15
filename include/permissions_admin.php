<?php
// Base Module Admin Permissions
return [	
	
	// Permission Items
	'items' => [		

		// Tenant Actions
		'base.admin.tenant.create' => [
			'description' => 'Add a Tenant',
		],
		'tenant.update' => [
			'description' => 'Update Tenant',
		],
		'tenant.delete' => [
			'description' => 'Delete Tenant',
		],		
		'tenant.index' => [
			'description' => 'View Tenant',
		],
		'tenant.*' => [
			'description' => 'All Tenant actions',
		],

		// User Actions
		'user.create' => [
			'description' => 'Add a User',
		],
		'user.update' => [
			'description' => 'Update User',
		],
		'user.delete' => [
			'description' => 'Delete User',
		],		
		'user.index' => [
			'description' => 'View User',
		],
		'user.*' => [
			'description' => 'All User actions',
		],
						
	],

	// Permission Roles
	'roles' => [		
		'app.superAdmin' => [
			'description' => 'Super Admin',			
		],
		'app.admin' => [
			'description' => 'Admin',
			'children' => [
				'tenant.*',
				'user.*',
			]
		],		
	],	
];

