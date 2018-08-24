<?php 
	
	spl_autoload_register( function ($nombre_clase) {
		include '../../class/class.'.$nombre_clase.".php";
	});

	if (Cookie::readCookie('msn_coo_pol') === false) {
		$data = [
			'crt' => true
		];
		Cookie::createCookie('msn_coo_pol',$data,2592000*12);
	}