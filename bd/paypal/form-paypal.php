<?php 

	$join = [
		['INNER','productos','productos.id_producto = ventas.id_producto']
	];
	$pedido = CRUD::all('ventas','*','ventas.serial_venta = ?',['s',$serial],$join);

	$join = [
		['INNER','usuarios','usuarios.id_usuario = venta_detalle.id_usuario'],
		['INNER','usuarios_direcciones','usuarios_direcciones.id_direcciones = venta_detalle.id_direccion_envio'],
		['LEFT','estados','estados.id_estado_eu = usuarios_direcciones.id_estado_eu'],
		['LEFT','ciudades','ciudades.id_ciudad = usuarios_direcciones.id_ciudad']
	];
	$cliente = CRUD::all('venta_detalle','*','venta_detalle.serial_venta = ?',['s',$serial],$join);
	$info = $cliente[0];
	unset($info['clave']);

	$user = Secure::decodeArray($info);

	$indicador = substr($user->telefono, 0, 3);
	$telefono =  substr($user->telefono, 3);
?>


<form action="https://www.paypal.com/cgi-bin/webscr" id="paypalForm" method="post">
	
	<input type="hidden" name="cmd" value="_cart">
	<input type="hidden" name="redirect_cmd" value="_xclick">
	<input type="hidden" name="upload" value="1">
	<input type="hidden" name="custom" value="<?php echo $serial; ?>"><!-- Serial -->

	<!-- User -->
	<input type="hidden" name="email" value="<?php echo $user->correo; ?>">
	<input type="hidden" name="first_name" value="<?php echo $user->nombre; ?>">
	<input type="hidden" name="last_name" value="<?php echo $user->apellido_usuario; ?>">
	<input type="hidden" name="address1" value="<?php echo $user->direccion; ?>">
	<input type="hidden" name="city" value="<?php echo $user->nombre_ciudad; ?>">
	<input type="hidden" name="state" value="<?php echo 'FL'; ?>">
	<input type="hidden" name="zip" value="<?php echo $user->zip_code; ?>">
	<input type="hidden" name="day_phone_a" value="<?php echo $indicador; ?>">
	<input type="hidden" name="day_phone_b" value="<?php echo $telefono; ?>">
	<!-- #User -->

	<!-- Productos -->
	<?php $num = 1;	?>	
 	<?php foreach ($pedido as $prd): ?> 
 		<?php $amount = $prd['precio_unitario'] - $prd['descuento']; ?>		
	 	<input type="hidden" name="item_name_<?php echo $num; ?>" value="<?php echo $prd['nombre_producto_'.$lang]; ?>">
		<input type="hidden" name="amount_<?php echo $num; ?>" value="<?php echo $amount; ?>">
		<input type="hidden" name="quantity_<?php echo $num; ?>" value="<?php echo $prd['cantidad']; ?>">
		<?php $num++; ?>
 	<?php endforeach ?>
	<!-- Productos -->

	<input type="hidden" name="business" value="barucrafts@gmail.com">

	<?php 

		$token = Secure::crear_csrf_token();

		$set = [
			'token' => $token,
			'serial_venta' => $serial,
			'tm_create' => date('Y-m-d H:m:s'),
		];
		CRUD::insert('venta_token',$set);

		$url_paypal = 'http://www.madeitforu.com/'.$lang.'/bussiness/payment/'.$serial.'/'.$token.'/';

	?>

	<input type="hidden" name="return" value="<?php echo $url_paypal.'recieved/'; ?>">
	<input type="hidden" name="cancel_return" value="<?php echo $url_paypal.'declined/'; ?>">



	<input type="hidden" name="image_url" value="http://www.madeitforu.com/payment/paypal/logo.png">
	<input type="hidden" name="business" value="barucrafts@gmail.com">
	<input type="hidden" name="currency_code" value="USD">
	<input type="image" style="display: none;" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_cc_144x47.png" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>