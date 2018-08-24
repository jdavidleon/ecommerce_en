<?php 

	define("URL_BASE", "/ennavidad/");
	define("DIRECTORIO_ROOT",$_SERVER["DOCUMENT_ROOT"] . "/ennavidad/");
	define('URL_PAGE', '/ennavidad/');
	define('ASSETS', URL_BASE.'assets/');
	


	//Admin	
	define('ADMIN',URL_BASE."admin/");	


	// Tokens
	define("SALTREG", "BB67*6765v/8c545");
	define('SALTPSW', '$%imund9489//8=mo');

	require DIRECTORIO_ROOT.'config/autoload.php';
	require DIRECTORIO_ROOT.'functions.php';
	
	
	