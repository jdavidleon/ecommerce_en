<?php
	
	include '../../config/config.php';
	include DIRECTORIO_ROOT.'config/autoload.php';

	$data = Secure::peticionRequest();

	if (!$data) {
		$msn = "ERROR_DATA_REQUEST";
		$result = 'error';
    location(); 
    return false;
	}

 

	if (!Secure::validar_correo($data['correo_contacto'])) {
        $msn = "INVALID_MAIL";
        $result = 'error';
        location();
        return false;
	}

  $lang = $data['lang'];
  unset($data['lang']);

	$permitidos = [ 'nombre_contacto', 'telefono_contacto','correo_contacto', 'asunto_contacto', 'mensaje_contacto' ];

	$datos = Secure::parametros_permitidos($permitidos,$data);

	$contacto = CRUD::insert('contactenos',$datos);

	if ($contacto[0]->affected_rows === 1) {
		$msn = 'success_contact';
    $result = 'success';
	}else{
		$msn = 'ERROR_DATA_REQUEST';
    $result = 'error';
    location();
    return false;
	}

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
      

  $sendMail = new SendMail('gifts@madeitforu.com',$datos['correo_contacto']);
  $sendMail->headers(strtoupper($datos['nombre_contacto']));
  $sendMail->content(strtoupper($datos['asunto_contacto']),$message);

  if(!$sendMail->send()) {         
      $where = 'correo_contacto = ? AND mensaje_contacto = ?';
      $params = ['ss',$datos['correo_contacto'],$datos['mensaje_contacto']];
      $update = CRUD::update('contactenos',['error_email' => 'ERROR'],$where,$params);
      $msn = "INVALID_MAIL";
      $result = 'error';
      location();
      return false;
  }


  location();
    
  function location()
  {
    header('Location: '.URL_PAGE.'/'.$GLOBALS['lang'].'/pages/contact/'.$GLOBALS['result'].'/'.$GLOBALS['msn']);
  }
