<?php 
	require "../../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();

	if (!$data) {
		Secure::errorRequest();
		return false;
	}
	
	$where = 'id_prod_item = ?';
	$params = ['i',$data['id_prod_item']];
	$delete = CRUD::falseDelete('productos_con_items',$where,$params);

	$cathProduct = CRUD::all('productos_con_items','*',$where,$params);
	$productoID = $cathProduct[0]['id_producto'];

	if ($delete[0]->affected_rows === 1) {
		$result = 'warning';
		$msn = 'Contenido eliminado';
		response($result,$msn);
	}else{
		$result = 'danger';
		$msn = 'No se ha completado. Vuelve a intentarlo';
		response($result,$msn);
	}
	
	function response($result,$msn)
	{	
		$items = Products::itemsProducts($GLOBALS['productoID']);
?>
	<h4 class="text-center text-capitalized">Contenido de la Cesta</h4>
	<p class="text-center text-<?php echo $result; ?>"><?php echo $msn ?></p>
	<ul style="padding-right: 40px;">

		<?php foreach ($items as $item): ?>
			<li>
				<?php echo $item['item_es']; ?> - <?php echo $item['item_en']; ?>
				<span class="pull-right text-right">
						<button style="cursor: pointer; border: none; background: transparent;" class="text-danger form-inline" onclick="eliminarItems(<?php echo $item['id_prod_item']; ?>)">
							<i class="fa fa-trash-o pull-right" aria-hidden="true"></i>
						</button>
				</span>
			</li>		
		<?php endforeach ?>

	</ul>

<?php } ?>