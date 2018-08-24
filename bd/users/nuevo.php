<?php
	
	include '../../config/config.php';

	$data = Secure::peticionRequest();

	$result = 'error';
	if (!$data) {
		$msn = 'ERROR_DATA_REQUEST';
		errorSignUp();
		return false;
	}

	$mail = $data['correo'];
	unset($data['url']);

	if (!isset($data['accept_terms']) || $data['accept_terms'] != 'on') {	
		$msn = 'ERROR_ACCEPT_TERMS';
		errorSignUp();
		return false;
	}

	$permitidos = [ 'nombre', 'apellido_usuario', 'correo', 'sexo', 'clave' ];

	$datos = Secure::parametros_permitidos($permitidos,$data);

	if ($datos === false) {
		$msn = 'INCONMPLETE_FORM';
		errorSignUp();
		return false;
	}

	$datos['id_rol'] = 2; /*Usuario Estandar*/

	if(!Secure::tiene_longitud($datos['clave'], ['minimo' => 8, 'maximo' => 20])) {
      	$msn = "LENGHT_PASSWORD";
      	errorSignUp();
		return false;
    } 

    if (!Secure::validar_correo($datos['correo'])) {
       	$msn = "INVALID_MAIL";
       	errorSignUp();
		return false;
    }

   //Verificacion de no existencia de cuenta
    if (CRUD::numRows('usuarios','*','correo = ?',['s',$data['correo']]) > 0) {
      	$msn = "MAIL_PREV_REG";
      	errorSignUp();
		return false;
	}

	$unique = [
		'conditional' => 'correo = ?',
		'params' => ['s',$datos['correo']]
	];
    $datos['clave'] = Secure::montar_clave_verificacion($datos['clave']);
	$insertar = CRUD::insert('usuarios',$datos,$unique);

	if ($insertar[0]->affected_rows !== 1) {
		$msn = 'ERROR_GLB_SIGNUP';
		errorSignUp();
		return false;
	}else{		
		if (User::sendEmail($data['correo'])) {
			$result = 'success';
			$msn = 'created_account';
			errorSignUp();  
			return true;		
		}else{
			$msn = 'ERROR_GLB_SIGNUP';
			errorSignUp();
			return false;
		}  	
	}



	function errorSignUp()
	{	
		header('Location: '.URL_PAGE.'page/usuarios/registrarse/'.$GLOBALS['result'].'/'.$GLOBALS['msn'].'/'.$GLOBALS['mail']);
	}
