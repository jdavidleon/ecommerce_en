<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	$delete = CRUD::delete('productos_descuento','id_producto = ?',['i',$data['id_producto']]);

	if ($delete[0]->affected_rows === 1) {
		echo "string";
	}