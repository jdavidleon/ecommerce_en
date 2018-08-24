<?php 


	function cssRequired($cssStyles){
		foreach ($cssStyles as $style) {
			$link = '<link rel="stylesheet" type="text/css" ';
			$link .= 'href="'.ASSETS.'css/'.$style.'.css">';
			echo $link;
		}
	}

	function jsRequired($jsArchive){
		foreach ($jsArchive as $js) {
			$script = '<script type="text/javascript"';
			$script .= 'src="'.ASSETS.'js/'.$js.'.js"></script>';
			echo $script;
			echo "<br>";
		}
	}

	function imprimirProducto($products = [])
	{ ?>
		<?php foreach ($products as $p): ?>	
			<?php 
				$link_product = strtolower(str_replace(' ','-',$p['nombre_producto']));
				$link =  str_replace("&ntilde;",'n',utf8_decode($link_product));
				$url_line = str_replace(' ', '-', $p['categoria']); 
				$url_cat = str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $url_line);
				$url = URL_BASE.'page/coleccion/'.$p['id_categoria'].'/'.$url_cat.'/'.$p['id_producto'].'/'.$link.'/';
			?>		
			<div class="col-md-3 w3ls_w3l_banner_left">
				<div class="hover14 column" style="padding-top: 25px;">
				<div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
					<?php if ($p['descuentoPorProducto'] > 0): ?>
						<div class="agile_top_brand_left_grid_pos" style="z-index: 9; top: -20px; left: -20px;">
							<img src="images/offer.png" alt=" " class="img-responsive" />
							<span style="font-weight: 900; position: absolute; top: 23px; left: 19px; color: white;  font-size: 20px;"><?php echo $p['porcentajeDescuento']; ?>%</span>
						</div>
					<?php endif ?>
					<div class="agile_top_brand_left_grid1">
						<figure>
							<div class="snipcart-item block">
								<div class="snipcart-thumb">
									<a href="<?php echo $url; ?>">

										<div style="width: 100%; height: 100%; background-color: transparent; position: absolute;"></div>
										<img src="<?php echo URL_BASE.'img_productos/'.$p['serie'].'/small/'.$p['ruta_img_sm']; ?>" alt=" " class="img-responsive" />
									</a>
									<p class="text-center"><?php echo $p['nombre_producto']; ?></p>
									<h4 class="text-center">
										<?php if ($p['descuentoPorProducto'] === 0): ?>
											$<?php echo number_format($p['precio']); ?>
										<?php elseif($p['descuentoPorProducto'] > 0): ?>
											$<?php echo number_format($p['precio']); ?> 
											<span style="color: red;">
												$<?php echo number_format($p['precioAntesDescuento']); ?>
											</span>
										<?php endif ?>
									</h4>
								</div>
								<div class="snipcart-details">
									<?php if ($p['estado_agotado'] === 'SI'): ?>
										<b class="text-danger">AGOTADO</b>
									<?php else: ?>
										<a class="btn-lg add-cart-button" href="<?php echo $url; ?>">VER MÁS </a>	
									<?php endif ?>
								</div>
							</div>
						</figure>
					</div>
				</div>
				</div>
			</div>
		<?php endforeach ?>
<?php  } ?>