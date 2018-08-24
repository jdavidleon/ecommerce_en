<?php 
	$productos = Products::consultaPorCategorias($_GET['id_categoria']);
	// var_dump($productos);
	$categoria = CRUD::all('categorias','categoria','id_categoria = ?',['i',$_GET['id_categoria']]);
	if ( count($categoria) > 0 ) {
		$cat = $categoria[0]['categoria'];
	}else{
		$cat = strtolower( str_replace('-',' ',$_GET['categoria']) );
	}
?>

<div class="w3l_banner_nav_right">

<div class="w3ls_w3l_banner_nav_right_grid" style="margin-top: 50px;">
	<h3><?php echo ucwords($cat); ?></h3>
	<div class="w3ls_w3l_banner_nav_right_grid1">

		<?php if ( count($categoria) > 0 ): ?>
			<?php imprimirProducto($productos); ?>
		<?php else: ?>
			<div class="jumbotron" style="background-color: transparent;">
			  <div class="container">
			    <div class="col-lg-12">
			    	<p class="text-center">Opps.... La categoria que buscas ya no existe.</p>
			    </div> 
			  </div>
			</div>			
		<?php endif ?>


		<div class="clearfix"> </div>
	</div>
</div>
</div>
<div class="clearfix"></div>
	</div>