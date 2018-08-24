<?php 

	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();

	if (!$data) {
		return false;
	}

	$buscar =  CRUD::all('productos_items','*','item_es LIKE ?',['s','%'.$data['item_es'].'%'],null,'RAND(), item_es',10);

?>
	<?php foreach ($buscar as $key): ?>
		<option value="<?php echo $key['item_es']; ?>">
	<?php endforeach ?>

