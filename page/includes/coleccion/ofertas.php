<?php 
	$productos = Products::cargarProductos();

	$oferts = [];

	foreach ($productos as $pd) {
		if ($pd['porcentajeDescuento'] > 0) {
				$oferts[] = $pd;
		}	
	}

	// var_dump($oferts);
?>

<div class="w3l_banner_nav_right">

<div class="w3ls_w3l_banner_nav_right_grid" style="margin-top: 50px;">
	<h3><?php echo 'Ofertas'; ?></h3>
	<div class="w3ls_w3l_banner_nav_right_grid1">

		
		<?php imprimirProducto($oferts); ?>

		<div class="clearfix"> </div>
	</div>
</div>
</div>
<div class="clearfix"></div>
	</div>