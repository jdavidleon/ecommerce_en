<?php 
	require "../../../config/config.php";

	$data = Secure::peticionRequest();

	var_dump($_REQUEST);
	if (!$data) {
		$result = 'error';
		$msn = 'ERROR_DATA_REQUEST';
		location($result,$msn);
		return false;
	}

	$permitido = [ 'clave_cupon' ];
	$datos = Secure::parametros_permitidos($permitido,$data);

	$nuevoCupon = new Coupon;
	
	if ($nuevoCupon->newUserCoupon($datos['clave_cupon'])) {
		$result = 'success';
		$msn = 'cupon_agregado';
		location($result,$msn);
		return false;
	}else{
		$result = 'error';
		$msn = 'ERROR_ADD_COUPON';
		location($result,$msn);
		return false;
	}

	function location($result,$msn)
	{
		header('Location: '.URL_PAGE.'/page/caja/'.$GLOBALS['result'].'/'.$GLOBALS['msn'].'/');
	}

	return true;

