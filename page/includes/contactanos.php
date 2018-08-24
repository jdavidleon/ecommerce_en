<?php 
	
	$nombre_contacto = '';
	$correo_contacto = '';
	$telefono_contacto = '';
	$asunto_contacto = '';
	$mensaje_contacto = '';

	$data = Secure::peticionRequest();
	$contact_form = true;
 	$error = [];
	if (!$data) {
		$contact_form = false;
	}


 	if ($contact_form) {
 		if (!Secure::validar_correo($data['correo_contacto'])) {
 			$error[] = 'Ingresa un correo válido.';
	       	$contact_form = false;
		}
 	}

	if ($contact_form) {
		$permitidos = [ 
			'nombre_contacto', 'telefono_contacto','correo_contacto', 'asunto_contacto', 'mensaje_contacto' 
		];

		$datos = Secure::parametros_permitidos($permitidos,$data);
		$contacto = CRUD::insert('contactenos',$datos);

		if ($contacto[0]->affected_rows < 1) {
			$error[] = 'Ha ocurrido un error al procesar la solicitud, por favor intentalo nuevamente.';
	       	$contact_form = false;
		}
	}

	if ($contact_form) {		
		$message = '';
		$message .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		              <html xmlns="http://www.w3.org/1999/xhtml"> 
		                  <head> 
		                      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		                      <title>Registro Nuevos usuarios</title>
		                      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		                  </head>';
		$message .= '<table>';
		$message .= '<tr>';
		$message .= 'Asunto: '.$datos['asunto_contacto'];
		$message .= '</tr>';
		$message .= '<tr>';
		$message .= 'Mensaje: '.$datos['mensaje_contacto'];
		$message .= '</tr>';
		$message .= '<tr>';   
		$message .= 'Correo: '.$datos['nombre_contacto'];
		$message .= '</tr>';
		$message .= '<tr>';   
		$message .= 'Correo: '.$datos['correo_contacto'];
		$message .= '</tr>';
		$message .= '<tr>';
		$message .= 'Teléfono: '.$datos['telefono_contacto'];
		$message .= '</tr>';
		  

		$sendMail = new SendMail('jlp25@hotmail.com',$datos['correo_contacto']);
		$sendMail->headers(strtoupper($datos['nombre_contacto']),'EnNavidad');
		$sendMail->content(strtoupper($datos['asunto_contacto']),$message);

	  	if(!$sendMail->send()) {         
			$where = 'correo_contacto = ? AND mensaje_contacto = ?';
			$params = ['ss',$datos['correo_contacto'],$datos['mensaje_contacto']];
			$update = CRUD::update('contactenos',['error_email' => 'ERROR'],$where,$params);

			if ($update[0]->affected_rows == 0) {
				$error[] = 'No hemos podido procesar tu solicitud por favor intentalo nuevamente.';
				$contact_form = false;
			}
	  	}
	}


	if (count($error) > 0) {		
		$nombre_contacto = $data['nombre_contacto'];
		$correo_contacto = $data['correo_contacto'];
		$telefono_contacto = $data['telefono_contacto'];
		$asunto_contacto = $data['asunto_contacto'];
		$mensaje_contacto = $data['mensaje_contacto'];
	}

?>


		<div class="w3l_banner_nav_right">
<!-- mail -->
		<div class="mail">
			<h3>Contáctanos</h3>
			<br>
			<?php if ($contact_form): ?>
				<div class="alert alert-success" role="alert">
					Hemos recibido tu mensaje nos pondremos en contacto contigo lo antes posible.
				</div>
			<?php else: ?>
				<?php if (count($error) > 0): ?>
					<?php foreach ($error as $err): ?>
						<div class="alert alert-danger" role="alert">
							<?php echo $err; ?>
						</div>
					<?php endforeach ?>					
				<?php endif ?>
			<?php endif ?>
			<div class="agileinfo_mail_grids">
				<div class="col-md-4 agileinfo_mail_grid_left">
					<ul>
						<li><i class="fa fa-envelope" aria-hidden="true"></i></li>
						<li>correo<span><a href="mailto:contacto@ennavidad.com">contacto@ennavidad.com</a></span></li>
					</ul>
					<ul>
						<li><i class="fa fa-commenting-o" aria-hidden="true"></i></li>
						<li>Facebook messenger<span><a href="http://m.me/ennavidad.col">Toca Aquí</a></span></li>
					</ul>
					<ul>
						<li><i class="fa fa-whatsapp" aria-hidden="true"></i></li>
						<li>Whatsapp<span>
							<a href="https://api.whatsapp.com/send?l=es&phone=57<?php echo $whatsapp; ?>" class="link-underline"> 
								<?php echo $whatsapp; ?>. Toca Aquí.
							</a></span>
						</li>
					</ul>
				</div>
				<div class="col-md-8 agileinfo_mail_grid_right">
					<form action="<?php echo URL_BASE; ?>page/contactanos/" method="post" role="form" target="_self">
						<div class="col-md-6 wthree_contact_left_grid">
							<input type="hidden" name="empt_val" value="">
							<input type="text" name="nombre_contacto" style="margin-top: 0;" placeholder="Nombre*" value="<?php echo $nombre_contacto; ?>" required="">
							<input type="email" name="correo_contacto" placeholder="Correo*" value="<?php echo $correo_contacto; ?>" required="">
						</div>
						<div class="col-md-6 wthree_contact_left_grid">
							<input type="text" name="telefono_contacto" placeholder="Teléfono*"  value="<?php echo $telefono_contacto; ?>" required="">
							<input type="text" name="asunto_contacto" value="<?php echo $asunto_contacto; ?>" placeholder="Asunto*" required="">
						</div>
						<div class="clearfix"> </div>
						<textarea  name="mensaje_contacto" placeholder="Mensaje*" required=""><?php echo $mensaje_contacto; ?></textarea>
						<input type="submit" value="Enviar">
						<input type="reset" value="Limpiar">
					</form>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
<!-- //mail -->
		</div>
		<div class="clearfix"></div>