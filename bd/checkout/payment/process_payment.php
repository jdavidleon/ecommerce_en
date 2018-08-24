<?php 

	require "../../../config/config.php";

	$data = Secure::peticionRequest();

	if (!$data) {
		$result = 'error';
		$msn = 'ERROR_DATA_REQUEST';
		errorPayment();
		return false;
	}

	/*Bolsa*/
	$carrito = new Checkout;
	$bolsa = $carrito->productosBolsa;
	$countCart = count($bolsa);
	$carrito->resumenCarrito();
	/*Bolsa*/

	

/*=============================================================================*/
	// VALIDACIONES
/*=============================================================================*/
	
	if (trim($data['precio_final']) !== trim($carrito->precioFinal)) {
		$result = 'error';
		$msn = 'ERROR_CART_COUNT';
		errorPayment();
		return false;
	}

	if (trim($countCart) !== trim($data['count_cart']) || $countCart === 0) {
		$result = 'error';
		$msn = 'ERROR_CART_COUNT';
		errorPayment();
		return false;
	}

	if (!$session && !isset($_COOKIE['addr_us_shp'])) {
		$result = 'error';
		$msn = 'ERROR_SHIP_ADDRESS';
		errorPayment();
		return false;
	}


/*=============================================================================*/
	// SESIONES
/*=============================================================================*/

	if (!$session) {
		$address = Cookie::readCookie('addr_us_shp');
		$correo = $address['correo'];
		if (CRUD::numRows('usuarios','*','correo = ?',['s',$correo]) > 0) {
			$result = 'error';
			$msn = 'ERROR_COUNT_EXIST';
			errorPayment();
			return false;
		}

		/*crear cuenta de usuario*/
			if (!Secure::validar_correo($correo)) {
				$result = 'error';
				$msn = 'ERROR_BAD_EMAIL';
				errorPayment();
				return false;
		    }
		    $clave = Secure::generarCodigo();
		    $datos_usuario = [
		    	'nombre' => $address['nombre_direccion'],
		    	'correo' => $correo,
		    	'clave' => Secure::montar_clave_verificacion($clave),
		    	'estado_usuario' => 1,
		    ];
		    $unique_user = [
		    	'conditional' => 'correo = ?',
		    	'params' => ['s',$correo]
		    ];
		    $crear_usuario = CRUD::insert('usuarios',$datos_usuario,$unique_user);

		    if ($crear_usuario[0]->affected_rows === 1) {
		    	$id_usuario = CRUD::all('usuarios','*','correo = ?',['s',$correo]);
		    	$userID = $id_usuario[0]['id_usuario'];

		    	/*Ajustar Bolsa*/
		    	foreach ($bolsa as $p) {
		    		$data_bolsa = [
						'id_usuario' => $userID,
						'id_producto' => $p['id_producto'],
						'cantidad_bolsa' => $p['cantidad_bolsa']
					];
					$unique = [
						'conditional' => 'id_producto = ? AND id_usuario= ? AND tm_delete IS NULL',
						'params' => ['ii',$p['id_producto'],$userID]
					];
					$update_bolsa = CRUD::insert('bolsa_compras',$data_bolsa,$unique);
		    	}
		    	/*#Ajustar Bolsa*/

		    	/*Validar Bolsa*/
		    	if ($countCart <> CRUD::numRows('bolsa_compras','*','id_usuario = ?',['i',$userID])) {
			    	CRUD::delete('usuarios','id_usuario = ?',$userID);
			    	CRUD::delete('bolsa_compras','id_usuario = ?',$userID);
		    		$result = 'error';
					$msn = 'ERROR_BAG_UPDATE';
					errorPayment();
					return false;
		    	}else{
		    		/*Session*/
					$_SESSION['user'] = $address['nombre_direccion'];
					$_SESSION['id_usuario'] = $userID;
				  	$_SESSION['csrf_token'] = Secure::crear_csrf_token();
				 	$_SESSION['csrf_token_time'] = time();
			    	/*Session*/
			    	$nombre_usuario  = $address['nombre_direccion'];
		    	}
		    	/*#Validar Bolsa*/

		    	/*Ajustar dirección*/
					CRUD::falseDelete('usuarios_direcciones','correo = ? AND tm_delete is NULL',['s',$correo]);	
					$data_address = Cookie::readCookie('addr_us_shp');
					$data_address['id_usuario'] = $userID;
					unset($data_address['nombre_departamento']);
					unset($data_address['nombre_ciudad']);
					unset($data_address['clave']);
					$unique_address = [
						'conditional' => 'nombre_direccion = ? AND id_usuario = ? AND correo = ? AND id_departamento = ? AND id_ciudad = ? AND direccion = ? AND telefono = ? AND tm_delete IS NULL',
						'params' => ['sisiisi',$data_address['nombre_direccion'],$data_address['id_usuario'],$data_address['correo'],$data_address['id_departamento'],$data_address['id_ciudad'],$data_address['direccion'],$data_address['telefono']]
					];
					$nueva = CRUD::insert('usuarios_direcciones',$data_address,$unique_address); /*Insertar Direccion*/
					if ($nueva[0]->affected_rows === 1) {
						Cookie::deleteCookie('addr_us_shp');
					}
				/*#Ajustar dirección*/

		    	/*Ajustar dirección*/
				if (isset($_COOKIE['coupon'])) {
					$cupon = Cookie::readCookie('coupon');
					$agregarCupon = new Coupon;
					$agregarCupon->newUserCoupon($cupon['clave_cupon']);
				}
		    	/*#Ajustar dirección*/
		    }
		/*crear cuenta de usuario*/
	}else{
		$userID = $_SESSION['id_usuario'];
		$buscar_correo = CRUD::all('usuarios','*','id_usuario = ?',['i',$userID]);
		$nombre_usuario = $buscar_correo[0]['nombre'].' '.$buscar_correo[0]['apellido_usuario'];
		$correo = $buscar_correo[0]['correo'];
	}

/*=============================================================================*/
	// VENTA
/*=============================================================================*/
	
	$fechaUnix = time();
	$serial_venta = $userID."-".$fechaUnix;

	/*Ajustar Venta Segmentada*/
	foreach ($bolsa as $pd) {
		$set = [
			'serial_venta' => $serial_venta,
			'id_producto' => $pd['id_producto'],
			'cantidad' => $pd['cantidad_bolsa'],
			'precio_unitario' => $pd['precioAntesDescuento'],
			'descuento' => $pd['descuentoPorProducto'],
			'precio_total_producto' => $pd['precio_total'],
		];
		$unique_segmentada = [
			'conditional' => 'serial_venta = ? AND id_producto = ?',
			'params' => ['si',$serial_venta,$pd['id_producto']]
		];
		$update_venta = CRUD::insert('ventas',$set,$unique_segmentada);
		if ($update_venta[0]->affected_rows === 0) {
			CRUD::falseDelete('ventas','serial_venta = ?',['s',$serial_venta]);
			$result = 'error';
			$msn = 'ERROR_SALE_UPDATE_SEG';
			errorPayment();
			return false;
		}
	}
	/*#Ajustar Venta Segmentada*/

	/*Ajustar Venta Detallada*/
		// Buscar Dirección
			$where = 'id_usuario = ? AND tm_delete IS NULL';
			$params = ['s',$userID];
			$id_direccion = CRUD::all('usuarios_direcciones','*',$where,$params);
			$addressID = $id_direccion[0]['id_direcciones'];
		// Buscar Dirección

		// Buscar Cupon
				$cuponID = 0;
			if ($carrito->cupon > 0) {
				$id_cupon = CRUD::all('productos_cupones','id_producto_cupon','clave_cupon = ?',['s',$carrito->cupon_descuento]);
				if (count($id_cupon) > 0) {
					$cuponID = $id_cupon[0]['id_producto_cupon'];

					$set_cupon = [
						'id_producto_cupon' => $cuponID,
						'id_usuario' => $userID,
					];

					$unique_cupon = [
						'conditional' => 'id_usuario = ? AND id_producto_cupon = ? AND tm_delete IS NULL AND tm_used IS NULL',
						'params' => ['ii',$userID,$cuponID]
					];

					CRUD::insert('usuario_cupon',$set_cupon,$unique_cupon);
					Cookie::deleteCookie('coupon');
				}
			}
		// #Buscar Cupon

		$set = [
			'serial_venta' => $serial_venta,
			'id_usuario' => $userID,
			'precio_productos' => $carrito->totalAntesDeDescuento,
			'precio_envio' => $carrito->costoEnvio,
			'venta_descuento' => $carrito->totalDescuento,
			'id_producto_cupon' => $cuponID,
			'valor_cupon' => $carrito->cupon,
			'precio_total' => $carrito->precioFinal,
			'fecha_venta' => date("Y-m-d h:i:s"),
			'id_estado' => 1,
			'id_direccion_envio' => $addressID
		];
		
		$unique_detallada = [
			'conditional' => 'serial_venta = ?',
			'params' => ['s',$serial_venta]
		];
		$update_detallada = CRUD::insert('venta_detalle',$set,$unique_detallada);
		if ($update_detallada[0]->affected_rows === 0) {
			CRUD::falseDelete('ventas','serial_venta = ?',['s',$serial_venta]);
			$result = 'error';
			$msn = 'ERROR_SALE_UPDATE_DET';
			errorPayment();
			return false;
		}
	/*#Ajustar Venta Detallada*/

	/*Ajustar productos cantidad*/
		$description = '';
		foreach ($bolsa as $pd) {
			$where = 'id_producto = ?';
			$params = ['i',$pd['id_producto']];
			$cantidad_salida = CRUD::all('productos_cantidad','cantidad_salida',$where,$params);
			$nueva_cantidad_salida = $cantidad_salida[0]['cantidad_salida'] + $pd['cantidad_bolsa'];
			$set = [
				'cantidad_salida' => $nueva_cantidad_salida,
			];
			CRUD::update('productos_cantidad',$set,$where,$params);


			$buscar_productos = CRUD::all('productos','nombre_producto',$where,$params);
			$description .= $buscar_productos[0]['nombre_producto'].' X'.$pd['cantidad_bolsa'].', ';
		}
		$description = substr($description, 0, -2);
		$description .= '.';
	/*#Ajustar productos cantidad*/

	/*Ajustar Bolsa*/
		CRUD::falseDelete('bolsa_compras','id_usuario = ? AND tm_delete IS NULL',['i',$userID]);
		Cookie::deleteCookie('bolsa');
	/*#Ajustar Bolsa*/

	/*Ajustar usuarios_cupones*/
		if ($carrito->cupon > 0) {
			$set = [
				'tm_used' => date("Y-m-d h:i:s"),
			];	
			$where = 'id_producto_cupon = ? AND id_usuario = ? AND tm_delete IS NULL AND tm_used IS NULL';
			$params = ['ii',$cuponID,$userID];
			CRUD::update('usuario_cupon',$set,$where,$params);
		}
	/*#Ajustar usuarios_cupones*/


	function errorPayment()
	{	
		// echo $GLOBALS['msn'];
		header('Location: '.URL_BASE.'page/caja/'.$GLOBALS['result'].''.$GLOBALS['msn']);
		return false;
	}


/*=============================================================================*/
	// PAYU FORM
/*=============================================================================*/
	define('merchantId', 551673);
	define('accountId', 553986);
	define('apiKey', 'excqG5aBcQhOehZNEWDcFyQiBL');
	define('currency', 'COP');
	$referenceCode = $serial_venta;
	$amount = $carrito->precioFinal;

	/*Buscar nombre_ciudad*/
		$buscar_ciudad = CRUD::all('ciudades','nombre_ciudad','id_ciudad = ?',['i',$id_direccion[0]['id_ciudad']]);
		$nombre_ciudad = $buscar_ciudad[0]['nombre_ciudad'];
	/*Buscar nombre_ciudad*/

	$signature = md5(apiKey."~".merchantId."~".$referenceCode."~".$amount."~".currency);
?>


<form method="post" id="form_payu" action="https://gateway.payulatam.com/ppp-web-gateway/">

	<!-- Cuenta -->
  	<input name="merchantId"    type="hidden"  value="<?php echo merchantId; ?>">
  	<input name="accountId"     type="hidden"  value="<?php echo accountId; ?>" >
  	<input name="signature"     type="hidden"  value="<?php echo $signature; ?>"  >
  	<input name="description"   type="hidden"  value="<?php echo $description; ?>"  >
	<!-- #Cuenta -->

	<!-- Información de Compra -->
  	<input name="referenceCode" type="hidden"  value="<?php echo $referenceCode; ?>" >
  	<input name="amount"        type="hidden"  value="<?php echo $amount; ?>"  >
  	<input name="tax"           type="hidden"  value="0">
  	<input name="taxReturnBase" type="hidden"  value="0">
  	<input name="currency"      type="hidden"  value="<?php echo currency; ?>" >
  	<input name="test"          type="hidden"  value="0" ><!-- 1 para test 0 para produccion -->
	<!-- #Información de Compra -->

  	<!-- Info del comprador -->
	<input name="buyerFullName" type="hidden"  value="<?php echo $nombre_usuario; ?>">
  	<input name="buyerEmail"    type="hidden"  value="<?php echo $correo; ?>" >
  	<!-- Info del comprador -->

  	<!-- Info de envío -->
  	<input type="hidden" name="shippingAddress" value="<?php echo $id_direccion[0]['direccion']; ?>">
	<input type="hidden" name="shippingAddress" value="<?php echo $nombre_ciudad; ?>">
	<input type="hidden" name="shippingAddress" value="CO">
	<input type="hidden" name="telephone" value="<?php echo $id_direccion[0]['telefono']; ?>">
  	<!-- #Info de envío -->

  	<!-- Response -->
  	<input name="responseUrl"    	type="hidden"  value="https://www.ennavidad.com/payment/" >
  	<input name="confirmationUrl"   type="hidden"  value="https://www.ennavidad.com/payment/confirmacion.php" >
  	<!-- #Response -->

  	<input type="submit" style="opacity: 0;" name="Submit" value="Enviar" >

</form>

<script src="<?php echo URL_BASE; ?>assets/js/jquery-1.11.1.min.js"></script>

<?php if (isset($signature)): ?>	
	<script type="text/javascript">
		$('#form_payu').submit();
	</script>
<?php endif ?>