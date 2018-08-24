<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	$unique = [	
		'conditional' => 'identificador = ? OR categoria_es = ? OR categoria_en = ?', 
		'params' => ['sss',$data['identificador'],$data['categoria_es'],$data['categoria_en']]
	];
	
	$insertar = CRUD::insert('categorias',$data,$unique);	

	if ($insertar[0]->affected_rows > 0) {
		$msn = 'Categoria Ingresada Exitosamente';
		header('Location: '.URL_BASE.'admin/?action=true&result='.$msn);
	}elseif (CRUD::numRows('categorias','*',$unique['conditional'],$unique['params']) > 0) {
		$msn = 'Esta categoria ya se encuentra registrada';
		header('Location: '.URL_BASE.'admin/?action=false&result='.$msn);
	}else{
		$msn = 'Ha ocurrido un error. Por favor intentalo Nuevamente';
		header('Location: '.URL_BASE.'admin/?action=false&result='.$msn);
	}