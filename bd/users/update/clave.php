<?php 
	require '../../../config/config.php';
	/*Validar usuario*/
	if (!isset($_SESSION['user'])) {
		header("Location: ".URL_BASE);
		exit();
	}

		
	$data = Secure::peticionRequest();

	if ($data['password_new'] === $data['password_new2']) {
		
		$consulta = CRUD::find('usuarios','clave','id_usuario = ?',['i',$_SESSION['id_usuario']]);

		$oldPsw = Secure::montar_clave_verificacion($data['password_old']);
		$newPsw = Secure::montar_clave_verificacion($data['password_new']);

		if (!Secure::tiene_longitud($data['password_new'],['minimo' => 7, 'maximo' => 25])) {
			$bd = 'error';
			$msn = 'LENGHT_PASSWORD';
			location();
			exit();
		}


		while($rConsult = $consulta[1]->fetch_assoc()){
			if ($rConsult['clave'] === $oldPsw) {
				$set = [ 'clave' => $newPsw ];
				$where = 'clave = ? AND id_usuario = ?';
				$params = ['si',$oldPsw,$_SESSION['id_usuario']];
				$cargar = CRUD::update('usuarios',$set,$where,$params);

				if ($cargar[0]->affected_rows > 0) {
					$bd = 'success';
					$msn = "success_psw_update";
					location();
					exit();
				}else{
					$bd = 'error';
					$msn = "ERROR_UPDATE_PSW";
					location();
					exit();
				}

			}else{
				$bd = 'error';
				$msn = "ERROR_VALIDATE_PSW";
				location();
				exit();
			}
		}
	} else {
		$bd = 'error';
		$msn = "ERROR_DIFERENT_PASSWORD";
		location();
		exit();
	}

	function location()
	{
		header('Location: '.URL_BASE.'page/usuarios/informacion-personal/'.$GLOBALS['bd'].'/'.$GLOBALS['msn'].'/');
	}


	


 ?>