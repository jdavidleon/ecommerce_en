<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$image = new Image();

	if (!$image->validateFormat('img_cliente')) {
		return false;
	}

	$cantidadImagenes = $image->count_imgs;

	$principal_folder = 'img_client';
	$folders = [$principal_folder];
	$image->folders($folders);

	$idImg = CRUD::numRows('testimonials_img') + 1;

	$imageID = 'cliente_'.$idImg;

	for ($i=0; $i < $image->count_imgs; $i++) { 
		$segment = $image->segment($_FILES['img_cliente'],$i);
		$img = $segment->file;
		$name = $imageID.'.'.$segment->extension;

		$route = DIRECTORIO_ROOT.'img_client/'.$name;

		$image->resize('small',$img,$route);

		$set = [
			'ruta_img_test' => $name,
		];

		if (file_exists($route)) {
			$insert = CRUD::insert('testimonials_img',$set);
		}else{
			$msn = 'No hemos podido cargar la imagen, intentalo nuevamnete';
			header('Location: '.ADMIN.'?bd=error&msn='.$msn);
			return false;
		}		

		if ($insert[0]->affected_rows > 0) {
			$msn = 'Se ha cargado la imagen correctamente';
			header('Location: '.ADMIN.'?bd=success&msn='.$msn);
			return true;
		}else{
			$msn = 'No hemos podido cargar la imagen, intentalo nuevamnete';
			header('Location: '.ADMIN.'?bd=error&msn='.$msn);
			return true;			
		}
	}
				
	