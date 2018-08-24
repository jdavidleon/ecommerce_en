<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	$cupon = new Coupon;
	$crear = $cupon->create( (int) $data['id_tipo_cupon'] );


	if ($crear) {
		$msn = 'Cupón '.$data['clave_cupon'].' creado Exitosamente';
		header('Location: '.URL_BASE.'admin/pages/cupones.php?bd=success&msn='.$msn);
	}else{
		$msn = 'ya existe el cupón '.$data['clave_cupon'];
		header('Location: '.URL_BASE.'admin/pages/cupones.php?bd=error&msn='.$msn);
	}