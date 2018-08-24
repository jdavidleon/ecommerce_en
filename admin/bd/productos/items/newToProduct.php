<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 


	$productoID = $_REQUEST['id_producto'];

	if (!isset($_REQUEST['id_item'])) {
		CRUD::falseDelete('productos_con_items','id_producto = ?',['i',$productoID]);
		echo 'true';
		return true;
	}

	$items = $_REQUEST['id_item'];

	foreach ($items as $item) {
		
		$set = [
			'id_producto'  => $productoID, 
			'id_item' => $item
		];
		$unique = [
			'conditional' => 'id_producto = ? AND id_item = ?',
			'params' => ['ii',$productoID,$item]
		];

		CRUD::insert('productos_con_items',$set,$unique);

	}

	CRUD::falseDelete('productos_con_items','id_producto = ?',['i',$productoID]);

	foreach ($items as $item) {
		$set = [ 'tm_delete' => null ];
		$where = 'id_producto = ? AND id_item = ?';
		$params = ['ii',$productoID,$item];
		CRUD::update('productos_con_items',$set,$where,$params);
	}

	echo 'true';

	