<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();

	if (!$data) {
		return false;
	}

	$join = [
		['INNER','productos_items_tipos','productos_items_tipos.id_tipo_item = productos_items.id_tipo_item'],
	];
	$todos = CRUD::all('productos_items','*',null,[],$join);
	$items = Products::itemsProducts($data['id_producto']);
	$itemProducto = [];
	$itemNoAsignado = [];
	foreach ($todos as $item) {
		$asignados = array_search($item['id_item'], array_column($items, 'id_item'));
		if ( $asignados !== false ) {
			$itemProducto[] = $item;
		}else{
			$itemNoAsignado[] = $item;
		}
	}
?>
	<h4 class="text-center text-capitalized">Contenido de la cesta</h4>

	
	
	<form method="POST" id="form_asign_item" action="<?php echo ADMIN.'bd/productos/items/newToProduct.php'; ?>" id-producto="<?php echo $data['id_producto']; ?>">
		<input type="hidden" name="id_producto" value="<?php echo $data['id_producto']; ?>">
		<ul style="padding: 0px;">
		<?php foreach ($itemProducto as $item): ?>
			<li style="border: 1px solid grey; padding: 6px; padding-right: 18px; margin-top: 2px;">
				<label style="color: black; width: 100%; margin: 0; cursor: pointer;">
					<?php echo $item['item_es']; ?> - <?php echo $item['item_en']; ?>
					<input type="checkbox" class="pull-right" name="id_item[]" value="<?php echo $item['id_item']; ?>" checked>
				</span>
			</li>
		<?php endforeach ?>

		<?php foreach ($itemNoAsignado as $item): ?>
			<li style="border: 1px solid grey; padding: 6px; padding-right: 18px; margin-top: 2px;">
				<label style="color: grey; width: 100%; margin: 0; cursor: pointer;">
					<?php echo $item['item_es']; ?> - <?php echo $item['item_en']; ?>
					<input type="checkbox" class="pull-right" name="id_item[]" value="<?php echo $item['id_item']; ?>">
				</span>
			</label>
		<?php endforeach ?>
		</ul>

		<?php if (isset($data['actualizado']) AND $data['actualizado'] == 'true' ): ?>
			<div class="label-success text-center" id="labelSuccessIteUpdate" style="padding: 6px;">
				<p class="text-uppercase" style="color: white; margin: 0;">
					Lista actualizada correctamente
				</p>
			</div>
		<?php endif ?>
		<br>
		<input class="btn btn-success" type="submit" value="Guardar Cambios">
	</form>


