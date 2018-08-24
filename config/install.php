<?php 
	require 'config.php';

	/*Create DataBase (Only for LOCALHOST)*/
	Table::createBD('ennavidad_bd');	
	/* #Database */

/* =======================================================
    *	
    *	TABLES FROM PROYECT ------------------->
    *	
   		$table[] = [
		    'name' => Table Name,
		    'cols' => [
			        [0,1,2,3,4,5,6,7],***
			        [0,1,2,3,4,5,6,7],
			        ...
			     ],
		    'foreign' => ['self col','other_table(other_table_col)'], (OPTIONAL)
		];

    ***	$col = [		
				0 => NAME ROW = 'string',
				1 => $type = (VARCHAR(30),INT(10),DATETIME()...),
				2 => UNSIGNED = false (DEFAULT),
				3 => NOT NULL = false (DEFAULT),
				4 => UNIQUE = false (DEFAULT),
				5 => AUTOINCREMENT = false (DEFAULT),
				6 => PRIMARY_KEY = false (DEFAULT),
				7 => $default = '' (EMPTY BY DEFAULT)
		]
    *
======================================================= */

/* ==============  TABLES  ============= */
	$table = [];

	/*-- USERS --*/
		$tables[] = [
			'name' => 'cities',
			'cols' => [
				['id_city','SMALLINT(5)',true,true,false,false,true,''],
				['city','VARCHAR(50)',false,true,false,false,false,''],
			]
		];
		$table[] = [
		    'name' => 'user_rols',
		    'cols' => [
			        ['id_rol','TINYINT(2)',true,false,false,true,true,''],
			        ['type','VARCHAR(20)',false,true,true,false,false,''],
			        ['tm_delete','DATETIME',false,false,false,false,false,'']
			    ],
		];

		$table[] = [ 
		    'name' => 'users',
		    'cols' => [
			        ['id_user','INT(11)',true,true,false,true,true,''],
			        ['name','VARCHAR(80)',false,true,false,false,false,''],
			        ['last_name','VARCHAR(80)',false,true,false,false,false,''],
			        ['mail','VARCHAR(60)',false,true,true,false,false,''],
			        ['password','VARCHAR(32)',false,true,false,false,false,''],
			        ['id_rol','TINYINT(1)',true,true,false,false,false,3],
			        ['activation','TINYINT(1)',true,true,false,false,false,9],
			        ['tm_create','DATETIME',false,false,false,false,false,'CURRENT_TIMESTAMP'],
			        ['tm_delete','DATETIME',false,false,false,false,false,'']
			    ],
		    'foreign' => [['id_rol','user_rols(id_rol)']],
		];

		$table[] = [
			'name' => 'users_addresses',
			'cols' => [
					['id_address','INT(11)',true,false,false,true,true,''],
			        ['id_user','INT(11)',true,true,true,false,false,''],
					['address_name','VARCHAR(35)',false,true,false,false,false,''],
					['address_last_name','VARCHAR(35)',false,true,false,false,false,''],
					['id_city','SMALLINT(5)',true,true,false,false,false,''],
					['address','VARCHAR(40)',false,true,false,false,false,''],
					['phone','BIGINT(15)',true,true,false,false,false,''],
			        ['tm_delete','DATETIME',false,false,false,false,false,'']
				],
		    'foreign' => [
		    	['id_user','users(id_user)'],
		    	['id_city','cities(id_city)'],
		    ],
		];


		$table[] = [
		    'name' => 'users_logs',
		    'cols' => [
			        ['id_logs','INT(11)',true,false,false,true,true,''],
			        ['id_user','INT(11)',true,true,true,false,false,''],
			        ['num_logs','TINYINT(2)',true,true,false,false,false,''],
			        ['tm_delete','DATETIME',false,false,false,false,false,'']
			    ],
		    'foreign' => [['id_user','users(id_user)']],
		];
		$table[] = [
			'name' => 'users_psw_restore',
			'cols' => [
					['id_psw_restore','INT(11)',true,true,false,true,true,''],
					['mail','VARCHAR(100)',false,true,true,false,false,''],
					['token','VARCHAR(40)',false,true,false,false,false,''],
					['tm_create','DATETIME',false,true,false,false,false,'CURRENT_TIMESTAMP'],
			        ['tm_delete','DATETIME',false,false,false,false,false,'']
				],
		    'foreign' => [['mail','users(mail)']],
		];
	/*-- #USERS --*/

	/*-- PRODUCTS --*/		

			$table[] = [ 
				'name' => 'categories',
				'cols' => [
						['id_category','TINYINT(3)',true,false,false,true,true,''],
						['category','VARCHAR(35)',false,true,true,false,false,''],
						['identificator','VARCHAR(4)',false,true,true,false,false,''],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					]	
			];

			$table[] = [ 
				'name' => 'categories_sub',
				'cols' => [
						['id_category_sub','SMALLINT(5)',true,false,false,true,true,''],
						['id_category','TINYINT(3)',true,true,false,false,false,''],
						['sub_category','VARCHAR(20)',false,true,true,false,false,''],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					],
		    	'foreign' => [['id_category','categories(id_category)']],
			];

			$table[] = [
				'name' => 'products',
				'cols' => [
						['id_product','MEDIUMINT(6)',true,false,false,true,true,''],
						['serial','VARCHAR(13)',false,true,true,false,false,''],
						['product_name','VARCHAR(60)',false,true,true,false,false,''],
						['id_category','TINYINT(3)',true,true,false,false,false,''],
						['id_category_sub','TINYINT(3)',true,true,false,false,false,''],
						['price','MEDIUMINT(8)',true,true,false,false,false,''],
						['entry_date','DATETIME',false,false,false,false,false,'CURRENT_TIMESTAMP'],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					],
		    	'foreign' => [
		    			['id_category','categories(id_category)'],
		    			['id_category_sub','categories_sub(id_category_sub)']
		    		],
			];

			$table[] = [
				'name' => 'product_quanity',
				'cols' => [
						['id_p_quanity	','SMALLINT(6)',true,false,false,true,true,''],
						['id_product','MEDIUMINT(8)',true,true,true,false,false,''],
						['quanity_entry','SMALLINT(5)',true,true,false,false,false,''],
						['quantity_output','SMALLINT(5)',true,true,false,false,false,'0'],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					],
		    	'foreign' => [
		    			['id_product','products(id_product)']
		    		],
			];

			$table[] = [
				'name' => 'products_discount',
				'cols' => [
						['id_discount','MEDIUMINT(8)',true,false,false,true,true,''],
						['id_product','INT(11)',true,true,false,false,false,''],
						['percentage','TINYINT(3)',true,false,false,false,false,''],
						['value_discounted','MEDIUMINT(8)',true,false,false,false,false,''],
						['quantity_initial','SMALLINT(6)',true,false,false,false,false,''],
						['quantity_used','SMALLINT(6)',true,false,false,false,false,''],
						['initial_date','DATETIME',false,true,false,false,false,''],
						['final_date','DATETIME',false,false,false,false,false,''],
						['tm_create','DATETIME',false,true,false,false,false,'CURRENT_TIMESTAMP'],
			        	['tm_delete','DATETIME',false,false,false,false,false,'']
					],
		    	'foreign' => [
		    			['id_product','products(id_product)']
		    		],
			];	

			$table[] = [
				'name' => 'coupon_types',
				'cols' => [
						['id_coupon_type','TINYINT(3)',true,false,false,true,true,''],
						['coupon_type','VARCHAR(25)',false,true,true,false,false,''],
						['description','VARCHAR(250)',false,true,false,false,false,''],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					]
			];	


			$table[] = [
				'name' => 'products_coupon',
				'cols' => [
						['id_products_coupon','INT(10)',true,false,false,true,true,''],
						['coupon','VARCHAR(30)',false,true,true,false,false,''],
						['id_coupon_type','TINYINT(2)',true,true,false,false,''],
						['id_product','INT(11)',true,false,false,false,false,''],
						['percentage','TINYINT(3)',true,false,false,false,false,''],
						['value_discounted','INT(10)',true,false,false,false,false,''],
						['minimum_purchase_value','INT(10)',true,false,false,false,false,''],
						['initial_date','DATETIME',false,true,false,false,false,'CURRENT_TIMESTAMP'],
						['final_date','DATETIME',false,false,false,false,false,''],
						['coupons_avalilable','SMALLINT(6)',true,false,false,false,false,''],
						['coupons_used','SMALLINT(6)',true,true,false,false,false,'0'],
						['user_maximun','SMALLINT(6)',true,true,false,false,false,'1'],
						['tm_create','DATETIME',false,true,false,false,false,'CURRENT_TIMESTAMP'],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					],
		    	'foreign' => [
		    			['id_coupon_type','coupon_types(id_coupon_type)'],
		    			['id_product','products(id_product)'],
		    		],
			];

			$table[] = [
				'name' => 'product_imgs',
				'cols' => [
						['id_p_img','SMALLINT(6)',true,false,false,true,true,''],
						['id_product','INT(11)',true,false,false,false,false,''],
						['img_lg','VARCHAR(120)',false,true,true,false,false,''],
						['img_sm','VARCHAR(120)',false,true,true,false,false,''],
						['img_tn','VARCHAR(120)',false,true,true,false,false,''],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					],
		    	'foreign' => [
		    			['id_product','products(id_product)'],
		    		],
			];

			$table[] = [
				'name' => 'product_imgs_main',
				'cols' => [
						['id_img_main','SMALLINT(6)',true,false,false,true,true,''],
						['id_product','INT(11)',true,false,false,false,false,''],
						['img_lg','VARCHAR(120)',false,true,true,false,false,''],
						['img_sm','VARCHAR(120)',false,true,true,false,false,''],
						['img_tn','VARCHAR(120)',false,true,true,false,false,''],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					],
		    	'foreign' => [
		    			['id_product','products(id_product)'],
		    		],
			];

			$table[] = [
				'name' => 'products_published',
				'cols' => [
						['id_publiched','INT(11)',true,false,false,true,true,''],
						['id_product','INT(11)',true,false,false,false,false,''],
						['state','CHAR(2)',false,true,false,false,false,''],
						['published_date','DATETIME',false,true,false,false,false,'']
					],
		    	'foreign' => [
		    			['id_product','products(id_product)'],
		    		],
			];


			$tables[] = [
				'nombre' => 'offers',
				'filas' => [
						['id_offer','TINYINT(11)',true,false,true,true,''],
						['offer_type','VARCHAR(80)',false,true,false,false,''],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					]
			];

			$tables[] = [
				'nombre' => 'offers_discounts',
				'filas' => [
						['id_discount','TINYINT(11)',true,false,true,true,''],
						['discount','VARCHAR(30)',false,true,false,false,''],
						['description','VARCHAR(150)',false,true,false,false,''],
						['tm_delete','DATETIME',false,false,false,false,false,'']
					]
			];

	/*-- #PRODUCTS --*/

	/*-- CHECKOUT --*/
			$table[] = [
				'name' => 'sale_detail',
				'cols' => [
					['id_sale_detail','INT(11)',true,false,false,true,true,''],
					['sale_serial','VARCHAR(35)',false,true,true,false,false,''],
					['id_user','SMALLINT(6)',true,true,false,false,false,''],
					['price_products','MEDIUMINT(8)',true,true,false,false,false,''],
					['price_shipping','MEDIUMINT(8)',true,true,false,false,false,''],
					['price_discount','MEDIUMINT(8)',true,true,false,false,false,''],
					['id_products_coupon','SMALLINT(6)',true,false,false,false,false,''],
					['coupon_value','MEDIUMINT(8)',true,false,false,false,false,''],
					['total_sale','MEDIUMINT(8)',true,true,false,false,false,''],
					['sale_date','DATETIME',false,true,false,false,false,''],
					['id_state_sale','TINYINT(3)',true,true,false,false,false,''],
					['id_address','INT(11)',true,true,false,false,false,''],
			        ['tm_delete','DATETIME',false,false,false,false,false,'']
				],
		    	'foreign' => [
		    			['id_user','users(id_user)'],
		    			['id_address','users_addresses(id_address)'],
		    		],
			];

			$table[] = [
				'name' => 'sale_products',
				'cols' => [
						['id_sale_product','INT(11)',true,false,false,true,true,''],
						['sale_serial','VARCHAR(35)',false,true,false,false,false,''],
						['id_product','SMALLINT(6)',true,true,false,false,false,''],
						['quantity','SMALLINT(4)',true,true,false,false,false,''],
						['unit_price','INT(11)',true,true,false,false,false,''],
						['discount','INT(11)',true,true,false,false,false,''],
						['total_price_product','INT(11)',true,true,false,false,false,''],
			        	['tm_delete','DATETIME',false,false,false,false,false,'']
					],
		    	'foreign' => [
		    			['id_product','products(id_product)'],
		    			['sale_serial','sale_detail(sale_serial)'],
		    		],
			];

			$table[] = [
				'name' => 'sale_token',
				'cols' => [
					['id_sale_token','INT(11)',true,false,false,true,true,''],
					['token','VARCHAR(40)',false,true,false,false,false,''],
					['sale_serial','VARCHAR(40)',false,true,true,false,false,''],
					['tm_create','DATETIME',false,true,false,false,false,'CURRENT_TIMESTAMP'],
					['tm_update','DATETIME',false,false,false,false,false,''],
			        ['tm_delete','DATETIME',false,false,false,false,false,'']
				],
		    	'foreign' => [
		    			['sale_serial','sale_detail(sale_serial)'],
		    		],
			];
	/*-- #CHECKOUT --*/

	/*-- elements --*/
			$table[] = [
				'nombre' => 'newsletter',
				'filas' => [
						['id_news','MEDIUMINT(7)',true,false,false,true,true,''],
						['name_news','VARCHAR(100)',false,false,true,false,false,''],
						['mail_news','VARCHAR(80)',false,true,true,false,false,''],
						['tm_delete','DATETIME',false,false,false,false,'']
					]
			];

	
	/*
		2 => UNSIGNED = false (DEFAULT),
		3 => NOT NULL = false (DEFAULT),
		4 => UNIQUE = false (DEFAULT),
		5 => AUTOINCREMENT = false (DEFAULT),
		6 => PRIMARY_KEY = false (DEFAULT)
		7 => $default = '' (EMPTY BY DEFAULT)
	*/

	/*-- MAINTENANCE --*/
		$table[] = [
			'name' => 'maintenance',
			'cols' => [
				['id_maintenance','TINYINT(3)',true,false,false,true,true,''],
				['state','VARCHAR(60)',false,true,false,false,false,''],
				['tm_maintenance','DATETIME',false,false,false,false,false,''],
			    ['tm_delete','DATETIME',false,false,false,false,false,'']
			]
		];

		$table[] = [
			'name' => 'maintenance_ip',
			'cols' => [
				['id_ip','TINYINT(3)',true,false,false,true,true,''],
				['id_maintenance','TINYINT(3)',true,true,false,false,false,''],
				['ip_address','VARCHAR(50)',false,true,true,false,false,''],
			    ['tm_delete','DATETIME',false,false,false,false,false,''],
			],
		    'foreign' => [ ['id_maintenance','maintenance(id_maintenance)'] ],
		];
	/*-- #MAINTENANCE --*/

	foreach ($table as $tb) {
	    Table::create( $tb );
	 }
/* ==============  #TABLES  ============= */

/* ==============  DEFAULT DATA  ============= */
		
	/*-- ADMINS --*/
		$users = [
			['JUAN DAVID','LEON PONCE','jlp25@hotmail.com','ctlb31207',1,1],
		];

		foreach ($users as $user) {
			$set = [
				'name' => $user[0],
				'last_name' => $user[1],
				'mail' => $user[2],
				'password' => Secure::montar_clave_verificacion($user[3]),
				'id_rol' => $user[4],
				'activation' => $user[5],
			];

			$unique = [
				'conditional' => 'correo = ?',
				'params' => ['s',$user[2]]
			];
			CRUD::insert('users',$set,$unique);	
		}	
	/*-- #ADMINS --*/

	/*-- ROLES --*/
		$rols = ['ADMINISTRADOR','USUARIO'];
		foreach ($rols as $rol) {
			$set = ['rol' => $rol];
			$unique = [
				'conditional' => 'rol = ?',
				'params' => ['s',$rol]
			];
			CRUD::insert('user_rols',$set,$unique);
		}
	/*-- #ROLES --*/

	/* #CATEGORIES */
		$categories = [
			'COCINA','PAREDES','SALA','GRANDES'
		];
		
		foreach ($categories as $category) {
			$set = [ 'category' => $categoria ];
			CRUD::insert('categories',$set);
		}

	/* #CATEGORIES */

	/* OFFERS */
		$oferts = ['DESCUENTO','CUPONES','OFERTA DEL DIA'];

		foreach ($oferts as $oferta) {
			$set = [ 'tipo_oferta' => $oferta ];
			$unique = [
				'conditional' => 'tipo_oferta = ?',
				'params' => ['s',$oferta]
			];
			CRUD::insert('oferts',$set,$unique);
		}
	/* #OFFERS */


/* ==============  #DEFAULT DATA  ============= */

