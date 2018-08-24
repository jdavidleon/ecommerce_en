<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();

	// var_dump($_REQUEST);
	// var_dump($data);
	// exit();

	if (!$data) {
		$result = 'danger';
		$msn = 'Revisa el valor ingresado';
		response($result,$msn);
		return false;	
	}

	$where = 'item_es = ? AND item_en = ?';
	$params = ['ss',$data['item_es'],$data['item_en']];

	$buscar = CRUD::all('productos_items','*',$where,$params);

	if ( count($buscar) === 1 ) {

		if ($buscar[0]['tm_delete'] != null) {
			$set = ['tm_delete' => null];
			$where = 'id_item = ?';
			$params = ['i',$buscar[0]['id_item']];
			$create = CRUD::update('productos_item',$set,$where,$params);
		}else{
			$create = false;
		}

	}elseif ( count($buscar) === 0 ) {
		$where = 'item_es = ? AND item_en = ?';
		$params = ['ss',$data['item_es'],$data['item_en']];
		$unique = [
			'conditional' => $where,
			'params' => $params
		];
		$create = CRUD::insert('productos_items',$data,$unique);
	}

	if ($create) {
		echo "<p class='text-center'>Item agregado</p>";
	}else{
		echo "<p class='text-center'>El item ya Existe</p>";
	}

	
	