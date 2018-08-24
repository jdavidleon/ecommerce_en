<?php 

	require '../config/config.php';

	define("API", "excqG5aBcQhOehZNEWDcFyQiBL");
	define('MONEDA', 'COP');

	$merchantId = trim($_REQUEST['merchant_id']);
	$referencia = trim($_REQUEST['reference_sale']);
	$valor = trim($_REQUEST['value']);
	$referencia = trim($_REQUEST['reference_sale']);
	$referenciaPayU = trim($_REQUEST['reference_pol']);
	$estado_transaccion = trim($_REQUEST['state_pol']);
	$firma = trim($_REQUEST['sign']);
	$mensaje_respuesta = trim($_REQUEST['response_message_pol']);
	$metodo_pago = trim($_REQUEST['payment_method_type']);
	$fecha_transaccion = trim($_REQUEST['transaction_date']);
	$codigo_autorizacion = trim($_REQUEST['authorization_code']);

	$value = number_format($valor,1);
	if (isset($_REQUEST['commision_pol'])) {
		$comision = $_REQUEST['commision_pol'];
	}

	$firmaCreada = md5(API."~".$merchantId."~".$referencia."~".$value."~".MONEDA."~".$estado_transaccion);

	if ($firma == $firmaCreada) {
		
		if ($estado_transaccion == 4) {
			CRUD::update('venta_detalle',['id_estado' => 3],'serial_venta = ?',['s',$referencia]);
		}elseif($estado_transaccion == 6) {
			CRUD::update('venta_detalle',['id_estado' => 10],'serial_venta = ?',['s',$referencia]);
		}elseif($estado_transaccion == 5){
			CRUD::update('venta_detalle',['id_estado' => 8],'serial_venta = ?',['s',$referencia]);
		}

	}


?>