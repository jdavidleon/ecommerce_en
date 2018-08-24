<?php 

	require "../../../config/config.php";

	$data = Secure::peticionRequest();

	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}

	Checkout::agregarCarrito($data);

?>