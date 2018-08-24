<!-- Direccion -->
<?php 
	$nombre_direccion = $correo = $telefono = $direccion = $nombre_ciudad = '';
	$id_departamento = $id_ciudad = 0;
	$direccion_de_envio = false;	

	if ($session) {
		$user = new User($_SESSION['id_usuario']);
		$direcciones = User::address($_SESSION['id_usuario']);
		if (count($direcciones) > 0) {
			foreach ($direcciones[0] as $dr => $drVal) {
				$$dr = $drVal;
			}
			$direccion_de_envio = true;	
		}else{
			$info_user = $user->infoPersonal();
			$nombre_direccion = $info_user['nombre'].' '.$info_user['apellido_usuario'];
		}
	}elseif (Cookie::readCookie('addr_us_shp')) {
		foreach (Cookie::readCookie('addr_us_shp') as $dr => $drVal) {
			$$dr = $drVal;
		}
		$direccion_de_envio = true;	
	}
	
?>

<div class="col-md-8 address_form_agile">

<?php if ($direccion_de_envio): ?>
	
	<div class="text-center">
	 	<h4>Dirección de Envío</h4>	
		<address>
			<strong class="text-uppercase"><?php echo $nombre_direccion; ?></strong><br>
			<?php echo $direccion; ?><br>
			<?php echo $nombre_ciudad; ?>, <?php echo $nombre_ciudad; ?><br>
			Teléfono: <?php echo $telefono; ?><br>
			Correo: <?php echo $correo; ?>
		</address>
		<?php if ($session): ?>							
			<a href="<?php echo URL_BASE.'bd/users/address/edit.php?logged=true&id_direcciones='.$id_direcciones.'&empt_val=' ?>" class="btn text-uppercase" style="max-width: 200px; margin: 0 auto; text-decoration: underline;">Cambiar dirección</a>
		<?php else: ?>
			<a href="<?php echo URL_BASE.'bd/users/address/edit.php?logged=false&empt_val=' ?>" class="btn text-uppercase" style="max-width: 200px; margin: 0 auto; text-decoration: underline;">Cambiar dirección</a>
		<?php endif ?>
			<br class="hidden-lg hidden-md">
			<br class="hidden-lg hidden-md">
	    	<a href="" class="submit check_out" data-toggle="modal" data-target="#paymentModal" style="display: inline !important;">
	    		Realizar el Pago <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    	</a>
	 </div>

<?php else: ?>

	<h4>Agregar dirección de envío</h4>

	<?php if (!$session): ?>

		<div class="controls">
	    	<input class="form-control" id="mail_address_add" type="text" placeholder="Ingresa tu correo electrónico" required>
	    	<span class="text-danger prueba_test"></span>
		</div>

		<script type="text/javascript">
			$('#mail_address_add').on("keyup paste click",function () {
				var mail = $(this).val();
		           $('.correo_usuario').val(mail);
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		        if (!filter.test(mail)) {
		            $('.prueba_test').html('Ingresa un correo válido.');
		        }else{
		            $('.prueba_test').html('');
		            $datos  = {
			            'correo': mail,
			            'empt_val': ''
			        }
		            $.ajax({
					type: 'POST',
					data: $datos,
					url: base+'bd/users/address/buscar_cuenta.php',				
					success: function (data) {	
							responds = data.trim();	
							if (responds === 'log_in_required') {
								$('#form_log_in').removeClass('hide');
								$('#form_address').addClass('hide');
							}else{
								$('#form_log_in').addClass('hide');
								$('#form_address').removeClass('hide');
							}
						}
					})
		        }
			});
		</script>

		<br>
		<form action="<?php echo URL_BASE.'bd/users/login.php' ?>" method="POST" id="form_log_in" class="hide">
			<input type="hidden" name="empt_val">
			<input type="hidden" name="url" value="<?php echo URL_BASE.'page/caja/' ?>" >
			<input type="hidden" name="correo" class="correo_usuario" value="" required>
			<div class="controls div_pss_required">
			    <input class="form-control" type="password" name="clave" placeholder="Contraseña" required>
			</div>
			<br>
			<small>
				<b>
					Hemos encontrado una cuenta asociada a este correo. Por favor ingresa la contraseña.
				</b>
			</small>
			<br><br>
			<button class="submit check_out">Continuar</button>
		</form>

		<form action="<?php echo URL_BASE.'bd/users/address/new.php' ?>" method="post" class="creditly-card-form agileinfo_form hide" id="form_address">
			<section class="creditly-wrapper wthree, w3_agileits_wrapper">
				<div class="information-wrapper">
					<div class="first-row form-group">
						<input type="hidden" name="correo" class="correo_usuario" value="" required>
						<input type="hidden" name="empt_val">
						<div class="controls">
							<label class="control-label">Nombre Completo: </label>
							<input class="form-control" name="nombre" type="text" placeholder="Nombre" value="<?php echo $nombre_direccion; ?>" required>
						</div>
				
						<div class="controls">
							<label class="control-label">Teléfono:</label>
						    <input class="form-control" type="text" name="telefono" placeholder="Celular" value="<?php echo $telefono; ?>" required>
						</div>
						<div class="controls">
							<label class="control-label">Depatamento: </label>
							<select class="form-control" onchange="findCity(this)" name="id_departamento" style="width: 100%; padding: 0 10px;" required>

							 	<?php 
							 		$deps = CRUD::all('departamento'); 
							 	?>

								<?php if ($id_departamento !== 0): ?>
									<option value="<?php echo $deps[$id_departamento -1]['id_departamento'] ?>">
							 			<?php echo $deps[$id_departamento -1]['nombre_departamento'] ?>
									</option>
								<?php else: ?>
							 		<option></option>
								<?php endif ?>

							 		<option value="<?php echo $deps[32]['id_departamento'] ?>">
							 			<?php echo $deps[32]['nombre_departamento'] ?>
							 		</option>
							 	<?php foreach ($deps as $dep): ?>
							 		<?php if ($dep['id_departamento'] <> 33): ?>
								 		<?php if ($dep['id_departamento'] <> $id_departamento): ?>
								 			<option value="<?php echo $dep['id_departamento'] ?>">
									 			<?php echo $dep['nombre_departamento'] ?>
									 		</option>
								 		<?php endif ?>
							 		<?php endif ?>
							 	<?php endforeach ?>

							</select>
						</div>
						</div>
						<div class="controls">
							<label class="control-label">Ciudad: </label>
							<select class="form-control" name="id_ciudad" style="width: 100%; padding: 0 10px;" required>

								<?php if ($id_ciudad <> 0 && $id_departamento <> 0): ?>

								<?php $cdes = CRUD::all('ciudades','*','id_departamento = ?',['i',$id_departamento]) ?>

									<?php foreach ($cdes as $cdad): ?>
										<?php if ($cdad['id_ciudad'] === $id_ciudad): ?>
											<option value="<?php echo $cdad['id_ciudad'] ?>">
												<?php echo $cdad['nombre_ciudad']; ?>
											</option>
										<?php endif ?>
									<?php endforeach ?>

									<?php foreach ($cdes as $cdad): ?>
										<?php if ($cdad['id_ciudad'] !== $id_ciudad): ?>
											<option value="<?php echo $cdad['id_ciudad'] ?>">
												<?php echo $cdad['nombre_ciudad']; ?>
											</option>
										<?php endif ?>
									<?php endforeach ?>

								<?php else: ?>

									<option></option>

								<?php endif ?>

							</select>
						</div>

						<div class="controls">
							<label class="control-label">Dirección: </label>
							<input class="billing-address-name form-control" type="text" name="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>" required>
						</div>
					</div>

					<br><br>

					<button class="submit check_out">Guardar Dirección de Envío</button>
				</div>
			</section>
		</form>
	<?php else: ?>

		<form action="<?php echo URL_BASE.'bd/users/address/new.php' ?>" method="post" class="creditly-card-form agileinfo_form" id="form_address">
			<section class="creditly-wrapper wthree, w3_agileits_wrapper">
				<div class="information-wrapper">
					<div class="first-row form-group">
						<input type="hidden" name="correo" class="correo_usuario" value="" required>
						<input type="hidden" name="empt_val">
						<input type="hidden" name="correo" value="<?php echo $info_user['correo']; ?>">
						<div class="controls">
							<label class="control-label">Nombre Completo: </label>
							<input class="form-control" name="nombre" type="text" placeholder="Nombre" value="<?php echo $nombre_direccion; ?>" required>
						</div>
				
						<div class="controls">
							<label class="control-label">Teléfono:</label>
						    <input class="form-control" type="text" name="telefono" placeholder="Celular" value="<?php echo $telefono; ?>" required>
						</div>
						<div class="controls">
							<label class="control-label">Depatamento: </label>
							<select class="form-control" onchange="findCity(this)" name="id_departamento" style="width: 100%; padding: 0 10px;" required>

							 	<?php 
							 		$deps = CRUD::all('departamento'); 
							 	?>

								<?php if ($id_departamento !== 0): ?>
									<option value="<?php echo $deps[$id_departamento -1]['id_departamento'] ?>">
							 			<?php echo $deps[$id_departamento -1]['nombre_departamento'] ?>
									</option>
								<?php else: ?>
							 		<option></option>
								<?php endif ?>

							 		<option value="<?php echo $deps[32]['id_departamento'] ?>">
							 			<?php echo $deps[32]['nombre_departamento'] ?>
							 		</option>
							 	<?php foreach ($deps as $dep): ?>
							 		<?php if ($dep['id_departamento'] <> 33): ?>
								 		<?php if ($dep['id_departamento'] <> $id_departamento): ?>
								 			<option value="<?php echo $dep['id_departamento'] ?>">
									 			<?php echo $dep['nombre_departamento'] ?>
									 		</option>
								 		<?php endif ?>
							 		<?php endif ?>
							 	<?php endforeach ?>

							</select>
						</div>
						</div>
						<div class="controls">
							<label class="control-label">Ciudad: </label>
							<select class="form-control" name="id_ciudad" style="width: 100%; padding: 0 10px;" required>

								<?php if ($id_ciudad <> 0 && $id_departamento <> 0): ?>

								<?php $cdes = CRUD::all('ciudades','*','id_departamento = ?',['i',$id_departamento]) ?>

									<?php foreach ($cdes as $cdad): ?>
										<?php if ($cdad['id_ciudad'] === $id_ciudad): ?>
											<option value="<?php echo $cdad['id_ciudad'] ?>">
												<?php echo $cdad['nombre_ciudad']; ?>
											</option>
										<?php endif ?>
									<?php endforeach ?>

									<?php foreach ($cdes as $cdad): ?>
										<?php if ($cdad['id_ciudad'] !== $id_ciudad): ?>
											<option value="<?php echo $cdad['id_ciudad'] ?>">
												<?php echo $cdad['nombre_ciudad']; ?>
											</option>
										<?php endif ?>
									<?php endforeach ?>

								<?php else: ?>

									<option></option>

								<?php endif ?>

							</select>
						</div>

						<div class="controls">
							<label class="control-label">Dirección: </label>
							<input class="billing-address-name form-control" type="text" name="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>" required>
						</div>
					</div>

					<small class="text-center">
						El resumen de tu pedido y la confirmación de pago serán enviados a <b><?php echo $info_user['correo']; ?></b>, si deseas cambiarlo debes ir a <a style="text-decoration: underline;" href="<?php echo URL_PAGE; ?>page/usuarios/informacion-personal/">cuenta</a> y modificar información de cuenta.
					</small>
					<br><br>

					<button class="submit check_out">Guardar Dirección de Envío</button>
				</div>
			</section>
		</form>

	<?php endif ?>
<?php endif ?>

<?php if ($direccion_de_envio): ?>

	<div class="checkout-right-basket text-center">

    	<br><br>

    	<img style="max-width: 100%;" src="<?php echo URL_PAGE ?>images/logo_payments.png" alt="PayU Latam" border="0" />
	</div>
	<!-- Modal Pagos -->
	<div class="modal fade bs-example-modal-sm" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog modal-sm" role="document">
		    <div class="modal-content" id="modal_carrito">
		    	
				<div class="modal-body text-center">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;">
						<span aria-hidden="true">&times;</span>
					</button>
					<br>

					<p class="text-center" style="font-size: 30px; margin-top: 30px;">
						EL VALOR DE TU PEDIDO ES DE <br> 
						<span style="color: #51AB00;">
							<b>$ <?php echo number_format($carrito->precioFinal); ?></b>
						</span>
					</p>
					<br>
					<p class="text-center">
						<small>
							<b>IMPORTANTE:</b> 
								Al hacer clic en PAGAR serás redireccionado/a a la página de pagos PayU Latam para procesar tu pago de forma segura. Ahí podrás elegir entre los diferentes medios de pago (Tarjeta Débito, Crédito o Efectivo). 
							<b>
								<a style="background-color: transparent; color: #84C639; padding: 0; cursor: pointer;" onclick="masInfo();">
									Más Información
								</a>
							</b>
						</small>
					</p>
					<script type="text/javascript">
						function masInfo() {								
								$('.alert-mas-info').removeClass('hide');
							}
					</script>

					<div class="text-justify alert alert-success alert-dismissible hide alert-mas-info" role="alert">
						<p>
								ENNAVIDAD protege la información sensible de todos sus clientes. Por esta razón nos soportamos en la plataforma de nuestro aliado PayU, con el fin de que sean ellos directamente quienes procesen tu pago.
						</p>
						<br>
						<p>
							<b class="text-uppercase">Métodos de pago </b>
							<ul class="list-group">
								  <li class="list-group-item">
								  	<span>Tarjeta de Crédito:</span> Visa, MasterCard, American Express, Dinners Club, Codensa.
								  </li>
								  <li class="list-group-item">
								  	<span>Tarjetas Débito:</span> Todas a través de pago PSE.
								  </li>
								  <li class="list-group-item">
								  	<span>Pago en Efectivo:</span> A través de varias redes de pagos con cobertura a nivel nacional como SURED, BALOTO Y EFECTY. El comprador deberá dirigirse a cualquier punto para realizar el pago en efectivo con el número generado en la orden de pago. Inmediatamente se ingresa el pago a nuestra plataforma para procesarlo.
								  </li>
								  <li class="list-group-item">
								  	<span>Pago en Bancos:</span> PayU da la opción de realizar el pago a través de las sucursales bancarias de Bancolombia, Banco de Bogotá y Davivienda.
								  </li>
								  <li class="list-group-item">
								  	<span>PayU te fía:</span> Si eres un cliente habitual de PayU, la plataforma te fía hasta 15 días para que puedas realizar la compra y te da plazo de cancelarlo.
								  </li>
							</ul>
						</p>
					</div>

					<br>
					<form method="POST" class="text-center" action="<?php echo URL_PAGE; ?>bd/checkout/payment/process_payment.php">
						<input type="hidden" name="empt_val">
						<input type="hidden" name="precio_final" 	value="<?php echo $carrito->precioFinal; ?>"	>
						<input type="hidden" name="count_cart" 		value="<?php echo $countCart; ?>"				>
						
						<button type="submit" class="submit check_out" style="margin: 0 auto; font-size: 20px;">
							<b>PAGAR</b>
							<i class="fa fa-lock" aria-hidden="true"></i>
						</button>
					</form>

					<img class="methods-payu" src="<?php echo URL_PAGE ?>images/logo_payments.png" alt="PayU Latam" border="0" />
				</div>
		    </div>
		</div>
	</div>
	<!-- #Modal Pagos -->

<?php else: ?>
	
	<br><br>
	<div class="text-center">
    	<img class="" style="max-width: 100%; margin-top: 40px;" src="<?php echo URL_PAGE ?>images/logo_payments.png" alt="PayU Latam" border="0" />
	</div>

    <?php endif ?>

</div>
<!-- #Direccion -->