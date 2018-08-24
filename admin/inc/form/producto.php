
<?php 

	$nombre = '';
	$descripcion = '';
	$categoria = 0;
	$subCategoria = 0;
	$precio = '';
	
	if (isset($productoCheck)) {
		$nombre = $productoCheck->nombre_producto;
		$descripcion = $productoCheck->descripcion;
		$categoria = $productoCheck->id_categoria;
		$subCategoria = $productoCheck->id_sub_categoria;
		$precio = $productoCheck->precioAntesDescuento;
	}
 ?>

	<input type="hidden" name="empt_val">
	<div class="form-group">
		<label for="nombre_producto">Nombre del producto</label>
		<input type="text" class="form-control" id="nombre_producto" name="nombre_producto" placeholder="Nombre del producto" value="<?php echo $nombre; ?>">
	</div>
	<div class="form-group">
		<label for="descripcion">Descripción</label>
		<input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Nombre del producto" value="<?php echo $descripcion; ?>">
	</div>
	<div class="form-group">
		<label for="id_categoria">Categoria</label>
		<select class="form-control id_categoria" onchange="searchSubC()" name="id_categoria" id="id_categoria" required>
		  	<?php $categorias = CRUD::all('categorias'); ?>

		  	<?php $buscar = array_search($categoria, array_column($categorias, 'id_categoria'));  ?>

		  	<?php if ($buscar === false): ?>	
		  		<option disabled selected>Categoria</option>
		  		<?php foreach ($categorias as $cat): ?>
				  	<option value="<?php echo $cat['id_categoria'] ?>">
				  		<?php echo $cat['categoria'] ?>
				  	</option>
		 		 <?php endforeach ?>
		 	<?php else: ?>
		 		<option value="<?php echo $categorias[$buscar]['id_categoria']; ?>">
			  		<?php echo $categorias[$buscar]['categoria']; ?>
			  	</option>
		 		<?php foreach ($categorias as $cat): ?>
				  	<?php if ($cat['id_categoria'] <> $categoria): ?>
				  		<option value="<?php echo $cat['id_categoria'] ?>">
					  		<?php echo $cat['categoria'] ?>
					  	</option>
				  	<?php endif ?>
		 		 <?php endforeach ?>
		  	<?php endif ?>
		  	
		</select>
	</div>
	
	<div class="form-group">
		<label for="id_sub_categoria">Sub-categoria</label>
		<select class="form-control id_sub_categoria" name="id_sub_categoria" id="id_sub_categoria">
			<?php if ($buscar === false): ?>
				<option disabled selected>Sub-Categoria</option>
			<?php else: ?>
				<?php $sub_categorias = CRUD::all('categorias_sub','*','id_categoria = ?',['i',$categoria]);?>
				<?php if (count($sub_categorias) === 0): ?>
					<option disabled selected>Sin Sub-categoria</option>
				<?php endif ?>
				<?php foreach ($sub_categorias as $sub): ?>
					<?php if ($sub['id_sub_categoria'] === $subCategoria): ?>
						<option value="<?php echo $sub['id_sub_categoria'] ?>">
					  		<?php echo $sub['nombre_sub_categoria_es'] ?>
					  	</option>
					<?php endif ?>
				<?php endforeach ?>
				<?php foreach ($sub_categorias as $sub): ?>
					<?php if ($sub['id_sub_categoria'] <> $subCategoria): ?>
						<option value="<?php echo $sub['id_sub_categoria'] ?>">
					  		<?php echo $sub['nombre_sub_categoria_es'] ?>
					  	</option>
					<?php endif ?>
				<?php endforeach ?>
			<?php endif ?>
		</select>
	</div>
	
	<div class="form-group">
		<label for="precio">Precio (USD)</label>
	    <div class="input-group">
	      <div class="input-group-addon">$</div>
	      <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio" value="<?php echo $precio; ?>">
	    </div>
	</div>		
	