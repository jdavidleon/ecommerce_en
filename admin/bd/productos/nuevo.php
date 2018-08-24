
	<h3 style="margin: 0 auto;">
		Se esta cargando el producto, por favor espera mientras se comprimen las imagenes y se guardan...
	</h3>

<?php 

	require "../../../config/config.php";
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/Exception.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/ResultMeta.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/Result.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/Source.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/Client.php");
	require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify.php");
	\Tinify\setKey("9cUyo6gh8JziDBzIAtwrcocrgYuL-6Fy");


	if (Adminproducts::nuevoProducto()) {
		$msn = 'Productos cargado correctamente. Imagenes comprimidas: ('.Adminproducts::$count_compression.')';
		header('Location: '.URL_BASE.'admin/pages/productos.php?bd=success&msn='.$msn);
	}else{
		CRUD::falseDelete('productos_imagenes','serie = ?',['s',Adminproducts::$_serial_producto]);
		$msn = 'Ha ocurrido un error al ingresar a la Base de Datos';
		header('Location: '.URL_BASE.'admin/pages/productos.php?bd=error&msn='.$msn);
	}

?>