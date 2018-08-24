<?php 
	require "../../../config/config.php";
	// require DIRECTORIO_ROOT."config/autoload.php"; 


	$data = Secure::recibirRequest();

	if (!$data) {
		Secure::errorRequest();
		return false;
	}
	
	$user = new User($data['id_usuario']);
	$address = $user->address($data['id_usuario']);
	$info = $user->informacion_personal;
?>


<form action="<?php echo URL_BASE.'admin/bd/usuarios/save/editar.php' ?>" method="POST" role="form">
	<input type="hidden" name="id_usuario" value="<?php echo $data['id_usuario']; ?>">
	<?php include DIRECTORIO_ROOT.'admin/inc/form/usuario.php'; ?>
	<br>
	<button type="submit" class="btn btn-sm btn-success pull-right" style="margin: 0 10px;">Guardar</button>
    <button type="button" class="btn btn-sm pull-right" data-dismiss="modal">Cerrar</button>
</form>