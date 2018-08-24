<?php 

 	session_start();

 	require "../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$lang = $_POST['lang'];
	
	if (!isset($_SESSION['id_usuario'])) {
		header('Location: '.URL_BASE.$lang.'/checkout/');
	}

	$data = Secure::peticionRequest();

	$newCoupon = new Coupon;
	$userCoupon = $newCoupon->findUserCoupon();
	$data['cupon'] = 0;
	$data['id_producto_cupon'] = 0;
	$data['id_usuario_cupon'] = $newCoupon->cuponUsuarioID;

	if ($userCoupon !== false) {
		$data['cupon'] = $newCoupon->calculateCoupon($userCoupon);

		$where = 'usuario_cupon.id_usuario = ? AND usuario_cupon.tm_delete IS NULL AND usuario_cupon.tm_expire IS NULL AND usuario_cupon.tm_used IS NULL';
			$params = ['i',$_SESSION['id_usuario']];
			$join = [
				['INNER','productos_cupones','productos_cupones.id_producto_cupon = usuario_cupon.id_producto_cupon'],
			];
			$cupon = CRUD::all('usuario_cupon','productos_cupones.id_producto_cupon',$where,$params,$join);


		$data['id_producto_cupon'] =	$cupon[0]['id_producto_cupon'];
	}

	$data['id_usuario'] = $_SESSION['id_usuario'];

	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}

	$nuevo = Orders::newOrder($data);

	if ($nuevo) {
		$serial = Orders::$_serial;
		include DIRECTORIO_ROOT.'bd/paypal/form-paypal.php';
	}
?>

	
	<script src="<?php echo URL_BASE; ?>js/jquery.min.js"></script>


	<?php if ($nuevo): ?>
		<script type="text/javascript">
			$('#paypalForm').submit();
		</script>
	<?php else: ?>
		<?php $msn = 'Por favor revisa tu cesta ha ocurrido un problema al porcesar tu solicitud.'; ?>
		<?php header('Location: '.URL_BASE.$lang.'/checkout/basket'); ?>
	<?php endif ?>
