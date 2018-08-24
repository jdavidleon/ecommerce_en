<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}

	$unique = [	
			'conditional' => 'nombre_sub_categoria_es = ? OR nombre_sub_categoria_en = ?', 
			'params' => ['ss',$data['nombre_sub_categoria_es'],$data['nombre_sub_categoria_en']]
		];
	$insertar = CRUD::insert('categorias_sub',$data,$unique);

	if ($insertar[0]->affected_rows > 0) {
		$msn = 'Sub-categoria Ingresada Exitosamente';
		header('Location: '.URL_BASE.'admin/?action=true&result='.$msn);
	}elseif (CRUD::numRows('categorias_sub','*',$unique['conditional'],$unique['params']) > 0) {
		$msn = 'Esta sub-categoria ya se encuentra registrada';
		header('Location: '.URL_BASE.'admin/?action=false&result='.$msn);
	}else{
		$msn = 'Ha ocurrido un error. Por favor intentalo Nuevamente';
		header('Location: '.URL_BASE.'admin/?action=false&result='.$msn);
	}