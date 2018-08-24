<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	$where = 'id_producto = ?';
	$params = ['i',$data['id_producto']];

	$buscarCantidad = CRUD::all('productos_cantidad','*',$where,$params);

	$cantidadInicial = $buscarCantidad[0]['cantidad_entrada'];
	$cantidadFinal = $cantidadInicial + $data['cantidad_entrada'];


	$update = CRUD::update('productos_cantidad',['cantidad_entrada' => $cantidadFinal],$where,$params);


	if ($update[0]->affected_rows > 0) {
		$msn = 'Cantidad de produtos actualizada';
		header('Location: '.URL_BASE.'admin/pages/productos.php?action=true&result='.$msn);
	}else{
		$msn = 'Ha ocurrido un error, Intentalo nuevamnete';
		header('Location: '.URL_BASE.'admin/pages/productos.php?action=false&result='.$msn);
	}

	