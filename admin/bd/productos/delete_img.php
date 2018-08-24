<?php 
	require "../../../config/config.php";

	$data = Secure::recibirRequest();

	if (!$data) {
		return false;
	}
	
	CRUD::falseDelete('productos_imagenes','id_p_imagenes = ?',['i',$data['id_p_imagenes']]);

	header('Location:'.ADMIN.'pages/detalle_producto.php?id_producto='.$data['id_producto']);
