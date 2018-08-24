<?php 

	require '../../../config/config.php';
	require DIRECTORIO_ROOT.'config/autoload.php';

	$data = Secure::peticionRequest();

	if (!$data) {
		$msn = "ERROR_DATA_REQUEST";
		$result = 'error';
		location($result,$msn);		
	}

	$permitidos = [ 'token', 'correo', 'lang', 'psw1', 'psw2' ];

	$datos = Secure::parametros_permitidos($permitidos,$data);

	if (!Secure::checkTokenRestorePsw($datos['correo'],$datos['token'])) {		
		$msn = "ERROR_DATA_RESTORE";
		$result = 'error';
		location($result,$msn);
		exit();	
	}

	if ($datos['psw1'] !== $datos['psw2']) {
		$msn = "ERROR_DIFERENT_PASSWORD";
		$result = 'error';
		location($result,$msn);
		exit();	
	}

	if(!Secure::tiene_longitud($datos['psw1'], ['minimo' => 8, 'maximo' => 20])) {
      	$msn = "LENGHT_PASSWORD";
      	$result = 'error';
      	location($result,$msn);
      	exit();
    } 

    $clave = Secure::montar_clave_verificacion($datos['psw1']);
    if (CRUD::numRows('usuarios','*','correo = ? AND clave = ?',['ss',$datos['correo'],$clave])) {
    	$msn = "success_restore_password";
      	$result = 'success';
      	location($result,$msn);
      	exit();
    }

	$set = [
    	'clave' => $clave
    ];
    $where = 'correo = ?';
    $params = ['s',$datos['correo']];
    $update_psw = CRUD::update('usuarios',$set,$where,$params);
    
    if ($update_psw[0]->affected_rows === 1) {
    	$where = 'correo = ?';
    	$params = ['s',$datos['correo']];
    	CRUD::delete("usuarios_restaurar_psw",$where,$params);
    	CRUD::delete("usuarios_intentos",'correo_usuario = ?',$params);
    	CRUD::update('usuarios',['estado_usuario' => 1],$where,$params);
    	$msn = "success_restore_password";
      	$result = 'success';
      	location($result,$msn);
      	exit();
    }else{
    	$msn = "ERROR_DATA_RESTORE";
      	$result = 'error';
      	location($result,$msn);
      	exit();
    }

	function location($result,$msn)
	{	
		header('Location: '.URL_PAGE.'/'.$GLOBALS['datos']['lang'].'/pages/restore_account/'.$result.'/'.$msn.'/'.$GLOBALS['datos']['token'].'/'.$GLOBALS['datos']['correo']);
		return false;
	}