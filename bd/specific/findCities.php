<?php 
 	require "../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::peticionRequest();

	if (!$data) {
		echo "Ha ocurrido un error";
		return false;
	}

	$cities = User::ciudades(null,'id_estado = ?','*',['i',$data['id_estado_eu']]);
?>

	<option selected disabled>Ciudad</option>

	<?php foreach ($cities as $ID => $city): ?>
		<option value="<?php echo $ID; ?>"><?php echo $city; ?></option>
	<?php endforeach ?>