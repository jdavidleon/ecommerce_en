<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest('GET');
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}
	

	$delete = CRUD::falseDelete('productos','id_producto = ?',['s',$data['id_producto']]);
	$msn = 'Producto Eliminado satisfactoriamente';
	header('Location: '.URL_BASE.'admin/pages/productos.php?bd=success&msn='.$msn);
?>
	