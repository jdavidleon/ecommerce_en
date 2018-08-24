<?php 

	require '../../../config/config.php';
	require DIRECTORIO_ROOT.'config/autoload.php';

	$data = Secure::peticionRequest();

	if (!$data) {
		$msn = "ERROR_DATA_REQUEST";
		$result = 'error';
		location($result,$msn);
		exit();		
	}

	$data['token'] = Secure::crear_csrf_token();

	$permitidos = [ 'correo', 'token' ];
	$datos = Secure::parametros_permitidos($permitidos,$data);

	$find = CRUD::numRows('usuarios','*','correo = ?',['s',$data['correo']]);

	if ($find === 1) {
		$create = CRUD::insert('usuarios_restaurar_psw',$datos);

		if ($create[0]->affected_rows === 1) {
			sendEmail();
		}else{
			$msn = 'ERROR_DATA_REQUEST';
			$result = 'error';
			location($result,$msn);
			exit();			
		}
	}else{
		$msn = 'COUNT_LOST';
		$result = 'error';
		location($result,$msn);
		exit();
	}


	function location($result,$msn)
	{	
		header('Location: '.URL_PAGE.'/pages/usuarios/recuperar-clave/'.$result.'/'.$msn.'/'.$GLOBALS['correo']);
	}

	function sendEmail()
	{	

		$email = $GLOBALS['datos']['correo'];
		$lang = $GLOBALS['lang'];
		require DIRECTORIO_ROOT.'lang/'.$lang.'.php';

		$mail = new PHPMailer();
	    if (!$mail->ValidateAddress($email)) {
	         $msn = "INVALID_MAIL";
			$result = 'error';
			location($result,$msn);
			exit();
	    }

	   /*Token*/
	   $user = CRUD::all('usuarios','*','correo = ?',['s',$email]);
	   $data = Secure::decodeArray($user[0]);
	   $token = $GLOBALS['datos']['token'];

	   if (count($user) === 0) {
	        $msn = "COUNT_LOST";
			$result = 'error';
			location($result,$msn);
			exit();
	   		
	   }

	   // Configuramos el protocolo SMTP con autenticación
       $mail->IsSMTP();  
       $mail->SMTPAuth = true;

       // Configuración del servidor SMTP
       $mail->Port = 25;  
       $mail->Host = 'mail.madeitforu.com';
       $mail->Username   = "service@madeitforu.com";
       $mail->Password = "ctlb31207";

       // Configuración cabeceras del mensaje
       $mail->From = "gifts@madeitforu.com";  
       $mail->FromName = "MADEITFORU";
       $mail->AddAddress($email, strtoupper($data->nombre.' '.$data->apellido_usuario));
       $ruta = "http://www.madeitforu.com/".$lang."/pages/restore/".$token."/".$email;
       $token2 = md5($email.SALTREG);
       $unsubscribeLink = 'http://madeitforu.com/bd/newsletter/unregister.php?correo_news='.$email.'&token='.$token2;


       if ($lang === 'es') {
       		$proceso = "Restablecer Cuenta";
       }else{
       		$proceso = 'Reset Account';
       }

       $mail->Subject  = $proceso." | MADEITFORU";

    	require DIRECTORIO_ROOT.'inc/email/restartPassword.php';  

       $mail->SetFrom("gifts@madeitforu.com", "MADEITFORU");   
       $mail->MsgHTML($message);

        if($mail->Send()) {    
			$msn = 'success_form_forgotpassword';
			$result = 'success';
			location($result,$msn);
			exit();	  
        }else{        	
			$msn = 'ERROR_DATA_REQUEST';
			$result = 'error';
			location($result,$msn);
			exit();	
        }
	}

	