

<?php 
	
	$nombre = '';
	$apellido = '';
	$rolID = 0;
	$correo = '';
	$telefono = '';
	$estadoID = 0;
	$ciudadID = 0;
	$sexo = '';


	if (isset($data['id_usuario'])) {
		$nombre = $info['nombre'];
		$apellido = $info['apellido_usuario'];
		$rolID = $info['id_rol'];
		$correo = $info['correo'];
		$sexo = $info['sexo'];
	}

 ?>


<input type="hidden" name="empt_val">
<div class="form-group">
	<label for="nombre">Nombre</label>
	<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">
</div>
<div class="form-group">
	<label for="apellido_usuario">Apellido</label>
	<input type="text" class="form-control" id="apellido_usuario" name="apellido_usuario" placeholder="Apellido" value="<?php echo $apellido; ?>">
</div>
<div class="form-group">
	<label for="id_rol">Rol</label>
	<select class="form-control" name="id_rol" id="id_rol">
		<?php $roles = CRUD::all('roles'); ?>
		<?php $buscar = array_search($rolID, array_column($roles, 'id_rol'));  ?>
		<?php if ($buscar === false): ?>	
	  		<option disabled selected>Rol</option>
	  		<?php foreach ($roles as $rol): ?>
			  	<option value="<?php echo $rol['id_rol'] ?>">
			  		<?php echo $rol['rol'] ?>
			  	</option>
	 		<?php endforeach ?>
	 	<?php else: ?>
	 		<option value="<?php echo $roles[$buscar]['id_rol']; ?>">
		  		<?php echo $roles[$buscar]['rol']; ?>
		  	</option>
	 		<?php foreach ($roles as $rol): ?>
			  	<?php if ($rol['id_rol'] <> $rolID): ?>
			  		<option value="<?php echo $rol['id_rol'] ?>">
				  		<?php echo $rol['rol'] ?>
				  	</option>
			  	<?php endif ?>
	 		 <?php endforeach ?>
	  	<?php endif ?>
	</select>
</div>


<div class="form-group">
	<label for="correo">Correo</label>
	<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo" value="<?php echo $correo; ?>">
</div>



	<label>Género</label><br>

<div class="radio-inline">	<label>
	    <input type="radio" name="sexo" id="femenino" value="F" <?php if ($sexo === 'F'): ?>
	    	checked
	    <?php endif ?>>
	    Femenino
	</label>
</div>
<div class="radio-inline">
  	<label>
	    <input type="radio" name="sexo" id="masculino" value="M" <?php if ($sexo === 'M'): ?>
	    	checked
	    <?php endif ?>>
	    Masculino
  	</label>
</div>