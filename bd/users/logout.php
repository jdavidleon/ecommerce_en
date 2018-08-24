<?php 

	session_start();
	include '../../config/config.php';
	// include '../../config/autoload.php';
	
	if (isset($_REQUEST['csrf']) AND isset($_SESSION['csrf_token']) AND $_SESSION['csrf_token'] == $_REQUEST['csrf']) {
		$_SESSION = array();

		// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
		// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}

		// Finalmente, destruir la sesión.
		session_destroy();

	}


	header("Location:".URL_BASE);

?>