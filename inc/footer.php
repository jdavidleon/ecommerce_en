<!-- newsletter -->
	<div class="newsletter">
		<div class="container">
			<div class="row">
				<div class="col-sm-8" style="padding: 10px;">
					<h3 class="text-center text-uppercase">
						<small style="color: white">
							Únete a nuestra comunidad y enterate de promociones y nuevos productos
						</small>
					</h3>
				</div>
				<div class="col-sm-4">
					<a class="btn btn-newsletter btn-lg" data-toggle="modal" data-target="#newsletterModal">
						<b>
							Subscribirme
						</b>
					</a>
				</div>
			</div>
		</div>
	</div>
<!-- //newsletter -->


<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="col-md-3 w3_footer_grid">
				<h3>información</h3>
				<ul class="w3_footer_grid_list">
					<li><a href="<?php echo URL_BASE.'page/coleccion/ofertas' ?>">Ofertas</a><i>/</i></li>
					<li><a href="<?php echo URL_BASE.'page/empresa/eventos/' ?>">Eventos</a><i>/</i></li>
					<li><a href="<?php echo URL_BASE.'page/empresa/conocenos/' ?>">Conócenos</a><i>/</i></li>
					<li><a href="<?php echo URL_BASE.'page/contactanos/' ?>">Contáctanos</a></li>
				</ul>
			</div>
			<div class="col-md-3 w3_footer_grid">
				<h3>Politicas</h3>
				<ul class="w3_footer_grid_list">
					<li>
						<a href="<?php echo URL_BASE; ?>page/politicas/preguntas-frecuentes">
						Preguntas Frecuentes
						</a>
					</li>
					<li>
						<a href="<?php echo URL_BASE; ?>page/politicas/terminos-y-condidiones">
							Terminos de Uso
						</a>
					</li>
					<li>
						<a href="<?php echo URL_BASE; ?>page/politicas/politica-de-cookies">
							Políticas de Cookies
						</a>
					</li>
				</ul>
			</div>
			<div class="col-md-3 w3_footer_grid">
				<h3>Categorias</h3>
				<ul class="w3_footer_grid_list">

					<?php foreach ($categorias as $cat): ?>
						<?php 
							$url_line = str_replace(' ', '-', $cat['categoria']); 
							$url_cat = str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $url_line);
						?>
						<li>
							<a href="<?php echo URL_BASE.'page/coleccion/'.$cat['id_categoria'].'/'.$url_cat; ?>">
								<?php echo ucfirst($cat['categoria']); ?>
							</a>
						</li>					
					<?php endforeach ?>
				</ul>
			</div>
			<div class="col-md-3 w3_footer_grid">
				<h3>CHATEA CON NOSOTROS</h3>
				<ul class="w3_footer_grid_list1">
					<li>						
						<a href="https://api.whatsapp.com/send?l=es&phone=57<?php echo $whatsapp; ?>&text=<?php echo $wappTxt; ?>" class="link-underline"> 
							<i class="fa fa-whatsapp fa-2x" aria-hidden="true">
								<small> <?php echo $whatsapp; ?></small>
							</i> 
							<p>
								Toca aquí para abrir el chat directo en whatsapp.
							</p>
						</a>
					</li>
					<li>					
						<a href="https://m.me/ennavidad.col" target="_blank" class="link-underline"> 
							<i class="fa fa-2x fa-commenting-o" aria-hidden="true">
								<small> Facebook Chat</small>
							</i> 
							<p>
								Toca aquí si deseas abrir el chat via messenger de Facebook.
							</p>
						</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"> </div>
			<div class="agile_footer_grids">
				<div class="col-md-3 w3_footer_grid agile_footer_grids_w3_footer">
					<div class="w3_footer_grid_bottom">
						<h4>
							<i class="fa fa-lock" aria-hidden="true"></i> 
							PAGO 100% SEGURO 
						</h4>
						<a href="http://www.payulatam.com/logos/pol.php?l=133&c=59cc6c0d2f078" target="_blank">
							<img class="img-payu-footer" src="<?php echo URL_PAGE ?>images/logo_payments.png" alt="PayU Latam" border="0" /></a>
					</div>
				</div>
				<!-- <div class="col-md-3 w3_footer_grid agile_footer_grids_w3_footer">
					<div class="w3_footer_grid_bottom">
						<h5>connect with us</h5>
						<ul class="agileits_social_icons">
							<li><a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="#" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							<li><a href="#" class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							<li><a href="#" class="dribbble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div> -->
				<div class="clearfix"> </div>
			</div>
			<div class="wthree_footer_copy">
				<p>© <?php echo date('Y'); ?> En Navidad. Diseño y Mano de obra Colombiana | Sitio Web Desarrollado por <a href=""> dldeveloper.com</a></p>
			</div>
		</div>
	</div>
<!-- //footer -->

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo ASSETS ?>js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});
</script>
<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			// $().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>
<!-- //here ends scrolling icon -->
<script src="<?php echo ASSETS ?>js/minicart-min.js"></script>
<script>
		paypal.minicart.render();

		paypal.minicart.cart.on('checkout', function (evt) {
			var items = this.items(),
				len = items.length,
				total = 0,
				i;

			// Count the number of each item in the cart
			for (i = 0; i < len; i++) {
				total += items[i].get('quantity');
			}

			if (total < 3) {
				alert('The minimum order quantity is 3. Please add more to your shopping cart before checking out');
				evt.preventDefault();
			}
		});

	</script>

	<script type="text/javascript">
		$(document).ready(function () {
			$('.dropdown-toggle').dropdown();
		});
		
		function addCart(productoID) {
			$.post(base+'bd/checkout/bag/agregar.php',
				{
					id_producto: productoID,
					cantidad_bolsa: 1,
					empt_val: ''
				},
				function () {
					$('#modal_carrito').load(base+'bd/checkout/bag/recargar.php');
					$('.badge-bag').load(base+'bd/checkout/bag/cantidadBolsa.php');
				}
			);
		}

		function sumCart(bolsaID,productoID) {
			if (bolsaID === null) {
				bolsaID = 'null';
			}
			var valor = $('.cantidadBolsa'+productoID).val();
	        $datos  = {
	            'id_bolsa_compras': bolsaID,
	            'id_producto': productoID,
	            'empt_val': ''
	        }
			$.ajax({
				type: 'POST',
				data: $datos,
				url: base+'bd/checkout/bag/aumentar.php',
				success: function (data) {	
					$('.cantidad_bolsa'+productoID).html(data);
					$('.btn-update-cart').slideDown();
				}
			})
	    }

		function restCart(bolsaID,productoID) {		
			if (bolsaID === null) {
				bolsaID = 'null';
			}
			var valor = $('.cantidadBolsa'+productoID).val();
	        $datos  = {
	            'id_bolsa_compras': bolsaID,
	            'id_producto': productoID,
	            'empt_val': ''
	        }
			$.ajax({
				type: 'POST',
				data: $datos,
				url: base+'bd/checkout/bag/restar.php',
				success: function (data) {
					$('.cantidad_bolsa'+productoID).html(data);
					$('.btn-update-cart').slideDown();
				}
			})
	    }

	   

	    function findCity() {
	    	departamento = $(':input[name=id_departamento]').val();
	    	$(':input[name=id_ciudad]').load(base+'bd/users/address/buscar_ciudad.php?id_departamento='+departamento+'&empt_val=');
	    }

	</script>

	<?php if ($modal_coupon_fist_shop): ?>
		<script type="text/javascript">
			$('#newsletterModal').modal('show');
		</script>
	<?php endif ?>
</body>
</html>
