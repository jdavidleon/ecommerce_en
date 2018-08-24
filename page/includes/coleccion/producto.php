<?php 
	$producto = Products::find($_GET['id_producto']);
    $p_imgs = Products::imgProducts($producto->serie);
	// var_dump($p_imgs);


	if (count($producto) > 0) {
		$productos = Products::consultaPorCategorias($producto->id_categoria,null,8);
		$actualProduct = array_search($producto->id_producto, array_column($productos, 'id_producto'));
		if ($actualProduct !== false) {
			unset($productos[$actualProduct]);
		}
	}else{
		$productos = Products::cargarProductos();
	}
	if (count($productos) < 8) {
		$rows = '*, productos.id_producto, productos.id_categoria';
		$where = 'productos.id_categoria <> ? AND productos_publicados.estado_publicado = ? AND productos.tm_delete IS NULL AND (productos_agotados.estado_agotado = ? || productos_agotados.estado_agotado IS NULL)';
		$params = ['iss',$producto->id_categoria,'SI','NO'];
		$adicionales = Products::cargarProductos($rows,$where,$params,null,8-count($productos));
		$productos = array_merge($productos,$adicionales);
	}

	shuffle($productos);
	
	/*Votacion*/
		$votos = CRUD::all('productos_votacion','voto','id_producto = ?',['i',$_GET['id_producto']]);

		$suma = 0;
		foreach ($votos as $voto) {	
			$suma = $suma + $voto['voto'];
		}

		$checked = [];
		if (count($votos) > 0) {
			$promedio = round($suma / count($votos));
			if ($promedio > 0) {
				for ($i=1; $i <= 5; $i++) { 
					if ($promedio == $i) {
						$checked[$i] = 'checked';
					}else{
						$checked[$i] = ' ';
					}
				}
			}
		}else{
			for ($i=1; $i <= 5; $i++) { 
				$checked[$i] = '';
			}
		}
	/*#Votacion*/
?>

		<div class="w3l_banner_nav_right">
			<?php if (count($producto) === 1): ?>
				
			<div class="agileinfo_single">
				<h3 class="text-uppercase" style="color: #84C639;">
					<?php echo $producto->nombre_producto; ?>
				</h3>
				<br>
				<div class="col-md-4 agileinfo_single_left">
					<?php if ($producto->descuentoPorProducto > 0): ?>
						<div class="agile_top_brand_left_grid_pos" style="z-index: 9; top: -20px; left: -20px;">
							<img src="images/offer.png" alt=" " class="img-responsive" />
							<span style="font-weight: 900; position: absolute; top: 23px; left: 19px; color: white;  font-size: 20px;"><?php echo $producto->porcentajeDescuento; ?>%</span>
						</div>
					<?php endif ?>
					<img 
						id="zoom_05" 
						style="box-shadow:0px 0px 5px #E1E1E1;"
						src="<?php echo URL_BASE.'img_productos/'.$producto->serie.'/small/'.$producto->ruta_img_sm; ?>" 
						alt=" " 
						class="img-responsive" 
						data-zoom-image="<?php echo URL_PAGE.'img_productos/'.$producto->serie.'/large/'.$producto->ruta_img_lg; ?>"
					/>

					<div id="gallery_01" style="margin-top: 20px; padding-left: 0; float: left;"> 

					    <?php foreach ($p_imgs as $img): ?>
					       	<a 	
					       		class="col-xs-4"
					       		style="margin-bottom: 20px; padding: 3px;" 
					       		data-image="<?php echo URL_BASE.'img_productos/'.$producto->serie.'/small/'.$img->ruta_img_sm; ?>" data-zoom-image="<?php echo URL_PAGE.'/img_productos/'.$producto->serie.'/large/'.$img->ruta_img_lg; ?>"
					       	>
						        <img 
						        	style="width: 200px; border: 1px solid #E1E1E1; box-shadow: 1px 0px 4px 0px #E1E1E1;"
						        	id="zoom_05" 	        	
						        	class="img-responsive elevatezoom-gallery" 
						        	src="<?php echo URL_BASE.'img_productos/'.$producto->serie.'/thumbnail/'.$img->ruta_img_tn; ?>" 
						        />
					        </a>
					    <?php endforeach ?>
					    
					</div>
				</div>			
				<div class="col-md-8 agileinfo_single_right">			
					<?php 
						$url = 'https://www.ennavidad.com/page/coleccion/'.$_GET['id_categoria'].'/'.$_GET['categoria'].'/'.$_GET['id_producto'].'/'.$_GET['producto'].'/';
					?>
					<div 
						class="fb-save" 
						data-uri="<?php echo $url; ?>" 
						data-size="small"
					></div>
					<!-- Votación -->
						<div class="rating1 hide">
							<span class="starRating">
								<input id="rating5" type="radio" name="rating" value="5" <?php echo $checked[5]; ?>>
								<label for="rating5" class="votacion" vot-val="5" style="cursor: pointer;">5</label>
								<input id="rating4" type="radio" name="rating" value="4" <?php echo $checked[4]; ?>>
								<label for="rating4" class="votacion" vot-val="4" style="cursor: pointer;">4</label>
								<input id="rating3" type="radio" name="rating" value="3" <?php echo $checked[3]; ?>>
								<label for="rating3" class="votacion" vot-val="3" style="cursor: pointer;">3</label>
								<input id="rating2" type="radio" name="rating" value="2" <?php echo $checked[2]; ?>>
								<label for="rating2" class="votacion" vot-val="2" style="cursor: pointer;">2</label>
								<input id="rating1" type="radio" name="rating" value="1" <?php echo $checked[1]; ?>>
								<label for="rating1" class="votacion" vot-val="1" style="cursor: pointer;">1</label>
							</span>
							<small>
								(<?php 
									echo count($votos) ?> <?php echo count($votos) == 1 ? 'Voto' : 'Votos' ; 
								?>) 
							</small>
						</div>
						<?php if ($session): ?>
							
							<script type="text/javascript">
								$(document).ready(function(){$(".votacion").click(function(){var t=$(this).attr("vot-val");$datos={voto:t,id_producto:<?php echo $producto->id_producto; ?>,id_usuario:<?php echo $_SESSION['id_usuario']; ?>,empt_val:""},$.ajax({type:"POST",data:$datos,url:base+"bd/product/vote.php"})})});
							</script>

						<?php endif ?>
					<!-- Votación -->

					<div class="w3agile_description">
						<h4>Descripcion :</h4>
						<p>
							<?php echo $producto->descripcion; ?>
						</p>
					</div>
					<div class="snipcart-item block">
						<div class="snipcart-thumb agileinfo_single_right_snipcart">
							<h3 style="color: #84C639;">
								<?php if ($producto->descuentoPorProducto === 0): ?>
									$<?php echo number_format($producto->precio,0,',','.'); ?>
								<?php elseif($producto->descuentoPorProducto > 0): ?>
									$<?php echo number_format($producto->precio,0,',','.'); ?> 
									<br>
									<small>
										<strike style="color: #E00000;">
											$<?php 
												echo number_format($producto->precioAntesDescuento,0,',','.'); 
											?>
									</strike>
									</small>
								<?php endif ?>
							</h3>
						</div>
						<div class="row" style="margin-left: 0;">
							<?php if ($producto->estado_agotado === 'SI'): ?>
								<b class="text-danger">AGOTADO</b>
							<?php else: ?>
								<a class="btn-lg add-cart-button add-cart-button-single pull-left" onclick="addCart(<?php echo $producto->id_producto; ?>)" href="#"  data-toggle="modal" data-target="#cartModal">Agregar al carrito</a>
							<?php endif ?>
						</div>
						<div class="row" style="margin-top: 40px; margin-left: 0;">
							<div
							  class="fb-like"
							  data-layout="button"
							  data-share="true"
							  data-width="650"
							  data-show-faces="true">
							</div>	
						</div>
					</div>
				</div>
			</div>

			<div>
				<div class="clearfix"> </div>
			</div>
			<?php else: ?>
				Opps... Parece que el producto que buscas ya no se encuentra
			<?php endif ?>

		</div>
		<div class="clearfix"></div>

	
<!-- brands -->

	<div class="w3ls_w3l_banner_nav_right_grid w3ls_w3l_banner_nav_right_grid_popular">
		<div class="container">
			<h3>Productos Relacionados</h3>
				<div class="w3ls_w3l_banner_nav_right_grid1">
					<?php imprimirProducto($productos); ?>
					<div class="clearfix"> </div>
				</div>
		</div>
	</div>
<!-- //brands -->


<?php jsRequired(['jquery.elevatezoom-3.0.8.min']); ?>

<script type="text/javascript">
    $("#zoom_05").elevateZoom({
        responsive: true,    
        gallery:'gallery_01', 
        zoomType   : "inner",
        cursor: 'crosshair', 
        loadingIcon: base+'/images/spinner.gif	'
    }); 
     //pass the images to Fancybox
    $("#zoom_05").bind("click", function(e) {  
      var ez =   $('#zoom_05').data('elevateZoom'); 
        $.fancybox(ez.getGsalleryList());
      return false;
    });

    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
</script>