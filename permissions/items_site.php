<?php
// Base Module Site Permissions
return [	
	'moduleUniqueId' => 'base',

	// Permission Items
	'items' => [		

		// Home Actions
		'home.login' => [
			'description' => 'Login to Backend Dashboard',
		],
		'home.logout' => [
			'description' => 'Logout System',
		]
	],

	// Permission Roles
	'roles' => [		
		'app.superAdmin' => [
			'description' => 'Super Admin',
			'zone' => 'staff'
		],
		'app.admin' => [
			'description' => 'Admin',
			'children' => [
				'home.login',
				'home.logout'
			],
			'zone' => 'staff'
		],
		'app.user' => [
			'description' => 'User',
			'children' => [
				'home.login',
				'home.logout'
			],
			'zone' => 'guest'
		],		
	],	
];

