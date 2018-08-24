<?php 
	require "../../../config/config.php";


	$data = Secure::peticionRequest();

	/*Validaciones*/
	if (!$data) {
		$result = 'error';
		$msn = 'ERROR_DATA_REQUEST';
		location($result,$msn);
		return false;
	}
	
	if (!Secure::es_numero($data['telefono'])) {
		$result = 'error';
		$msn = 'BAD_FORMAT_PHONE';
		location($result,$msn);
		return false;
	}

	if (!Secure::validar_correo($data['correo'])) {
		$result = 'error';
		$msn = 'BAD_FORMAT_EMAIL';
		location($result,$msn);
		return false;
	}
	/*#Validaciones*/

	$data['nombre_direccion'] = $data['nombre'];
	unset($data['nombre']);

	if ($session) {
		$data['id_usuario'] = $_SESSION['id_usuario'];
		$unique = [
			'conditional' => 'nombre_direccion = ? AND id_usuario = ? AND correo = ? AND id_departamento = ? AND id_ciudad = ? AND direccion = ? AND telefono = ? AND tm_delete IS NULL',
			'params' => ['sisiisi',$data['nombre_direccion'],$data['id_usuario'],$data['correo'],$data['id_departamento'],$data['id_ciudad'],$data['direccion'],$data['telefono']]
		];
		$nueva = CRUD::insert('usuarios_direcciones',$data,$unique); /*Insertar Direccion*/
		var_dump($nueva);
		// $address_cookie = Cookie::createCookie('addr_us_shp',$data,60*60*24*100);

		if ($nueva[0]->affected_rows === 1) {
			$result = 'success';
			$msn = 'success_address_added';
			location($result,$msn);
			return false;
		}else{
			$result = 'error';
			$msn = 'ERROR_DATA_REQUEST';
			location($result,$msn);
			return false;
		}
	}else{
		$departamento = CRUD::all('departamento','nombre_departamento','id_departamento = ?',['i',$data['id_departamento']]);
		$data['nombre_departamento'] = $departamento[0]['nombre_departamento'];
		$ciudades = CRUD::all('ciudades','nombre_ciudad','id_ciudad = ?',['i',$data['id_ciudad']]);
		$data['nombre_ciudad'] = $ciudades[0]['nombre_ciudad'];
		Cookie::createCookie('addr_us_shp',$data,60*60*24*100);
		$result = 'success';
		$msn = 'success_address_added';
		location($result,$msn);
		return false;
	}

	
	function location($result,$msn)
	{
		header('Location: '.URL_BASE.'page/caja/'.$result.'/'.$msn.'/');
	}
