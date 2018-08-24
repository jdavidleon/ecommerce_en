<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest('GET');
	

	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	$cupon = new Coupon;
	$delete = $cupon->delete( $data['clave_cupon'] );


	if ($delete) {
		$msn = "Cupon eliminado.";
		header('Location: '.ADMIN.'/pages/cupones.php?bd=success&msn='.$msn);
	}else{
		$msn = "ha ocurrido un error al elimnar el cupón, intentalo nuevamnete";
		header('Location: '.ADMIN.'/pages/cupones.php?bd=error&msn='.$msn);
	}