<?php 
	require "../../../config/config.php";

	$data = Secure::recibirRequest();
	
	if (!$data) {
		// Secure::errorRequest();
		return false;
	}

	$buscar = CRUD::numRows('productos_agotados','*','id_producto = ?',['i',$data['id_producto']]);

	$where = 'id_producto = ?';
	$params = ['i',$data['id_producto']];
	if ($buscar === 0) {
		$set = [
			'id_producto' => $data['id_producto'],
			'estado_agotado' => $data['estado_agotado'],
			'fecha_agotado' => date('Y-m-d H:i:s')
		];
		$unique = [
			'conditional' => $where,
			'params' => $params
		];
		$cargar = CRUD::insert('productos_agotados',$set,$unique);
		echo $cargar[0]->affected_rows;
	}else{
		$set = [
			'estado_agotado' => $data['estado_agotado']
		];
		$update = CRUD::update('productos_agotados',$set,$where,$params);
		echo $update[0]->affected_rows;
	}

?>