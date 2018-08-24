<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 


	$data = Secure::recibirRequest('POST');
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}
	


	if (CRUD::falseDelete('usuarios','id_usuario = ?',['i',$data['id_usuario']])) {
		echo "Eliminado";
	}else{
		echo "Error";
	}