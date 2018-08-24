<?php 

	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();

	if (!$data) {
		return false;
	}

	$where = 'item_en LIKE ? AND item_es = ?';
	$params = ['ss','%'.$data['item_en'].'%',$data['item_es']];
	$buscar =  CRUD::all('productos_items','*',$where,$params,null,'RAND(), item_en',10);

?>
	<?php foreach ($buscar as $key): ?>
		<option value="<?php echo $key['item_en']; ?>">
	<?php endforeach ?>

