<?php 
	session_start();
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest('GET');


	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}

	
	$cart = new Checkout;
	$productos = $cart->productosBolsa;

	$buscar = array_search($data['id_producto'], array_column($productos, 'id_producto'));

	echo $productos[$buscar]['precio_total'];