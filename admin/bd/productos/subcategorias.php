
<?php 	
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php";

	$data = Secure::recibirRequest('POST');

	if ($data == false) {
		echo '<option disabled selected>Subcategoria</option>';
		return false;
	}

	$consulta_subcategoria = CRUD::all('categorias_sub','*','id_categoria = ?',['i',$data['id_categoria']]);
	if (count($consulta_subcategoria) <= 0) { ?>
		<option value="0" selected>No existe subcategoria</option>		
	<?php 
		return false;	
		}
	?>

	<?php foreach ($consulta_subcategoria as $subcat): ?>
		<option class='text-uppercase' value='<?php echo $subcat['id_sub_categoria']; ?>'>
			<?php echo strtoupper($subcat['nombre_sub_categoria_es']); ?>
		</option>
	<?php endforeach ?>