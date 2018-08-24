<?php 
	// var_dump($bolsa);
	$carrito->resumenCarrito();
	// Calculo precios carrito Compras
		// echo 'total_pagar: '.$carrito->_totalPagar;
		// echo "</br>";
	 //    echo '_totalDescuento: '.$carrito->_totalDescuento;
	 //    echo "</br>";
	 //    echo '_totalAntesDeDescuento: '.$carrito->_totalAntesDeDescuento;
	 //    echo "</br>";
	 //    echo 'precioFinal: '.$carrito->precioFinal;
	 //    echo "</br>";
	 //    echo 'costoEnvio: '.$carrito->costoEnvio;
	 //    echo "</br>";
	 //    echo 'cupon: '.$carrito->cupon;
	 //    echo "</br>";

	    // Resume
	    // echo 'totalDescuento: '.$carrito->totalDescuento;
	    // echo "</br>";
	    // echo 'totalAntesDeDescuento: '.$carrito->totalAntesDeDescuento;
	    // echo "</br>";
	    // echo 'totalProductos: '.$carrito->totalProductos;
	    // echo "</br>";
	// var_dump($bolsaAgotados);
 ?>


<div class="w3l_banner_nav_right">
<!-- about -->
	<div class="privacy about">
		<h3>Pasarela de Pagos</h3>
		
      	<div class="checkout-right">
  			<?php if ($countCart > 0): ?>	      				
				<h4>
					Tu carrito contiene: 
					<span>
						<?php 
							echo $countCart; 
							echo $countCart === 1 ? ' producto' : ' productos' ;
						?>
					</span>
				</h4>
  			<?php endif ?>


			<?php require DIRECTORIO_ROOT.'page/includes/checkout/includes/handled_errors.php'; ?>


			<?php require DIRECTORIO_ROOT.'page/includes/checkout/includes/products_table.php'; ?>

		</div>
			

		<?php require DIRECTORIO_ROOT.'page/includes/checkout/includes/resume_cart.php'; ?>


	</div>
<!-- //about -->
		</div>
		<div class="clearfix"></div>