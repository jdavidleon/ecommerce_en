<?php 
	session_start();
	require "../../../config/config.php";
	require DIRECTORIO_ROOT."config/autoload.php"; 
	$lang = $_REQUEST['lang'];
	require DIRECTORIO_ROOT."lang/".$lang.'.php';

	$data = Secure::peticionRequest('GET');

	$where = 'id_direcciones = ?';
	$params = ['i',$_REQUEST['id_direcciones']];

	$direccion = CRUD::all('usuarios_direcciones','*',$where,$params);
	$address = Secure::decodeArray($direccion[0]);
	$estados = User::estados(); 
	$ciudades = CRUD::all('ciudades','*','id_estado = ?',['i',$address->id_estado_eu]);

?>	
	
	<form class="form-modals" action="<?php echo URL_BASE.'bd/users/address/edit.php' ?>" method="POST" role="form">
		<input type="hidden" name="id_direcciones" value="<?php echo $address->id_direcciones; ?>">
        <input type="hidden" name="url" value="<?php echo $_REQUEST['urlOrigen']; ?>">
		<input type="hidden" name="empt_val">

        <div class="modal-body">

			<div class="form-group">
				<label for="nombre_direccion"><?php echo $addressCheck->form_name; ?></label>
				<input type="text" class="form-control" id="nombre_direccion" name="nombre_direccion" value="<?php echo $address->nombre_direccion; ?>" required>
			</div>

			<div class="form-group">
				<label for="apellido_direccion"><?php echo $addressCheck->form_last_name; ?></label>
				<input type="text" class="form-control" id="apellido_direccion" name="apellido_direccion" value="<?php echo $address->apellido_direccion; ?>" required>
			</div>

			<!-- ESTADOS -->
			<div class="form-group">
				<label for="id_estado_eu"><?php echo $addressCheck->form_state; ?></label>
				<select class="form-control estado_eu" name="id_estado_eu" id="id_estado_eu" required>
					<?php foreach ($estados as $ID => $estado): ?>
						<?php if ($ID === $address->id_estado_eu): ?>
							<option value="<?php echo $ID; ?>" ><?php echo $estado; ?></option>
						<?php endif ?>						
					<?php endforeach ?>					
					<?php foreach ($estados as $ID => $estado): ?>
						<?php if ($ID !== $address->id_estado_eu): ?>
							<option value="<?php echo $ID; ?>" ><?php echo $estado; ?></option>
						<?php endif ?>						
					<?php endforeach ?>
				</select>
			</div>
			<!-- #ESTADOS -->

			<!-- CIUDADES -->
			<div class="form-group">
				<label for="id_ciudad"><?php echo $addressCheck->form_city; ?></label>
				<select class="form-control ciudades" name="id_ciudad" id="id_ciudad" required>
				<?php foreach ($ciudades as $ciudad): ?>
						<?php if ($ciudad['id_ciudad'] === $address->id_ciudad): ?>
							<option value="<?php echo $ciudad['id_ciudad']; ?>" ><?php echo $ciudad['nombre_ciudad']; ?></option>
						<?php endif ?>						
					<?php endforeach ?>					
					<?php foreach ($ciudades as $ciudad): ?>
						<?php if ($ciudad['id_ciudad'] !== $address->id_ciudad): ?>
							<option value="<?php echo $ciudad['id_ciudad']; ?>" ><?php echo $ciudad['nombre_ciudad']; ?></option>
						<?php endif ?>						
					<?php endforeach ?>
				</select>
			</div>
			<!-- #CIUDADES -->

			<div class="form-group">
				<label for="direccion"><?php echo $addressCheck->form_address; ?></label>
				<input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $address->direccion; ?>" required>
			</div>
			
			<div class="form-group">
				<label for="zip_code"><?php echo $addressCheck->form_zip_code; ?></label>
				<input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo $address->zip_code; ?>" required>
			</div>		
			
			<div class="form-group" style="padding-left: 5px;">
				<label for="telefono"><?php echo $addressCheck->form_phone; ?></label>
				<input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $address->telefono; ?>" required>
			</div>
			<br>
			<button type="submit" class="btn btn-mifu-modal btn-lg btn-block">
	            <?php echo $addressCheck->form_submit; ?>
	        </button>
		</div>
	</form>
