<?php


	/*=================================================*/
	// Autoload
	spl_autoload_register( function ($nombre_clase) {
		include DIRECTORIO_ROOT.'class/class.'.$nombre_clase.".php";
	});
	/*=================================================*/

	/*=================================================*/
	// Autologin
		session_start();
		$log_in = Cookie::readCookie('lg_us_rem');
		if ($log_in AND !$log_in['close']) {
			$where = 'correo = ? AND clave = ? AND tm_delete IS NULL';
			$params = ['ss',$log_in['correo'],Secure::montar_clave_verificacion($log_in['clave'])];
			$user_info = CRUD::all('usuarios','*',$where,$params);
			if (count($user_info) > 0) {
				$_SESSION['user'] = Sqlconsult::escape($user_info[0]['nombre']);
				$_SESSION['id_usuario'] = $user_info[0]['id_usuario'];
			  	$_SESSION['csrf_token'] = parent::crear_csrf_token();
			 	$_SESSION['csrf_token_time'] = time();
			}
		}	

		$session = false;
		if (isset($_SESSION['id_usuario'])) {
			$session = true;
		}
	/*=================================================*/

	/*=============================================*/
	// maintenance
		Secure::maintenance();
		// echo Secure::getUserIP();
	/*=============================================*/

	/*=============================================*/
	// modal newsletter
		$fist_shop_coupon = Cookie::readCookie('frst_clin_vst');
		$modal_coupon_fist_shop = false;
		$registered = false;
		if ($fist_shop_coupon === false) {
			$arrayCookieWelcomeCoupon[0] = [
				'new' => 'ok',
				'registered' => false,
				'name' => null,
				'mail' => null,
				'times' => 1,
			];
			Cookie::createCookie('frst_clin_vst',$arrayCookieWelcomeCoupon,31536000);
		}else{
			if (!$fist_shop_coupon[0]['registered']) {
				$times = $fist_shop_coupon[0]['times'] + 1;
				$key = [
					'registered' => false
				];
				$update = [ 
					'times' => $times,
				];
			 	Cookie::updateCookie('frst_clin_vst',$key,$update);

				if (
					$fist_shop_coupon === false || 
					$fist_shop_coupon[0]['times'] === 6 || 
					$fist_shop_coupon[0]['times'] === 12 || 
					$fist_shop_coupon[0]['times'] === 22
					) 
				{
					$modal_coupon_fist_shop = true;
				}
			}
		}
	/*=============================================*/



	/*=============================================*/
	// Whatsapp API
		$whatsapp = 3014494415;
		$wappTxt = 'Hola, tengo interés los productos navideños. Mi nombre es ';
	/*=============================================*/

	/*=============================================*/
	// config datetime
		date_default_timezone_set('America/Bogota');
	/*=============================================*/
