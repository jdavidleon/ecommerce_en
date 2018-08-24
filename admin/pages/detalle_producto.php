<?php $web = true; ?>
<?php require '../../config/config.php'; ?>
<?php $titlePage = 'Productos'; ?>
<?php $pag = 'productos'; ?>
<?php require DIRECTORIO_ROOT.'admin/inc/header.php'; ?>
	
	<div class="container">	
		<h3 class="text-center" style="">Imagenes del Producto</h3>	
	</div>

	<br>
	<br>
	
	<div class="container" style="margin-bottom: 200px;">
		
		<?php $producto = Products::find($_GET['id_producto']); ?>  
		<?php 
			$imagenes = Products::imgProducts($producto->serie);
		?>
		
		<div class="row">
			<div class="col-sm-12">
				<h4><?php echo $producto->nombre_producto; ?></h4>
			</div>
			<br><br><br>
		</div>

		<div class="row">

		<?php foreach ($imagenes as $img): ?>
			<div class="col-sm-6 col-md-3">
			    <div class="thumbnail">
					<img src="<?php echo URL_BASE.'img_productos/'.$img->serie.'/thumbnail/'.$img->ruta_img_tn; ?>">
			      	<div class="caption">

			      		<?php if ($img->ruta_img_lg === $producto->ruta_img_lg): ?>
			      			<br>
			        		<h4><b>IMAGEN PRINCIPAL</b></h4>
			        	<?php else: ?>
			        		<br>
				        	<p>	
				        		<form action="<?php echo ADMIN; ?>bd/productos/delete_img.php" method="POST">
				        			<input type="hidden" name="empt_val">
				        			<input type="hidden" name="id_producto" value="<?php echo $_GET['id_producto']; ?>">
				        			<input type="hidden" name="id_p_imagenes" value="<?php echo $img->id_p_imagenes; ?>">
				        			<input type="submit" class="btn btn-default pull-right" value="Eliminar">
				        		</form>
				        		<form action="<?php echo ADMIN; ?>bd/productos/img_ppal.php" method="POST">
				        			<input type="hidden" name="empt_val">
				        			<input type="hidden" name="id_producto" value="<?php echo $_GET['id_producto']; ?>">
				        			<input type="hidden" name="id_pip" value="<?php echo $producto->id_pip; ?>">
				        			<input type="hidden" name="ruta_img_lg" value="<?php echo $img->ruta_img_lg; ?>">
				        			<input type="hidden" name="ruta_img_sm" value="<?php echo $img->ruta_img_sm; ?>">
				        			<input type="hidden" name="ruta_img_tn" value="<?php echo $img->ruta_img_tn; ?>">
				        			<input type="submit" class="btn btn-primary pull-left" value="Asignar como ppal"> 
				        		</form>
				        	</p>
			        		<br>
			      		<?php endif ?>
						<br>
			        	
			      	</div>
			    </div>
			</div>
		<?php endforeach ?>

		</div>

		<div class="row">
			<div class="col-sm-12" style="margin-left: 20px; ">
				
			</div>
			<br>
			<br>
			<div class="col-sm-6" style="border: 1px solid grey; padding: 20px; margin-left: 20px;">
				<h4>Agregar Imagenes</h4><br>
				<form action="<?php echo ADMIN; ?>bd/productos/add_images.php" method="POST" role="form" enctype="multipart/form-data">
					<input type="hidden" name="empt_val">
					<input type="hidden" name="serie" value="<?php echo $producto->serie; ?>">
					<input type="hidden" name="id_producto" value="<?php echo $_GET['id_producto'] ?>">
					<input type="file" class="btn" id="img_lg" name="img_lg[]" multiple>
					<br>
					<input class="btn btn-success" type="submit" value="Agregar">
				</form>
			</div>
		</div>


	</div>





<?php include DIRECTORIO_ROOT.'admin/inc/footer.php'; ?>
