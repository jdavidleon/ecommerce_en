<?php 
 	require "../../config/config.php";

	$data = Secure::peticionRequest();
	
	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}
	$data['correo_news'] = strtolower($data['correo_news']);

	if (!Secure::validar_correo($data['correo_news'])) {
		echo "Ingresa un correo válido";
		return false;
	}

	$where = 'correo_news = ? AND tm_delete IS NULL';
	$params = ['s',$data['correo_news']];

	if (CRUD::numRows('newsletter','*',$where,$params) === 0) {

		$set = [ 'correo_news' => $data['correo_news'] ];
		$unique = [
			'conditional' => $where,
			'params' => $params
		];
		$subscribe = CRUD::insert('newsletter',$set,$unique);
		if ($subscribe['0']->affected_rows === 1) {
			$bd = 'success';
			$msn = 'Te has registrado al newsletter';
		}else{
			$bd = 'error';
			$msn = 'Ha ocurrido un error. por favor intentalo nuevamente';			
		}


	}


	$key = [
		'registered' => false
	];
	$update = [ 
		'registered' => true,
	];
 	Cookie::updateCookie('frst_clin_vst',$key,$update);


 	header('Location: '.URL_PAGE.'?newsletter=reg_true');