<?php 

	$success_product_delete = 'Has eliminado un producto de tu cesta';
	$success_address_added = 'Dirección de entrega actualizada!';
	$cupon_agregado = 'Se ha aplicado el cupón.';
	$ERROR_DATA_REQUEST = 'Intentalo nuevamente';
	$ERROR_ADD_COUPON = 'El cupón que intentas ingresar no es válido o ya expiró.';
  	$ERROR_VAL_LOG_MAIL_PSW = $ERROR_DATA_REQUEST = $INVALID_MAIL = $COUNT_LOST = $LENGHT_PASSWORD =  'El usuario o contraseña es incorrecta, por favor verifica los datos ingresados';
  	$INCONMPLETE_FORM = 'Debes ingresar todos los datos para continuar';
  	$ERR_LOG_CUENTA_BLOQUEADA = 'La cuenta se encuentra bloqueada por varios intentos fallidos de iniciar sesión. Para restaurarla ingresa en <a href="'.URL_BASE.'page/usuarios/recuperar-clave/">Olvidé mi contraseña</a>';
  	$ERR_LOG_CUENTA_BLOQUEADA = 'Tu cuenta se encuentra inactiva. Por favor ingresa <a href="">aquí</a> para activarla';

?>

<div class="row">

	<?php if (isset($_GET['result'])): ?>

		<?php if ($_GET['result'] === 'error'): ?>

			<div class="col-lg-12">
				<div class="alert alert-danger alert-dismissible text-center" role="alert">
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  		<span aria-hidden="true">&times;</span>
				  	</button>
				  	<strong class="text-uppercase">Ha Ocurrido un error!</strong> <?php echo ${$_GET['msn']}; ?>
				</div>
			</div>

		<?php elseif($_GET['result'] === 'success'): ?>

			<div class="col-lg-12">
				<div class="alert alert-success alert-dismissible text-center" role="alert">
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  		<span aria-hidden="true">&times;</span>
				  	</button>
				  	<?php echo ${$_GET["msn"]}; ?>
				</div>
			</div>			

		<?php endif ?>
		
	<?php endif ?>

</div>