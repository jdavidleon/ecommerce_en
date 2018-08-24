<?php 
  	$user = '';
  	$psw = '';
  	$rmb = '';

  	if (isset($_COOKIE['log_in'])) {
    	$verDatos = Cookie::readCookie('log_in');
    	$user = $verDatos[0]['user'];
    	$psw = $verDatos[0]['clv'];
   		$rmb = 'checked';
  	}

  	$mail = '';
  	if (isset($_GET['mail'])) {
  		$mail = $_GET['mail'];
  	}

  	if (isset($_GET['msn'])) {
  		switch ($_GET['msn']) {
  			case 'ERROR_DATA_REQUEST':
  				$error_msn = 'Ha ocurrido un error con los datos recibidos, intentalo nuevamente.';
  			break;
  			case 'INVALID_MAIL':
  				$error_msn = 'Debes ingresar un formato de correo válido';
  				break;
  			case 'ERROR_VAL_LOG_MAIL_PSW':
  			case 'COUNT_LOST':
  			case 'LENGHT_PASSWORD':
  				$error_msn = 'El usuario o contraseña es incorrecta, por favor verifica los datos ingresados';
  				break;
  			case 'LENGHT_PASSWORD':
  				$error_msn = 'tu contraseña debe tener entre 8 y 15 caracteres';
  				break;
  			case 'INCONMPLETE_FORM':
  				$error_msn = 'Debes ingresar todos los datos para continuar';
  				break;
  			case 'ERR_LOG_CUENTA_BLOQUEADA':
  				$error_msn = 'La cuenta se encuentra bloqueada por varios intentos fallidos de iniciar sesión. Para restaurarla ingresa en <a href="'.URL_BASE.'page/usuarios/recuperar-clave/">Olvidé mi contraseña</a>';
  				break;
  			case 'ERR_LOG_CUENTA_BLOQUEADA':
  				$error_msn = 'Tu cuenta se encuentra inactiva. Por favor ingresa <a href="">aquí</a> para activarla';
  				break;
  			case 'ERROR_ACCEPT_TERMS':
  				$error_msn = 'Debes aceptar los terminos para continuar';		
  				break;
  			case 'MAIL_PREV_REG':
  				$error_msn = 'El correo ingresado ya se encuentra registrado si no recuerdas tu contraseña, puedes restablecerla <a href="'.URL_PAGE.'page/usuarios/recuperar-clave/">AQUÍ</a>.';
  				break;
  			case 'ERROR_GLB_SIGNUP':
  				$error_msn = 'Ha ocurrido un problema con la creación de tu cuenta por favor inténtalo, nuevamente.';
  				break;
  			case 'created_account':
  				$error_msn = 'Se ha creado tu cuenta. Hemos enviado un correo a <b>'.$mail.'</b> para validar tu cuenta. por favor revisa la bandeja de entrada. No olvides revisar en spam.';
  				break;
  		}
  	}

?>
	
		<div class="w3l_banner_nav_right">
<!-- login -->
		<div class="w3_login">
			<h3>				
				<?php if ($_GET['usuario'] == 'registrarse'): ?>
					Registrarse
				<?php else: ?>
					Iniciar Sesión
				<?php endif ?>
			</h3>

			
				<?php if (isset($_GET['result'])): ?>
					<?php if ($_GET['result'] === 'error'): ?>
						<div class="col-lg-12" style="margin: 20px;">
							<div class="alert alert-danger alert-dismissible text-center" role="alert">
							  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  		<span aria-hidden="true">&times;</span>
							  	</button>
							  	<strong class="text-uppercase">Ha Ocurrido un error!</strong> 
							  	<?php echo $error_msn; ?>
							</div>
						</div>	
					<?php elseif($_GET['result'] === 'success'): ?>	
						<div class="col-lg-12" style="margin: 20px;">
							<div class="alert alert-success alert-dismissible text-center" role="alert">
							  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  		<span aria-hidden="true">&times;</span>
							  	</button>
							  	<?php echo $error_msn; ?>
							</div>
						</div>			
					<?php endif ?>
						<br class="hidden-xs hidden-sm">
						<br class="hidden-xs hidden-sm">
						<br class="hidden-xs hidden-sm">
				<?php endif ?>
				<?php 


				 ?>
			<div class="w3_login_module">
				<div class="module form-module">
				  	<?php if ($_GET['usuario'] == 'iniciar-sesion'): ?>
					  	<div class="form">
							<h2>Crear Cuenta</h2>
							<form action="<?php echo URL_BASE.'bd/users/nuevo.php' ?>" method="post" role="form">
								<input type="hidden" name="empt_val">
								<input type="text" name="nombre" placeholder="Nombre" required>
								<input type="text" name="apellido_usuario" placeholder="Apellido" required>
								<input type="email" name="correo" placeholder="Correo" required>
								<input type="password" name="clave" placeholder="Contraseña" required>
								<label>Soy: </label><br>
								<label class="radio-inline">
									<input type="radio" name="sexo" value="F" required> Mujer
								</label>
								<label class="radio-inline">
									<input type="radio" name="sexo" value="M"> Hombre
								</label>
								<br>
								<br>
								<label>
									<input type="checkbox" name="accept_terms" value="on" required>
    								<span>
    									<small>
    										Acepto los <a href="<?php echo URL_BASE.'page/politicas/terminos-y-condidiones'; ?>" target="_blank">Términos y Condiciones</a>
    									</small>
    								</span>
    							</label>

								<input style="margin-top: 15px;" type="submit" value="Registrarme">
							</form>
					  	</div>
						<div class="form">
							<h2>Ingresar a tu cuenta</h2>
							<form action="<?php echo URL_BASE.'bd/users/login.php' ?>" method="post">
								<input type="hidden" name="empt_val">
								<input type="text" name="correo" placeholder="Correo" value="<?php echo $user; ?>" required>
								<input type="password" name="clave" placeholder="Contraseña" value="<?php echo $psw; ?>" required>
								<label>
									<input type="checkbox" name="recordar" value="true" <?php echo $rmb; ?>>
    								<span>Guardar contraseña</span>
    							</label>		
    								<br>
    								<br>
								<input type="submit" value="Ingresar">
							</form>
						</div>		
					<?php else: ?>	
						<div class="form">
							<h2>Ingresar a tu cuenta</h2>
							<form action="<?php echo URL_BASE.'bd/users/login.php' ?>" method="post">
								<input type="hidden" name="empt_val">
								<input type="text" name="correo" placeholder="Correo" value="<?php echo $user; ?>" required>
								<input type="password" name="clave" placeholder="Contraseña" value="<?php echo $psw; ?>" required>
								<label>
									<input type="checkbox" name="recordar" value="true" <?php echo $rmb; ?>>
    								<span>Guardar contraseña</span>
    							</label>		
    								<br>
    								<br>
								<input type="submit" value="Ingresar">
							</form>
						</div>				  	
					  	<div class="form">
							<h2>Crear Cuenta</h2>
							<form action="<?php echo URL_BASE.'bd/users/nuevo.php' ?>" method="post" role="form">
								<input type="hidden" name="empt_val">
								<input type="text" name="nombre" placeholder="Nombre" required>
								<input type="text" name="apellido_usuario" placeholder="Apellido" required>
								<input type="email" name="correo" placeholder="Correo" required>
								<input type="password" name="clave" placeholder="Contraseña" required>
								<label>Soy: </label><br>
								<label class="radio-inline">
									<input type="radio" name="sexo" value="F" required> Mujer
								</label>
								<label class="radio-inline">
									<input type="radio" name="sexo" value="M"> Hombre
								</label>
								<br>
								<br>
								<label>
									<input type="checkbox" name="accept_terms" value="on" required>
    								<span>
    									<small>
    										Acepto los <a href="<?php echo URL_BASE.'page/politicas/terminos-y-condidiones'; ?>" target="_blank">Términos y Condiciones</a>
    									</small>
    								</span>
    							</label>

								<input style="margin-top: 15px;" type="submit" value="Registrarme">
							</form>
					  	</div>
				  	<?php endif ?>
				  		<div class="cta toggle" style="margin-bottom: 1px !important;">
				  			<a>
				  				<?php if ($_GET['usuario'] == 'registrarse'): ?>
									Iniciar Sesión
								<?php else: ?>
									Registrarse
								<?php endif ?>
				  			</a>
				  		</div>
				  		<div class="cta">
				  			<a href="<?php echo URL_BASE.'page/usuarios/recuperar-clave/'; ?>">
				  				¿Ovidó su contraseña?
				  			</a>
				  		</div>
				</div>
			</div>
			<script>
				$('.toggle').click(function(){
				  // Switches the Icon

				  	if ($(this).children('a').html().trim() == 'Iniciar Sesión') {
				  		$(this).children('a').html('Registrarse');
				  	}else{
					  	if ($(this).children('a').html().trim() == 'Registrarse'){
					  		$(this).children('a').html('Iniciar Sesión');
					  	}
				  	}
				  	// Switches the forms  
				  	$('.form').animate({
						height: "toggle",
						'padding-top': 'toggle',
						'padding-bottom': 'toggle',
						opacity: "toggle"
				  	}, "slow");
				});
			</script>
		</div>
<!-- //login -->
		</div>
		<div class="clearfix"></div>