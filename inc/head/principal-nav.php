<?php 
	
	/*USER TYPE*/
	$admin = false;
	if ($session) {
		$user = CRUD::all('usuarios','id_rol','id_usuario = ?',['i',$_SESSION['id_usuario']]);
		if ($user[0]['id_rol'] === 1) {
			$admin = true;
		}
	}
	/*USER TYPE*/

	/*BASKET*/
	$carrito = new Checkout;
	$bolsa = $carrito->productosBolsa;
	$countCart = count($bolsa);
	$bolsa  = Secure::decodeArray($bolsa);
	$bolsaAgotados = Secure::decodeArray($carrito->productosBolsaAgotados);
	/*#BASKET*/

?>

<div class="logo_products">
		<div class="container">
			<div class="w3ls_logo_products_left">
				<h1><a href="<?php echo URL_BASE; ?>"><span>En</span> Navidad</a></h1>
			</div>
			<div class="w3ls_logo_products_left1 hidden-sm hidden-xs">
				<ul class="special_items">
					<li><a href="<?php echo URL_BASE.'page/coleccion/ofertas' ?>">Ofertas</a><i>/</i></li>
					<li><a href="<?php echo URL_BASE.'page/empresa/eventos/' ?>">Eventos</a><i>/</i></li>
					<li><a href="<?php echo URL_BASE.'page/empresa/conocenos/' ?>">Conócenos</a><i>/</i></li>
					<li><a href="<?php echo URL_BASE.'page/contactanos/' ?>">Contáctanos</a></li>
				</ul>
			</div>
		<!-- script-for sticky-nav -->
			<script>
			// $(document).ready(function() {
			// 	 var navoffeset=$(".agileits_header").offset().top;
			// 	 $(window).scroll(function(){
			// 		var scrollpos=$(window).scrollTop(); 
			// 		if(scrollpos >=navoffeset){
			// 			$(".agileits_header").addClass("fixed");
			// 		}else{
			// 			$(".agileits_header").removeClass("fixed");
			// 		}
			// 	 });
				 
			// });
			</script>
		<!-- //script-for sticky-nav -->

			<div class="w3ls_logo_products_left1 pull-right">
				<ul class="phone_email pull-right">
					<!-- User Menu -->
					<li class="dropdown profile_details_drop">
						<a href="#" id="userMenu" class="dropdown-toggle padding-dropdwon-cart" data-toggle="dropdown" ria-haspopup="true" aria-expanded="false">
								<b><?php if ($session): ?>
										<?php $name = explode(' ', $_SESSION['user']); ?>
										<?php echo $name[0] ?>
									<?php else: ?>
										Ingresar
									<?php endif ?>
								</b>
							<i class="fa fa-user fa-2x" style="font-size: 23px;" aria-hidden="true"> 
							<i class="fa fa-caret-down" aria-hidden="true"></i></i>
						</a>
							<ul class="dropdown-menu drp-mnu" aria-labelledby="userMenu">
							<?php if (!$session): ?>
								<li class="text-center" style="width: 100%; padding-right: 0;">
									<a href="<?php echo URL_BASE.'page/usuarios/iniciar-sesion/' ?>">Iniciar Sesión</a>
								</li> 
								<li class="text-center" style="width: 100%;">
									<a href="<?php echo URL_BASE.'page/usuarios/registrarse/' ?>">Registrarme</a>
								</li>
							<?php else: ?>
								<?php if ($admin): ?>									
									<li class="text-center" style="width: 100%; padding-right: 0;">
										<a href="<?php echo URL_BASE.'admin' ?>">
											Administrar
										</a>
									</li> 
								<?php endif ?>
								<li class="text-center" style="width: 100%; padding-right: 0;">
									<a href="<?php echo URL_BASE.'page/usuarios/informacion-personal/' ?>">
										Cuenta
									</a>
								</li> 
								<li class="text-center" style="width: 100%;">
									<a href="<?php echo URL_BASE.'page/usuarios/compras/' ?>">
										Compras
									</a>
								</li> 
								<!-- <li class="text-center" style="width: 100%;">
									<a href="<?php echo URL_BASE.'page/usuarios/direcciones/' ?>">
										Direcciones
									</a>
								</li>  -->
								<li class="text-center" style="width: 100%;">
									<a href="<?php echo URL_BASE.'bd/users/logout.php?csrf='.$_SESSION['csrf_token'] ?>">
										Cerrar Sesión
									</a>
								</li> 
							<?php endif ?>
							</ul>
					</li>
					<!-- User Menu -->

					<li>
						<a href="" data-toggle="modal" data-target="#cartModal">
							<i class="fa fa-2x fa-shopping-cart" style="font-size: 24px;" aria-hidden="true"> 
								<span style="margin-left: 7px; font-size: 14px;" class="badge badge-success badge-bag">
									<?php echo $countCart; ?>
								</span>
							</i>
						</a>
					</li>
				</ul>
			</div>



			
			<!-- Modal Cart -->
			<div class="modal fade bs-example-modal-sm" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  	<div class="modal-dialog modal-sm" role="document">
				    <div class="modal-content" id="modal_carrito">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title text-center text-uppercase" id="cartLabel">
								Carrito de Compras
							</h4>
						</div>

						<div class="modal-body">
							<?php if ($countCart > 0): ?>
									<?php $sub_total = 0; ?>
								<?php foreach ($bolsa as $p): ?>
									<?php $sub_total = $sub_total + $p->precio_total; ?>
								<div class="row">
									<div class="col-xs-9">
										<div class="media">
										  	<div class="media-left">
										    	<a href="#">
										      		<img class="media-object thumbnail-cart" src="<?php echo URL_BASE.'img_productos/'.$p->serie.'/thumbnail/'.$p->ruta_img_tn; ?>" alt="<?php echo $p->nombre_producto; ?>">
										    	</a>
										  	</div>
										  	<div class="media-body">
										    	<h5 class="media-heading text-uppercase">
										    		<?php echo $p->nombre_producto; ?>
													<br>
											    	<small>
											    		Cantidad: <?php echo $p->cantidad_bolsa; ?>
											    	</small>
												</h5>
										  	</div>
										</div>
									</div>
									<div class="col-xs-3 text-right" style="padding-left: 0; color: #84C639;">
										<?php 
											if ($p->descuentoPorProducto > 0) {
												echo '<b>$'.number_format($p->precio_total, 0, ',', '.');
												echo "</b></br>";
												echo '<strike style="color: #E32D2D;"><small>$'.number_format($p->precioAntesDescuentoTotal, 0, ',', '.');
												echo "</small></strike>";
											}else{
												echo "<b>$";
												echo number_format($p->precio_total, 0, ',', '.');
												echo "</b>";
											}
										?>
									</div>			
								</div>
								<hr>
								<?php endforeach ?>

								<div class="row">
									<div class="col-xs-12">
										<h4 class="text-right">
											<b>
												Subtotal: $<?php echo number_format($sub_total, 0, ',', '.'); ?>
											</b>
										</h4>
									</div>
								</div>
							<?php else: ?>
								<div class="jumbotron text-center" style="background-color: transparent; color: #b5bbb5;">
								  	<h4 class="text-uppercase">Tu carro aun está Vacio</h4>
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
								<a type="button" class="pull-left" data-dismiss="modal">
									<small>
										<b>Ver más productos</b>
									</small>
								</a>
								<a style="background-color: #8BC34A;" href="<?php echo URL_BASE.'page/caja/' ?>" type="button" class="btn btn-primary text-uppercase">
									<b>Ir a la Caja</b>
								</a>
							</div>
						<?php endif ?>
				    </div>
				</div>
			</div>
			<!-- #Modal Cart -->

			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //header -->