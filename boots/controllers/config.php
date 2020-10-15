  
<?php 
	//mostrar errores
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	//iniciar la sesión
	if (!isset($_SESSION)) {
		session_start();
	}

	//crear el token
	if (!isset($_SESSION['token'])) {
		$_SESSION['token'] = md5( uniqid(mt_rand(),true) );
	}
?>