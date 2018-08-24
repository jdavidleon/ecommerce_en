<?php 

/**
* 
*/
class Image {
	
	private $_api_key_tinify = 'TSQLKOt7mBDq1u0MCI1Ze9QichHGdXg1';

	// Images
	private $_files_images;
	public $count_imgs;

	// Resize
	private $_small_resize = [
					    "method" => 'cover',
					    "width" => 400,
					    "height" => 400
					];
	private $_thumbnail_resize = [
					    "method" => 'cover',
					    "width" => 200,
					    "height" => 200
					];
	private $_profile_resize = [
					    "method" => 'cover',
					    "width" => 200,
					    "height" => 200
					];

	// Routes
	public $general_route;
	public $routes = [ 'large',	'small', 'thumbnail' ];

	function __construct()
	{	
		$require = DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify/";
		require_once($require.'Exception.php');
		require_once($require.'ResultMeta.php');
		require_once($require.'Result.php');
		require_once($require.'Source.php');
		require_once($require.'Client.php');
		require_once(DIRECTORIO_ROOT."admin/vendors/tinify-php-master/lib/Tinify.php");
		\Tinify\setKey($this->_api_key_tinify);
	}

	// Validar formato jpeg y png
	public function validateFormat($name)
	{	
		var_dump($_FILES);
		$this->_files_images = $_FILES[$name];
		$this->count_imgs = count($this->_files_images['tmp_name']);

		/*Tipo de Archivo*/
		for ($i=0; $i < $this->count_imgs; $i++) {
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$fileContents = file_get_contents($_FILES[$name]["tmp_name"][$i]);
			$mimetype = $finfo->buffer($fileContents);

			if ($mimetype != 'image/jpeg' AND $mimetype != 'image/png') {
				return false;
			}
		}		
		return true;
	}

	// Creador de folders
	public function folders($array=[])
	{	
		if (count($array) > 0) {
			foreach ($array as $folder) {
				$this->files($folder);
			}
		}
	}

	// Capturar extension del archivo
	public function segment($file,$position)
	{	
		$original_name = $file['name'][$position];
		$extension = explode(".", $original_name);
		$image_data = (object) [
			'file' => $file['tmp_name'][$position],
			'extension' => end($extension),
		];
		return $image_data;
	}

	// Comprimir imagen
	public function compress($file,$route)
	{
		try {
		    $source = \Tinify\fromFile($file);
			$copyrighted = $source->preserve("copyright", "location");
		} catch(\Tinify\ConnectionException $e) {
		    $source = \Tinify\fromFile($file);
			$copyrighted = $source->preserve("copyright", "location");
		}
		return $copyrighted->toFile($route);
	}

	// Modificar tamaño de imagen
	public function resize($size,$file,$route)
	{	
		$array = '_'.$size.'_resize';
		try {			
			$source = \Tinify\fromFile($file);
			$resized = $source->resize($this->$array);
		} catch(\Tinify\ConnectionException $e) {
			$source = \Tinify\fromFile($file);
			$resized = $source->resize($this->$array);
		}
		$resized->toFile($route);
	}

	// Contar imagenes comprimidas
	public function countCompressions()
	{	
		return \Tinify\compressionCount();
	}

	// Validar si 
	private function validate()
	{
		try {
		    \Tinify\setKey($this->_api_key_tinify);
		    \Tinify\validate();
		} catch(\Tinify\Exception $e) {
		    echo "Falló";
		}
		return true;
	}

	// Crear directorios
	private function files($folder)
	{	
		$new_folder = DIRECTORIO_ROOT.$folder;
		if (!file_exists($new_folder)) {
		    mkdir($new_folder, 0777, true);
		}
	}
}