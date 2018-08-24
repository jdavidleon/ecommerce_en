<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest('POST');

	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	if (CRUD::falseDelete('venta_detalle','id_venta_detalle = ?',['i',$data['id_venta_detalle']])) {
		$msn = 'El pedido '.$data['serial_venta'].' se ha eliminado de la lista';
		header('Location: '.URL_BASE.'admin/pages/pedidos.php?bd=success&msn='.$msn);
	}else{
		$msn = 'Ha ocurrido un error no se ha podido eliminar el pedido';
		header('Location: '.URL_BASE.'admin/pages/pedidos.php?bd=error&msn='.$msn);
	}
	