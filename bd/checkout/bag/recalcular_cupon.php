<?php 
	session_start();
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 


	$newCoupon = new Coupon;
	$userCoupon = $newCoupon->findUserCoupon();
	$cupon = 0;

	if ($userCoupon !== false) {
		$cupon = $newCoupon->calculateCoupon($userCoupon);
	}

	echo $cupon;