<?php

	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();

	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	require DIRECTORIO_ROOT.'admin/bd/pedidos/plantilla_mail_confirmacion.php';

	
	$confirmacion = new SendMail($data['usuario_email'],'gifts@madeitforu.com');
	$confirmacion->headers('MADEITFORU',$data['nombre_usuario']);
	$confirmacion->content($content->title_head,$message);
	
	if ($confirmacion->send()) {
		$msn = 'Resumen de compra enviada a '.$data['usuario_email'];
		header('Location: '.ADMIN.'pages/pedidos.php?bd=success&msn='.$msn);
	} else {
		$msn = 'No hemos podido enviar el correo a '.$data['usuario_email'].', vuelve a intentarlo.';
		header('Location: '.ADMIN.'pages/pedidos.php?bd=error&msn='.$msn);
	}
	
