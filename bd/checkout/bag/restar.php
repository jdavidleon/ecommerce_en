<?php 
	require "../../../config/config.php";

	$data = Secure::peticionRequest();
	
	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}

	if (isset($_SESSION['id_usuario'])) {
		$disponibles = Checkout::disponibilidad($data['id_bolsa_compras']);
		$stock = $disponibles[0]['disponibles'];
		$enBolsa = $disponibles[0]['cantidad_bolsa'];

		if ($enBolsa > 1) {
			$set = [
				'cantidad_bolsa' => $enBolsa - 1
			];
			$update = CRUD::update('bolsa_compras',$set,'id_bolsa_compras = ?',['i',$data['id_bolsa_compras']]);
			$msn = $enBolsa - 1;
		}else{
			$msn = 1;
		}
	}elseif (isset($_COOKIE['bolsa'])) {
		
		$actualCookie = Cookie::readCookie('bolsa');
		$indice = array_search($data['id_producto'], array_column($actualCookie, 'id_producto'));
		$cantidadActual = $actualCookie[$indice]['cantidad_bolsa'];

		if ($cantidadActual === 1) {
			$msn = $cantidadActual;
		}elseif ($cantidadActual > 1) {
			$keyCompare = [ 'id_producto' => $data['id_producto'] ];
			$dataToInsert  = [ 'cantidad_bolsa' => $cantidadActual - 1 ];
			Cookie::updateCookie('bolsa',$keyCompare,$dataToInsert);
			$msn = $cantidadActual - 1;
		}		
	}
	
	echo $msn;