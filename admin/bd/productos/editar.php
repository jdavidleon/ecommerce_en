<?php 
	require "../../../config/config.php";
	// require DIRECTORIO_ROOT."config/autoload.php"; 

	$data = Secure::recibirRequest();
	
	if (!$data) {
		Secure::errorRequest();
		return false;
	}
	
	$rows = '*, productos.id_producto, productos.id_categoria, productos.id_sub_categoria, productos.descripcion';
	$datos = Products::cargarProductos($rows,'productos.id_producto = ?',['i',$data['id_producto']]);

	$productoCheck = Secure::decodeArray($datos[0]);
?>
	
	<form role="form" method="post" action="<?php echo URL_BASE.'admin/bd/productos/save/editar.php'; ?>" enctype="multipart/form-data">

		<input type="hidden" name="id_producto" value="<?php echo $productoCheck->id_producto; ?>">
		<?php include DIRECTORIO_ROOT.'admin/inc/form/producto.php'; ?>
		<br>
		<button type="submit" class="btn btn-sm btn-success pull-right" style="margin: 0 10px;">Guardar</button>
		<button type="button" class="btn btn-sm pull-right" data-dismiss="modal">Cerrar</button>
	</form>
