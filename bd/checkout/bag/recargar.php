<?php 
	require "../../../config/config.php";

	/*BASKET*/
	$carrito = new Checkout;
	$bolsa = $carrito->productosBolsa;
	$countCart = count($bolsa);
	$bolsa  = Secure::decodeArray($bolsa);
	$bolsaAgotados = Secure::decodeArray($carrito->productosBolsaAgotados);
	/*#BASKET*/
?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title text-center text-uppercase" id="myModalLabel">Carrito de Compras</h4>
	</div>
	<div class="modal-body">
	<?php if ($countCart > 0): ?>
		<?php $sub_total = 0; ?>
		<?php foreach ($bolsa as $p): ?>
		<?php $sub_total = $sub_total + $p->precio_total; ?>
		<div class="row">
			<div class="col-xs-7">
				<div class="media">
				  	<div class="media-left">
				    	<a href="#">
				      		<img class="media-object thumbnail-cart" src="<?php echo URL_BASE.'img_productos/'.$p->serie.'/thumbnail/'.$p->ruta_img_tn; ?>" alt="<?php echo $p->nombre_producto; ?>">
				    	</a>
				  	</div>
				  	<div class="media-body">
				    	<h4 class="media-heading text-uppercase"><?php echo $p->nombre_producto; ?></h4>
				    
				  	</div>
				</div>
			</div>
			<div class="col-xs-5 text-right">
				<?php 
					if ($p->descuentoPorProducto > 0) {
						echo '$ '.number_format($p->precio_total);
						echo "</br>";
						echo '<strike style="color: red;">$ '.number_format($p->precioAntesDescuentoTotal);
						echo "</strike>";
					}else{
						echo number_format($p->precio_total);
					}
				?>
			</div>			
		</div>
		<hr>
		<?php endforeach ?>

		<div class="row">
			<div class="col-xs-12">
				<p class="text-right">
					<b>
						Sub-total: $<?php echo number_format($sub_total); ?>
					</b>
				</p>
			</div>
		</div>
	<?php else: ?>
			<div class="jumbotron text-center" style="background-color: transparent; color: #b5bbb5;">
			  	<h3>Tu carro aun está Vacio</h3>
			  	<br>
			  	<p><i class="fa fa-shopping-cart fa-3x" aria-hidden="true"></i></p>
			  	<br>
			  	<p class="text-center">
		  			<a class="btn btn-success btn-lg" style="background-color: #84C639; border-radius: 0;" href="#" role="button">BUSCAR ALGO</a>
		  		</p>
			</div>
	<?php endif ?>
		</div>
	<?php if ($countCart > 0): ?>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ver mas productos</button>
			<a style="background-color: #8BC34A;" href="<?php echo URL_BASE.'page/caja/' ?>" type="button" class="btn btn-primary">Comprar Ahora</a>
		</div>
	<?php endif ?>

