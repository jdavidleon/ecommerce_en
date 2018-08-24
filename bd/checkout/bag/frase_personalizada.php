<?php 
	session_start();
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest();

	if (!$data) {
		$msn = "ERROR_DATA_REQUEST";
		$result = 'error';
    	location();
    	return false; 
	}

	$lang = $data['lang'];

	if (!Secure::tiene_longitud($data['frase_personalizada'], ['maximo' => 35])) {		
		$msn = "ERROR_DATA_LENGHT_SENTENCE";
		$result = 'error';
    	location();
    	return false; 
	}

	if (!Secure::tiene_longitud($data['mensaje_tarjeta'], ['maximo' => 250])) {		
		$msn = "ERROR_DATA_LENGHT_MESSAGE";
		$result = 'error';
    	location();
    	return false; 
	}
	

	if (isset($_SESSION['id_usuario'])) {
		echo "string";
		$permitidos = [ 'id_bolsa_compras', 'id_producto', 'destinatario', 'motivo', 'frase_personalizada', 'mensaje_tarjeta' ];
		$datos = Secure::parametros_permitidos($permitidos,$data);
		
		$datos['id_usuario'] = $_SESSION['id_usuario'];

		$where = 'id_bolsa_compras = ? AND tm_delete IS NULL';
		$params = ['i',$datos['id_bolsa_compras']];
		$buscar = CRUD::numRows('venta_personalizar','*',$where,$params);
		var_dump($datos['id_bolsa_compras']);
		if ($buscar === 1) {
			$update = CRUD::update('venta_personalizar',$datos,$where,$params);
		}elseif ($buscar === 0) {
			$insert = CRUD::insert('venta_personalizar',$datos);
			var_dump($insert);
		}
	}elseif (isset($_COOKIE['bolsa'])) {		
		$permitidos = [ 'id_producto', 'destinatario', 'motivo', 'frase_personalizada', 'mensaje_tarjeta' ];
		$datos = Secure::parametros_permitidos($permitidos,$data);

		$productoID = (int) $datos['id_producto'];
				
		$keyCompare = [ 'id_producto' => $productoID ];
		$valueToInsert = $datos;
		var_dump($valueToInsert);

		var_dump(Cookie::updateCookie('bolsa',$keyCompare,$valueToInsert));
	}


	$msn = "success_set_order_message";
	$result = 'success';
	location();
	return false; 

	
	function location()
	{
		header('Location: '.URL_BASE.$GLOBALS['lang'].'/checkout/basket/'.$GLOBALS['result'].'/'.$GLOBALS['msn'].'/');
	}