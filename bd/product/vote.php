<?php 
	require "../../config/config.php";

	$data = Secure::peticionRequest();

	if (!$data) {
		return false;
	}


	if (!Secure::es_numero($data['voto'],['minimo' => 1, 'maximo' => 5])) {
		return false;
	}

	$where = 'id_producto = ? AND id_usuario = ?';
	$params = ['ii',$data['id_producto'],$data['id_usuario']];
	$buscar = CRUD::all('productos_votacion','*',$where,$params);

	if (count($buscar) > 0) {
		$set = [
			'voto' => $data['voto'],
		];
		CRUD::update('productos_votacion',$set,$where,$params);
	}else{
		$set = [
			'id_usuario' => $data['id_usuario'],
			'id_producto' => $data['id_producto'],
			'voto' => $data['voto'],
		];
		$unique = [
			'conditional' => $where,
			'params' => $params
		];
		CRUD::insert('productos_votacion',$set,$unique);
	}