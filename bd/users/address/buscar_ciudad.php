<?php 


	require "../../../config/config.php";
		
	$data = Secure::peticionRequest('GET');


	$ciudades = CRUD::all('ciudades','*','id_departamento = ?',['i',$data['id_departamento']]);

?>


		<option></option>
	<?php foreach ($ciudades as $c): ?>
		<option value="<?php echo $c['id_ciudad'] ?>">
			<?php echo $c['nombre_ciudad']; ?>
		</option>
	<?php endforeach ?>