<?php 
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 
	require DIRECTORIO_ROOT."config/autoload.php"; 
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/Exception.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/ResultMeta.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/Result.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/Source.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/Client.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify.php");
	\Tinify\setKey("9cUyo6gh8JziDBzIAtwrcocrgYuL-6Fy");

	if (isset($_FILES['img_test'])) {
		$cantidadImagenes = count($_FILES['img_test']['tmp_name']);

		/*Tipo de Archivo*/
		for ($i=0; $i < $cantidadImagenes; $i++) {
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$fileContents = file_get_contents($_FILES["img_test"]["tmp_name"][$i]);
			$mimetype = $finfo->buffer($fileContents);

			if ($mimetype != 'image/jpeg' AND $mimetype != 'image/png') {
				return false;
			}
		}	


		for ($i=0; $i < $cantidadImagenes; $i++) { 
			$tmlsID = CRUD::numRows('testimonials_img') + 1;
			$archivo=$_FILES['img_test']['tmp_name'][$i];
			$nombre=$_FILES['img_test']['name'][$i];
			$extencion_img = explode(".", $nombre);
			$namelg[$i]='tmls_'.$tmlsID.'.'.end($extencion_img);
			$rutalg=DIRECTORIO_ROOT.'img_client/'.$namelg[$i];
			
			$source = \Tinify\fromFile($archivo);
			$source->toFile($rutalg);
			
			$set = [
				'ruta_img_test' => $namelg[$i]
			];
			var_dump(CRUD::insert('testimonials_img',$set));
		}					

	}else{
		echo "Error";
		return false;
	}
	