<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest();
		

	if (!$data) {
		$msn = "Ha ocurrido un error, Intentalo nuevamente.";
		$bd = 'error';		
		location();
		exit();
	}


	$usuarioID = $data['id_usuario'];
	unset($data['id_usuario']);

	$where = 'id_usuario <> ? AND correo = ?';
	$params = ['is',$usuarioID,$data['correo']];
	if (CRUD::numRows('usuarios','*',$where,$params) > 0) {		
		$bd = 'error';
		$msn = "Ha ocurrido un error. Por favor intentao nuevamente.";
		location();
		exit();
	}

	$actualizar = CRUD::update('usuarios',$data,'id_usuario = ?',['i',$usuarioID]);

	if ($actualizar[0]->affected_rows > 0) {
		$msn = "Datos de usuario actualizados";
		$bd = 'success';
		location();
		exit();
	}else{
		$msn = "Ha ocurrido un error. Vuelve a intentarlo nuevamnete.";
		$bd = 'error';
		location();
		exit();
	}

	function location()
	{
		header('Location: '.URL_BASE.'admin/pages/usuarios.php?bd='.$GLOBALS['bd'].'&msn='.$GLOBALS['msn']);
	}
	

