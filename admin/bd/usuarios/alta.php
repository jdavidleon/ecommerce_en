<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 


	$data = Secure::recibirRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}
	
	if (CRUD::update('usuarios',['tm_delete' => NULL],'id_usuario = ?',['i',$data['id_usuario']])) {
		echo "Usuario restaurado";
	}else{
		echo "ERROR AL RESTAURAR LA CUENTA";
	}