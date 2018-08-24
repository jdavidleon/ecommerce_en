<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	$cupon = new Coupon;
	$update = $cupon->update( $data );


	if ($update) {
		echo 'Cupon actualizado';
	}