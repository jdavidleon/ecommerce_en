<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}


	$permitidos = ['message','author'];

	$datos = Secure::parametros_permitidos($permitidos,$data);
	$insert = CRUD::insert('testimonials_msn',$datos);

	if ($insert[0]->affected_rows > 0) {
		$msn = "Testimonio ingresado correctamente";
		header('Location: '.ADMIN.'?bd=success&msn='.$msn );
	}else{
		$msn = "Ha ocurrido un error al ingresar el testimonio";
		header('Location: '.ADMIN.'?bd=error&msn='.$msn );
	}