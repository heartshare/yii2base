<?php
// Base Module Admin Permissions
return [	
	
	// Permission Items
	'items' => [		

		// Tenant Actions
		'tenant.*' => [
			'description' => 'Add actions of Tenant',
		],
		'tenant.create' => [
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
		'user.*' => [
			'description' => 'All actions of User',
		],
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

		// Sample Rule
		// 'sample.Rule' => [
		// 	'description' => 'Sample structure for rule saving',
		// 	'ruleName' => 'sampleRule',
		// 	'ruleClass' => 'gxc\yii2base\permissions\rules\SampleRule',
		// ]
	],

	// Permission Roles
	'roles' => [		
		'superAdmin' => [
			'description' => 'Super Admin',			
		],
		'admin' => [
			'description' => 'Admin',
			'children' => [
				'tenant.*',
				'user.*',
			]
		]
	],	
];

