
<table class="timetable_sub">

	<?php if ($countCart > 0): ?>
		<thead>
			<tr>
				<th class="hidden-xs">No.</th>	
				<th>Producto</th>
				<th>Cantidad</th>
				<th class="hidden-xs">Nombre Producto</th>						
				<th>Precio</th>
				<th>Quitar</th>
			</tr>
		</thead>
	<?php endif ?>


	<tbody>
		<?php if ($countCart < 1): ?>
			<tr>
			<div class="jumbotron text-center" style="background-color: transparent; color: #b5bbb5;">
			  	<p>Tu carro está Vacio</p>
			  	<br>
			  	<p><i class="fa fa-shopping-cart fa-3x" aria-hidden="true"></i></p>
			  	<br>
			  	<p class="text-center">
		  			<a class="btn btn-success btn-lg" style="background-color: #84C639; border-radius: 0;" href="#" role="button">BUSCAR ALGO</a>
		  		</p>
		  		<br>
		  		<img style="max-width: 100%;" src="http://www.payulatam.com/logos/logo.php?l=133&c=59ceac11ab62d" alt="PayU Latam" border="0" />
			</div>
			</tr>
		<?php endif ?>

		<?php $rem = 1; ?>
		<?php foreach ($bolsa as $p): ?>
			<?php 
				$url_line = str_replace(' ', '-', $p->categoria); 
				$url_cat = str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $url_line);
				$url_p = strtolower(str_replace(' ','-',$p->nombre_producto));
			?>
			<tr class="rem<?php echo $rem; $rem++; ?>">
				<td class="invert hidden-xs">1</td>
				<td class="invert-image">
					<a href="<?php echo URL_BASE.'page/coleccion/'.$p->id_categoria.'/'.$url_cat.'/'.$p->id_producto.'/'.$url_p; ?>">
						<img class="media-object" src="<?php echo URL_BASE.'img_productos/'.$p->serie.'/thumbnail/'.$p->ruta_img_tn; ?>" alt="<?php echo $p->nombre_producto; ?>">
					</a>
				</td>
				<td class="invert">
					 <div class="quantity"> 
						<div class="quantity-select">                           
							<div class="entry value-minus" onclick="restCart(<?php echo $p->id_bolsa_compras; ?>,<?php echo $p->id_producto; ?>)">&nbsp;</div>
							<div class="entry value">
								<span class="cantidad_bolsa<?php echo $p->id_producto; ?>">
									<?php echo $p->cantidad_bolsa; ?>
								</span>
							</div>
							<div class="entry value-plus active" onclick="sumCart(<?php echo $p->id_bolsa_compras ?>,<?php echo $p->id_producto; ?>)">&nbsp;</div>
						</div>
					</div>
				</td>
				<td class="invert hidden-xs"><?php echo $p->nombre_producto; ?></td>
				
				<td class="invert">
					$ 
					<?php 

						if ($p->descuentoPorProducto > 0) {
							echo number_format($p->precio_total);
							echo "</br>";
							echo '<strike>$ '.number_format($p->precioAntesDescuentoTotal);
							echo "</strike>";
						}else{
							echo number_format($p->precio_total);
						}

					?>
				</td>
				<td class="invert">
					<div class="rem">
						<form action="<?php echo URL_BASE.'bd/checkout/bag/eliminar.php'; ?>" method="post">
							<input type="hidden" name="empt_val">
							<input type="hidden" name="id_producto" value="<?php echo $p->id_producto; ?>">
							<input type="hidden" name="id_bolsa_compras" value="<?php echo $p->id_bolsa_compras; ?>">
							<button style="background-color: transparent; border: none;" type="submit">
								<div class="close1"> </div>
							</button>
						</form>
					</div>

				</td>
			</tr>							
		<?php endforeach ?>
	</tbody>
</table>


<br>


<div class="row btn-update-cart" style="display: none;">
	<div class="col-lg-12 text-right">
		<a href="<?php echo URL_BASE.'page/caja/'; ?>" class="btn submit check_out pull-right">
			Actualizar Carrito
		</a>
	</div>
</div>
