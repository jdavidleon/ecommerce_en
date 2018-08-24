<?php 
	spl_autoload_register( function ($nombre_clase) {
		include 'class/class.'.$nombre_clase.".php";
	});
	
	new Config;