<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 


	$data = Secure::recibirRequest('GET');
	
	if (!$data) {
		echo "Ha ocurrido un error";
		location();
		return false;
	}
    
	$where = 'correo = ?';
	$params = ['s',$data['correo']];
	CRUD::delete("usuarios_restaurar_psw",$where,$params);
	CRUD::delete("usuarios_intentos",'correo_usuario = ?',$params);
	CRUD::update('usuarios',['estado_usuario' => 1],$where,$params);
	$msn = "Cuenta de usuario activada";
  	$result = 'success';
  	location();
  	exit();


  	function location()
  	{
  		header('Location: '.ADMIN.'pages/usuarios.php?bd='.$GLOBALS['result'].'$msn='.$GLOBALS['msn']);
  	}