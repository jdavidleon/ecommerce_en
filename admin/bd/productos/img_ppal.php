<?php 
	require "../../../config/config.php";

	$data = Secure::recibirRequest();

	if (!$data) {
		return false;
	}
	

	$set = [
		'ruta_img_lg' => $data['ruta_img_lg'],
		'ruta_img_sm' => $data['ruta_img_sm'],
		'ruta_img_tn' => $data['ruta_img_tn'],
	];
	$where = 'id_pip = ?';
	$params = ['i',$data['id_pip']];
	$update = CRUD::update('productos_imagenes_principales',$set,$where,$params);

	header('Location:'.ADMIN.'pages/detalle_producto.php?id_producto='.$data['id_producto']);
