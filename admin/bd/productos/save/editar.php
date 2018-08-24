<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 


	$data = Secure::peticionRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	if (CRUD::update('productos',$data,'id_producto = ?',['i',$data['id_producto']])) {
		$edit = 'Producto actualizado';
	}else{
		$edit = 'ha ocurrido un error';
	}

	header('Location: '.URL_BASE.'admin/pages/productos.php?edit='.$edit);