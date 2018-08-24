<div class="w3l_banner_nav_right">
<!-- login -->
		<div class="w3_login">
			<h3>Restablecer Contraseña</h3>

			<?php if (isset($error_msn)): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo $error_msn; ?>
				</div>
			<?php endif ?>

			<div class="w3_login_module">
				<div class="module form-module">
				  	<div class="toggle" style="cursor: initial; background-color: transparent;"></i>
				  	</div>
						<div class="form">
							<h2>Ingresar el correo registrado</h2>
							<form action="<?php echo URL_BASE.'page/usuarios/recuperar-clave' ?>" method="post">
								<input type="hidden" name="empt_val">
								<input type="text" name="correo" placeholder="Correo" value="" required>	
								<input type="submit" value="Ingresar">
							</form>
						</div>		
				  <div class="cta"><a href="<?php echo URL_BASE.'page/usuarios/iniciar-sesion/'; ?>">Iniciar Sesión</a></div>
				</div>
			</div>
		</div>
<!-- //login -->
		</div>
		<div class="clearfix"></div>