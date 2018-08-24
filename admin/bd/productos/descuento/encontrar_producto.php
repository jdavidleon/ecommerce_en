<?php 
	require "../../../../config/config.php";

	$data = Secure::recibirRequest();
	
	if (!$data) {
		echo "string";
		Secure::errorRequest();
		return false;
	}

	$producto = Products::find($data['id_producto']);

	if ($producto->descuentoPorProducto > 0) {
		$where = 'id_producto = ? AND tm_delete IS NULL';
		$params = ['i',$data['id_producto']];
		$descuento = CRUD::all('productos_descuento','fecha_inicial, fecha_limite',$where,$params);
		$fecha_inicial = $descuento[0]['fecha_inicial'];
		$fecha_limite = $descuento[0]['fecha_limite'];
		echo "Precio normal: ".$producto->precioAntesDescuento;
		echo "</br>";
		echo "Precio con Descuento: ".$producto->precio;
		echo "</br>";
		echo "El producto ya tiene un descuento de: ".$producto->descuentoPorProducto."(".$producto->porcentajeDescuento." %)"; 
		echo "</br>";
		echo "Del ".$fecha_inicial.' al '.$fecha_limite;	
	} else { ?>
		<?php echo 'Precio: '.$producto->precio; 
	} ?>



	<script type="text/javascript">
		var precio = <?php echo $producto->precioAntesDescuento; ?>
	</script>
	