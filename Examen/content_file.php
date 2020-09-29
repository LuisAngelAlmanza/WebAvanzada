<?php 

$mysqli = new mysqli("localhost", "root", "", "usuarios_examen");

 
if ($mysqli->connect_errno) {
    printf("Falló la conexión: %s\n", $mysqli->connect_error);
    exit();
}else{
	
	$consultar = "SELECT * FROM usuario";
	$ejecConsulta = mysqli_query($mysqli, $consultar);
	$vFilas = mysqli_num_rows($ejecConsulta);
	$fila = mysqli_fetch_array($ejecConsulta);

	if ( !$ejecConsulta ){
		echo 1;
	} else if ( $vFilas < 1 ){
		echo "<tr><td>Sin registros</td></tr>";
	} else {
		for ( $i = 0; $i <= $fila; $i++ ){
			echo '
				<tr>
					<td>'.$fila[1].'</td>
					<td>'.$fila[2].'</td>
					<td>'.$fila[3].'</td>
				</tr>
			';
			$fila = mysqli_fetch_array($ejecConsulta);
		}
	}
}

$mysqli->close();

?>