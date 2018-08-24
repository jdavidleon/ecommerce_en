<?php 

	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();

	if (!$data) {
		return false;
	}

	$buscar =  CRUD::all('productos_items','item_en','item_es = ?',['s',$data['item_es']]);

?>	
	<?php if ( count($buscar) === 1 ): ?>
		<option value="<?php echo $buscar[0]['item_en']; ?>">
	<?php elseif ( count($buscar) > 1 ): ?>		
		<?php foreach ($buscar as $key): ?>
			<option value="<?php echo $key['item_en']; ?>">
		<?php endforeach ?>
	<?php endif ?>

