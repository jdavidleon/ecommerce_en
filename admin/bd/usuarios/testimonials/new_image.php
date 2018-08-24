<?php	

	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest();
		
	$name = 'img_testimonial';

	$image = new Image();

	if (!$image->validateFormat($name)) {
		return false;
	}

	$image->validateFormat($name)->folders($name);
	
	$segment = $image->segment($_FILES[$name],0);
	$img = $segment->file;

	CRUD::all('usuarios_testimonios')

	$name_file = 'user_test_'.;

	$image->compress($file,$route);