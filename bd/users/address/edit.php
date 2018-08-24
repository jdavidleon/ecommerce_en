<?php 
	require "../../../config/config.php";

	$data = Secure::peticionRequest('GET');

	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}
	
	if ($data['logged'] === 'true') {
		CRUD::falseDelete('usuarios_direcciones','id_direcciones = ? AND tm_delete is NULL',['i',$data['id_direcciones']]);	
	}else{
		Cookie::deleteCookie('addr_us_shp');
	}
	// exit();
	header('Location: '.URL_PAGE.'page/caja/#form_address');
	return false;