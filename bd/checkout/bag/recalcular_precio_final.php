<?php 
	session_start();
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 


	$cart = new Checkout;
	$productos = $cart->productosBolsa;
	
	$total = 0;
	foreach ($productos as $producto) {
		$total = $total + $producto['precio_total'];
	}
	
	$newCoupon = new Coupon;
	$userCoupon = $newCoupon->findUserCoupon();
	$cupon = 0;

	if ($userCoupon !== false) {
		$cupon = $newCoupon->calculateCoupon($userCoupon);
	}

	echo $total - $cupon;
	
?>