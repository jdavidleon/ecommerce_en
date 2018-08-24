<?php 
	require "../../../../config/config.php";

	$data = Secure::recibirRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}


	$data['fecha_inicial'] = $data['fecha_inicial_dia'].' '.$data['fecha_inicial_hora'];
	$data['fecha_limite'] = $data['fecha_final_dia'].' '.$data['fecha_final_hora'];

	unset($data['fecha_inicial_dia']);
	unset($data['fecha_inicial_hora']);
	unset($data['fecha_final_dia']);
	unset($data['fecha_final_hora']);

	$where = 'id_producto = ? AND tm_delete IS NULL';
	$params = ['i',$data['id_producto']];
	$consultar = CRUD::numRows('productos_descuento','*',$where,$params);

	if ($consultar === 1) {
		CRUD::falseDelete('productos_descuento',$where,$params);
	}


	$unique = [
			'conditional' => 'id_producto = ? AND tm_delete IS NULL',
			'params' => $params
		];
	$insertar = CRUD::insert('productos_descuento',$data,$unique);


	if ($insertar[0]->affected_rows > 0) {
		$msn = 'Descuento aplicado exitosamente del '.$date['fecha_inicial'].' al '.$date['fecha_limite'];
		header('Location: '.URL_BASE.'admin/pages/productos.php?bd=success&msn='.$msn);		
	} else {
		$msn = 'Ha ocurrido un error al aplicar el descuento ';
		header('Location: '.URL_BASE.'admin/pages/productos.php?bd=error&msn='.$msn);		
	}
	