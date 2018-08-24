<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest('POST');
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	$tomarSerial = CRUD::all('productos','serie','id_producto = ?',['i',$data['id_producto']]);
	$serial = $tomarSerial[0]['serie'];
	

	if (CRUD::numRows('productos_publicados','*','serie = ?',['s',$serial]) > 0) {
		$update = ['estado_publicado' => $data['estado_publicado']];
		$where = 'serie = ?';
		$params = ['s',$serial];
		$registro = CRUD::update('productos_publicados',$update,$where,$params);
	}else{
		$set = [
			'serie' => $serial,
			'estado_publicado' => $data['estado_publicado'],
			'fecha_publicacion' => date('Y-m-d')
		];
		$registro = CRUD::insert('productos_publicados',$set);
	}	

	echo "Producto actualizado";
?>