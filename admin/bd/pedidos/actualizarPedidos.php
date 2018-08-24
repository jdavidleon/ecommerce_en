<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest('POST');

	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	if (CRUD::update('venta_detalle',['id_estado' => $data['id_estado']],'serial_venta = ?', ['s',$data['serial_venta']])) {
		header('Location: '.URL_BASE.'admin/pages/pedidos.php?serial='.$data['serial_venta']);
	}else{
		header('Location: '.URL_BASE.'admin/pages/pedidos.php?serial=no_actualizado');
	}
	