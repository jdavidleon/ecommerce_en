<?php
	define('merchantId', 551673);
	define('accountId', 553986);
	define('apiKey', 'excqG5aBcQhOehZNEWDcFyQiBL');
	define('currency', 'COP');

	$ApiKey = apiKey;
	$merchant_id = $_REQUEST['merchantId'];
	$referenceCode = $_REQUEST['referenceCode'];
	$TX_VALUE = $_REQUEST['TX_VALUE'];
	$New_value = number_format($TX_VALUE, 1, '.', '');
	$currency = $_REQUEST['currency'];
	$transactionState = $_REQUEST['transactionState'];
	$firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
	$firmacreada = md5($firma_cadena);
	$firma = $_REQUEST['signature'];
	$reference_pol = $_REQUEST['reference_pol'];
	$cus = $_REQUEST['cus'];
	$extra1 = $_REQUEST['description'];
	$pseBank = $_REQUEST['pseBank'];
	$lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
	$transactionId = $_REQUEST['transactionId'];

	if ($_REQUEST['transactionState'] == 4 ) {
		$estadoTx = "Transacción aprobada";
		CRUD::update('venta_detalle',['id_estado' => 2],'serial_venta = ?',['s',$referenceCode]);
	}

	else if ($_REQUEST['transactionState'] == 6 ) {
		$estadoTx = "Transacción rechazada";	
		CRUD::update('venta_detalle',['id_estado' => 8],'serial_venta = ?',['s',$referenceCode]);
	}

	else if ($_REQUEST['transactionState'] == 104 ) {
		$estadoTx = "Error";
		$estadoTx = "Transacción rechazada";	
		CRUD::update('venta_detalle',['id_estado' => 10],'serial_venta = ?',['s',$referenceCode]);		
	}

	else if ($_REQUEST['transactionState'] == 7 ) {
		$estadoTx = "Transacción pendiente";
	}

	else {
		$estadoTx = "Transacción pendiente";
	}

?>

<div class="w3l_banner_nav_right">
<!-- privacy -->
		<div class="privacy">
			<div class="privacy1">
				<h3>Respuesta de la Transacción</h3>				
				<div class="banner-bottom-grid1 privacy2-grid">
					<div class="privacy2-grid1 text-center">
						<?php if (strtoupper($firma) == strtoupper($firmacreada)): ?>
							
							<div class="row text-center">
								<div class=" text-center"
									<br><br>
									<table class="table table-bordered table-hover"  style=" color: black;">
									<tr>
									<td>Estado de la transaccion</td>
									<td><?php echo $estadoTx; ?></td>
									</tr>
									<tr>
									<tr>
									<td>ID de la transaccion</td>
									<td><?php echo $transactionId; ?></td>
									</tr>
									<tr>
									<td>Referencia de la venta</td>
									<td><?php echo $reference_pol; ?></td> 
									</tr>
									<tr>
									<td>Referencia de la transaccion</td>
									<td><?php echo $referenceCode; ?></td>
									</tr>
									<tr>
									<?php
									if($pseBank != null) {
									?>
										<tr>
										<td>cus </td>
										<td><?php echo $cus; ?> </td>
										</tr>
										<tr>
										<td>Banco </td>
										<td><?php echo $pseBank; ?> </td>
										</tr>
									<?php
									}
									?>
									<tr>
									<td>Valor total</td>
									<td>$<?php echo number_format($TX_VALUE); ?></td>
									</tr>
									<tr>
									<td>Moneda</td>
									<td><?php echo $currency; ?></td>
									</tr>
									<tr>
									<td>Descripción</td>
									<td><?php echo ($extra1); ?></td>
									</tr>
									<tr>
									<td>Entidad:</td>
									<td><?php echo ($lapPaymentMethod); ?></td>
									</tr>
									</table>
								</div>
							</div>
							<div class="row">
								
							</div>
						<?php else: ?>
							<h2>Error validando firma digital.</h2>
							<br>
							<p>
								Ha ocurrido un error con el procesamiento de la transacción. Si has realizado el pago verifica que haya llegado el correo de PayU confirmando tu pago. Si no has recibido el correo de confirmación <a href="">CONTÁCTANOS</a> y nos haremos cargo del seguimiento de tu transacción.
							</p>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
<!-- //privacy -->
		</div>
		<div class="clearfix"></div>