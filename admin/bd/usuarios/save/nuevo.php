<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 


	$data = Secure::peticionRequest();
	
	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}
	$clave = Secure::generarCodigo(7); /*Enviar Email*/
	$data['clave'] = Secure::montar_clave_verificacion($clave);

	var_dump($data);

	$conditional = [
		'conditional' => 'correo = ?',
		'params' => ['s',$data['correo']]
		];

	$insertar = CRUD::insert('usuarios',$data,$conditional);

	

	if ($insertar[0]->affected_rows > 0) {
		$new_user = 'Usuario Ingresado correctamente';
	}else{
		if (count(CRUD::all('usuarios','*','correo = ?',['s',$data['correo']])) > 0) {
			$new_user = 'Ya existe un usuario con ese correo';
		}else{
			$new_user = " Ha ocurrido un error";
		}
	}

	header('Location: '.URL_BASE.'admin/pages/usuarios.php?new_user='.$new_user);