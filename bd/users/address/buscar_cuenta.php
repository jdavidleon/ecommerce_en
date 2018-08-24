<?php 
	require "../../../config/config.php";

	$data = Secure::peticionRequest();

	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}

	$buscar = CRUD::numRows('usuarios','*','correo = ?',['s',$data['correo']]);
	
	if ($buscar > 0) {
		echo "log_in_required";
	}elseif ($buscar == 0) {
		echo "error_log_in";
	}