<?php 

$mysqli = new mysqli("localhost", "root", "", "usuarios_examen");

 
if ($mysqli->connect_errno) {
    printf("Falló la conexión: %s\n", $mysqli->connect_error);
    exit();
}else{
	
	if ( isset($_POST['email_base']) && $_POST['email_base']!="" && isset($_POST['pass_base']) && $_POST['pass_base']!="" && isset($_POST['annio_base']) && $_POST['annio_base']!="" ) {

		$sql_insertar = "INSERT INTO `usuario`(`id_usuario`, `correo`, `password`, `annioNacimiento`) VALUES ('".null."','".$_POST['email_base']."','".$_POST['pass_base']."','".$_POST['annio_base']."')";

		$resultado = mysqli_query($mysqli, $sql_insertar);

		if ($resultado) {
			echo 1;
		}
	}
}

$mysqli->close();

?>