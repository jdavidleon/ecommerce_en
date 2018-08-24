<div class="w3l_banner_nav_left">
	<nav class="navbar nav_bottom">
	 <!-- Brand and toggle get grouped for better mobile display -->
	  <div class="navbar-header nav_2">
		  <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
			<span class="sr-only">Menu Desplegable</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
	   </div> 
	   <!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
			<ul class="nav navbar-nav nav_1">
				<?php $categorias = CRUD::all('categorias'); ?>
				<?php foreach ($categorias as $cat): ?>
					<?php 
					$url_line = str_replace(' ', '-', $cat['categoria']); 
					$url_cat = str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $url_line);
					?>
					<li>
						<a href="<?php echo URL_BASE.'page/coleccion/'.$cat['id_categoria'].'/'.$url_cat; ?>">
							<b><?php echo ucfirst($cat['categoria']); ?></b>
							<p style="padding-right: 20px;"> 
								<?php echo $cat['descripcion']; ?>
							</p>
						</a>
					</li>					
				<?php endforeach ?>
				<li class="text-center payu-respaldo">
		 			<a href="https://www.payulatam.com/logos/pol.php?l=149&c=59d7f608dbcf2" target="_blank"><img src="<?php echo URL_PAGE ?>images/logo_respaldo_payu.png" alt="PayU Latam" border="0" /></a>
				</li>
			</ul>
		 </div><!-- /.navbar-collapse -->
	</nav>
</div>