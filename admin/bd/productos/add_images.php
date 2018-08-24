<?php 
	require "../../../config/config.php";

	$data = Secure::recibirRequest();

	if (!$data) {
		$bd = 'error';
		$msn = 'No se a recibido la información necesaria';
		retornar();
		return false;
	}


	$cantidad = CRUD::numRows('productos_imagenes','*','serie = ?',['s',$data['serie']]);
	$contar = $cantidad + 1;



	$image = new Image;
	if (!$image->validateFormat('img_lg')) {
		$bd = 'error';
		$msn = 'Imagenes invalidas';
		retornar();
		return false;
	}

	$cantidadImagenes = $image->count_imgs;

	$principal_folder = 'img_productos/';
	$folders = [
		$principal_folder.$data['serie'],
		$principal_folder.$data['serie'].'/small',
		$principal_folder.$data['serie'].'/large',
		$principal_folder.$data['serie'].'/thumbnail',
	];
	$image->folders($folders);

	for ($i=0; $i < $image->count_imgs; $i++) { 
		$segment = $image->segment($_FILES['img_lg'],$i);
		$img = $segment->file;
		$name_large = 'producto_'.$data['serie'].'_large_'.$contar.'.'.$segment->extension;
		$name_small = 'producto_'.$data['serie'].'_small_'.$contar.'.'.$segment->extension;
		$name_thumbnail = 'producto_'.$data['serie'].'_thumbnail_'.$contar.'.'.$segment->extension;

		if (!isset($name_large) || !isset($name_small) || !isset($name_thumbnail)) {
			$bd = 'error';
			$msn = 'Imagenes invalidas';
			retornar();
			return false;
		}

		$route = DIRECTORIO_ROOT.'img_productos/'.$data['serie'].'/';
		$route_large = $route.'large/'.$name_large;
		$route_small = $route.'small/'.$name_small;
		$route_thumbnail = $route.'thumbnail/'.$name_thumbnail;

		$image->compress($img,$route_large);
		$image->resize('small',$img,$route_small);
		$image->resize('thumbnail',$img,$route_thumbnail);

		$contar++;

		$set = [
			'serie' => $data['serie'],
			'ruta_img_lg' => $name_large,
			'ruta_img_sm' => $name_small,
			'ruta_img_tn' => $name_thumbnail,
		];

		var_dump($set);

		CRUD::insert('productos_imagenes',$set);
	}
	$compresiones = $image->countCompressions();
	$bd = 'success';
	$msn = 'Imagenes Cargadas. Compresiones: '.$compresiones;
	retornar();
	return true;	


	function retornar()
	{
		header('Location: '.ADMIN.'pages/detalle_producto.php?id_producto='.$GLOBALS['data']['id_producto'].'&bd='.$GLOBALS['bd'].'&msn='.$GLOBALS['msn']);
		return true;
	}