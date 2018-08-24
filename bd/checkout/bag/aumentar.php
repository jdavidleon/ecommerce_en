<?php 
	require "../../../config/config.php";

	$data = Secure::peticionRequest();

	if (!$data) {
		return false;
	}

	if (isset($_SESSION['id_usuario'])) {
		$disponibles = Checkout::disponibilidad($data['id_bolsa_compras']);
		$stock = $disponibles[0]['disponibles'];
		$enBolsa = $disponibles[0]['cantidad_bolsa'];

		if ($stock > $enBolsa) {
			$set = [
				'cantidad_bolsa' => $enBolsa + 1
			];
			$update = CRUD::update('bolsa_compras',$set,'id_bolsa_compras = ?',['i',$data['id_bolsa_compras']]);
			if ($update[0]->affected_rows > 0) {
				$msn = $enBolsa + 1;
			}else{
				$msn = $enBolsa;
			}
		}elseif ($stock < $enBolsa) {
			$set = [
				'cantidad_bolsa' => $stock
			];
			$update = CRUD::update('bolsa_compras',$set,'id_bolsa_compras = ?',['i',$data['id_bolsa_compras']]);
			$msn = $enBolsa;
		}else{
			$msn = $enBolsa;
		}
	}elseif (isset($_COOKIE['bolsa'])) {
		$row = '(cantidad_entrada - cantidad_salida) as disponibles';
		$where = 'id_producto = ?';
		$params = ['i',$data['id_producto']];
		$buscar = CRUD::all('productos_cantidad',$row,$where,$params);

		$disponibles = $buscar[0]['disponibles'];

		$actualCookie = Cookie::readCookie('bolsa');
		$indice = array_search($data['id_producto'], array_column($actualCookie, 'id_producto'));

		$cantidadActual = (int) $actualCookie[$indice]['cantidad_bolsa'];

		if ($cantidadActual === $disponibles) {
			$msn = $cantidadActual;
		}elseif ($cantidadActual < $disponibles) {
			$keyCompare = [ 'id_producto' => $data['id_producto'] ];
			$dataToInsert  = [ 'cantidad_bolsa' => $cantidadActual + 1 ];
			Cookie::updateCookie('bolsa',$keyCompare,$dataToInsert);
			$msn = $cantidadActual + 1;
		}		
	}
	

	echo $msn;