<?php 
	$user = new User($_SESSION['id_usuario']);
    $informacion = $user->infoPersonal();
    $estados = CRUD::all('estados');

    $success_info_updated = 'Información de cuenta actualizada';
    $success_psw_update  = 'Contraseña actualizada correctamente';
    $ERROR_UPDATE_DATA = 'No se ha actualizado tu información de cuenta.';
    $LENGHT_PASSWORD = 'La contraseña debe tener entre 7 y 25 caracteres.';
    $ERROR_VALIDATE_PSW = 'La contraseña actual no coincide con la almacenada.';
    $ERROR_DIFERENT_PASSWORD = 'La nueva contraseña no coincide';
?>

<div class="w3l_banner_nav_right text-center" style="padding: 40px; margin: 0 auto;">
	<div class="w3ls_w3l_banner_nav_right_grid">
		<div class="privacy">
			<h3 class="text-center logo-name">Información de cuenta</h3>
			<br>
		    <?php if (isset($_GET['result'])): ?>
		        <?php if ($_GET['result'] === 'success'): ?>
					<div class="alert alert-success alert-dismissible text-center" role="alert">
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  		<span aria-hidden="true">&times;</span>
					  	</button>
					  	<?php echo $$_GET['msn']; ?>
					</div>
		        <?php elseif($_GET['result'] === 'error'): ?>
					<div class="alert alert-danger alert-dismissible text-center" role="alert">
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  		<span aria-hidden="true">&times;</span>
					  	</button>
					  	<strong class="text-uppercase">Ha Ocurrido un error!</strong> <?php echo $$_GET['msn']; ?>
					</div>
		        <?php endif ?>
		    <?php endif ?>

		    <form action="<?php echo URL_BASE."bd/users/update/personal_info.php"; ?>" id="form_datos_personales" method="post" class="text-left">
		        <!-- hide -->
		        <input type="hidden" name="empt_val">
		        <div class="form-group">
		            <label for="nombre">Nombre</label>
		            <input type="text" class="form-control text-uppercase" id="nombre" name="nombre" value="<?php echo $informacion['nombre']; ?>" required>
		        </div>
		        <div class="form-group">
		            <label for="apellido_usuario">Apellido</label>
		            <input type="text" class="form-control text-uppercase" id="apellido_usuario" name="apellido_usuario" value="<?php echo $informacion['apellido_usuario']; ?>" required>
		        </div>
		        <div class="form-group">
		            <label for="correo">Correo</label>
		            <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $informacion['correo']; ?>" required>
		        </div>
		        <p id="respond_person_data" class="respuesta-ajax text-center"></p>
		        <div class="text-center" style="margin-top: 40px;">
		            <button type="submit" class="btn btn-mifu-reverse " style="border-radius: 0;"><i class="fa fa-save"></i>  Guardar</button>
		        </div>
		    </form>
		    <br><br>
		    <br><br>
		    <h3 class="text-center logo-name">Cambiar Contraseña</h3>
		    <form action="<?php echo URL_BASE."bd/users/update/clave.php"; ?>" method="post" id="form_clave_usuario" class="text-left">
		        <input type="hidden" name="empt_val">
		        <div class="form-group">
		            <label for="password_old">Actual contraseña</label>
		            <input type="password" class="form-control" id="password_old" name="password_old" required>
		        </div>
		        <div class="form-group">
		            <label for="password_new">Nueva contraseña</label>
		            <input type="password" class="form-control" id="password_new" name="password_new" required>
		        </div>
		        <div class="form-group">
		            <label for="password_new2">Repite contraseña</label>
		            <input type="password" class="form-control" id="password_new2" name="password_new2" required>
		        </div>
		        <p id="respond_person_psw" class="respuesta-ajax text-center"></p>
		        <div class="text-center" style="margin-top: 40px;">
		            <button type="submit" class="btn btn-mifu-reverse" style="border-radius: 0;"><i class="fa fa-save"></i> Guardar</button>
		        </div>
		    </form>
<!-- infoAccount -->

		</div>
	</div>    
</div>
<div class="clearfix"></div>
<br><br><br>