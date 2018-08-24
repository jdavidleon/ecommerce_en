
<?php if ($countCart > 0): ?>
<div class="checkout-left">	
	<div class="col-md-4 checkout-left-basket">
		<h4>resumen de carrito</h4>
		<ul style="padding: 5px">
			<li>Productos 
				<span>$ <?php echo number_format($carrito->totalAntesDeDescuento); ?> </span>
			</li>
			<li>Envío 
				<span>$ <?php echo number_format($carrito->costoEnvio); ?> </span>
			</li>
			<li>Descuento  
				<span>-$ <?php echo number_format($carrito->totalDescuento); ?> </span>
			</li>
			<li>Cupón 
				<span>-$ <?php echo number_format($carrito->cupon); ?></span>
			</li>
			<li>Total 
				<span>$ <?php echo number_format($carrito->precioFinal); ?></span>
			</li>
		</ul>


		<?php if ($carrito->cupon > 0): ?>
			<div class="alert alert-success alert-dismissible text-center" role="alert">
			  	CUPÓN <strong><?php echo $carrito->cupon_descuento ?></strong> APLICADO
			</div>
		<?php endif ?>
		<h5 class="text-center" style="margin-bottom: 20px;">¿Tienes un cupón?</h5>

		<!-- CUPON -->
		<form action="<?php echo URL_BASE.'bd/order/coupon/new.php' ?>" method="POST">
			<div class="input-group">
				<input type="hidden" name="empt_val">
		      <input type="text" class="form-control" name="clave_cupon" placeholder="Agregar cupón" style="border-radius: 0;" required>
		      <span class="input-group-btn">
		        <button class="btn btn-default" type="submit" style="border-radius: 0; background-color: #84c639; color: white;">
		        	<i class="fa fa-gift" aria-hidden="true"> Agregar</i>
		        </button>
		      </span>
		    </div><!-- /input-group -->
		</form>
		<!-- CUPON -->

	</div>


	<?php require DIRECTORIO_ROOT.'page/includes/checkout/includes/address.php'; ?>


<?php endif ?>

	<div class="clearfix"> </div>
	
</div>
