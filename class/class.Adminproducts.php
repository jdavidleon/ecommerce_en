<?php 	
/**
* Administrar Productos
*/
class Adminproducts extends Secure
{
	static $_data;
	public static $_serial_producto;
	public static $count_compression = 0;

	private static $_imgPrincipal;
	private static $_imgSecundaria;
	private static $_cantidadEntrada;

	private static function validacion()
	{	
		if (!parent::camposVacios()) {			
	    	echo 'Debes completar todos los campos';
	    	return false;
	    }

	    self::$_data = parent::recibirRequest();
	    self::$_cantidadEntrada = self::$_data['cantidad_entrada'];

	    // Validación para robots
	    if (self::$_data['empt_val'] !== "") {
	        return 'Datos enviados incorrectamente. Intentalo nuevamente';
	    }
	    return true;
	}

	private static function generarSerial()
	{
		$id_categoria = CRUD::find('categorias','identificador','id_categoria = ?',['i',self::$_data['id_categoria']]);
		$cate_id = $id_categoria[1]->fetch_assoc();
		$iden_cat = $cate_id['identificador'];
		$serial = CRUD::find('productos','MAX(id_producto) as id');
		$serie = $serial[1]->fetch_assoc();
		$IdProducto = $serie['id'] + 1;

		$serial =  $iden_cat.self::$_data['id_categoria'].$IdProducto;

		$unique = [
			'conditional' => 'serie = ?',
			'params' => ['s',$serial]
		];
		if (CRUD::unique('productos',$unique) == 0) {
			self::$_serial_producto = $serial;
		}		
	}

	public static function nuevoProducto()
	{	
		if (self::validacion()) {
			self::generarSerial();
		}else{
			return false;
		}

		if (!self::cargarImagenes()) {
			echo "Debes cargar Imagenes";
			return false;
		}

		$unique = [
			'conditional' => 'serie = ?',
			'params' => ['s',self::$_serial_producto]
		];


		$dataProducto = self::$_data;
		unset($dataProducto['publicacion']);
		unset($dataProducto['empt_val']);
		unset($dataProducto['dato']);
		unset($dataProducto['img_lg']);
		unset($dataProducto['cantidad_entrada']);
		$dataProducto['serie'] = self::$_serial_producto;
		
		$subirproducto = CRUD::insert('productos',$dataProducto,$unique);
		
		if ($subirproducto == false) {
			return false;
		}

		$buscarID = CRUD::find('productos','id_producto','serie = ?',['s',self::$_serial_producto]);
		$result = $buscarID[1]->fetch_assoc();

		$set = [
			'id_producto' => $result['id_producto'],
			'cantidad_entrada' => self::$_cantidadEntrada
		];
		$unique = [
			'conditional' => 'id_producto = ?',
			'params' => ['i',$result['id_producto']]
		];
		CRUD::insert('productos_cantidad',$set);

		for ($i=0; $i < 1; $i++) { 	
			$set = [
				'id_producto' => $result['id_producto'],
				'ruta_img_lg' => self::$_imgPrincipal['lg'],
				'ruta_img_sm' => self::$_imgPrincipal['sm'],
				'ruta_img_tn' => self::$_imgPrincipal['tn'],
			];
			$rutas_imagenes = CRUD::insert('productos_imagenes_principales',$set);
		}

		if ($subirproducto[0]->affected_rows > 0) {
			if (isset($_REQUEST['publicacion'])){
		   		$estado = "SI";
		   	}else{
		   		$estado = "NO";
			}
			$set = [
				'serie' => self::$_serial_producto,
				'estado_publicado' => $estado,
				'fecha_publicacion' => date('Y-m-d')
			];
			$unique = [
				'conditional' => 'serie = ?',
				'params' => ['s',self::$_serial_producto]
			];
			$publicacion = CRUD::insert('productos_publicados',$set,$unique);
			if ($publicacion[0]->affected_rows == 0) {
				return false;
			}	
			return true;
		}else{
			return false;
		}
	}

	public static function cargarImagenes()
	{	
		if (isset($_FILES['img_lg'])) {

			$image = new Image;
			if (!$image->validateFormat('img_lg')) {
				return false;
			}

			$cantidadImagenes = $image->count_imgs;

			$principal_folder = 'img_productos/';
			$folders = [
				$principal_folder.self::$_serial_producto,
				$principal_folder.self::$_serial_producto.'/small',
				$principal_folder.self::$_serial_producto.'/large',
				$principal_folder.self::$_serial_producto.'/thumbnail',
			];
			$image->folders($folders);

			$contar = 1;
			for ($i=0; $i < $image->count_imgs; $i++) { 
				$segment = $image->segment($_FILES['img_lg'],$i);
				$img = $segment->file;
				$name_large = 'producto_'.self::$_serial_producto.'_large_'.$contar.'.'.$segment->extension;
				$name_small = 'producto_'.self::$_serial_producto.'_small_'.$contar.'.'.$segment->extension;
				$name_thumbnail = 'producto_'.self::$_serial_producto.'_thumbnail_'.$contar.'.'.$segment->extension;

				if (!isset($name_large) || !isset($name_small) || !isset($name_thumbnail) || !isset(self::$_serial_producto)) {
					return false;
				}

				$route = DIRECTORIO_ROOT.'img_productos/'.self::$_serial_producto.'/';
				$route_large = $route.'large/'.$name_large;
				$route_small = $route.'small/'.$name_small;
				$route_thumbnail = $route.'thumbnail/'.$name_thumbnail;

				$image->compress($img,$route_large);
				$image->resize('small',$img,$route_small);
				$image->resize('thumbnail',$img,$route_thumbnail);

				if ($contar === 1) {
					self::$_imgPrincipal = [
						'lg' => $name_large,
						'sm' => $name_small,
						'tn' => $name_thumbnail,
					];
				}
				$contar++;

				$set = [
					'serie' => self::$_serial_producto,
					'ruta_img_lg' => $name_large,
					'ruta_img_sm' => $name_small,
					'ruta_img_tn' => $name_thumbnail,
				];

				var_dump($set);

				CRUD::insert('productos_imagenes',$set);
			}
			self::$count_compression = $image->countCompressions();
			return true;			
			
		}else{
			return false;
		}
	}

	
}
 ?>