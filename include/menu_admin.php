<?php

return [
		
		'dashboard' => [
			'label' => \Yii::t('base', 'Dashboard'),
			'url' => ['/home/index'],
			'order' => 1,
			'icon' => 'dashboard',
		],	

		'divider_1' => [
			'label' => 'divider',
			'order' => 2,
			'options' => ['class'=>'divider']
		],			

		// Users
		'users' => [
			'label' => \Yii::t('base', 'Users'),
			'url' => '#',
			'order' => 3,
			'icon' => 'users',
			'items' => [
				'add_user' => [
					'label' => \Yii::t('base', 'Add new'),
					'url' => ['/base/admin/user/create'],
					'order' => 1,
					
				],
				'index_user' => [
					'label' => \Yii::t('base', 'All Users'),
					'url' => ['/base/admin/user/index'],
					'order' => 2,					
				]
			],

		],

		// Tenants
		'tenants' => [
			'label' => \Yii::t('base', 'Tenants'),
			'url' => '#',
			'order' => 4,
			'icon' => 'globe',			
			'items' => [
				'add_tenant' => [
					'label' => \Yii::t('base', 'Add New'),
					'url' => ['/base/admin/tenant/create'],
					'order' => 1,					
				],
				'index_tenant' => [
					'label' => \Yii::t('base', 'All Tenants'),
					'url' => ['/base/admin/tenant/index'],
					'order' => 2,					
				]

			]
		],

		'divider_2' => [
			'label' => 'divider',
			'order' => 5,
			'options' => ['class'=>'divider']
		],

		// Resources
		'resources' => [
			'label' => \Yii::t('base', 'Resources'),
			'url' => '#',
			'order' => 6,
			'icon' => 'picture-o',
			'items' => [
				'add_resource' => [
					'label' => \Yii::t('base', 'Add New'),
					'url' => ['/base/admin/resource/create'],
					'order' => 1,
					
				],
				'index_resource' => [
					'label' => \Yii::t('base', 'All Resources'),
					'url' => ['/base/admin/resource/index'],
					'order' => 2,
					
				],
			]
		],

		// Settings
		'settings' => [
			'label' => \Yii::t('base', 'Settings'),
			'url' => '#',
			'order' => 7,
			'icon' => 'gears',
			'items' => [
				'general_settings' => [
					'label' => \Yii::t('base', 'General'),
					'url' => ['/base/admin/setting', 'type'=>'app_general_settings'],
					'order' => 1,					
				]

			]
		]
];
