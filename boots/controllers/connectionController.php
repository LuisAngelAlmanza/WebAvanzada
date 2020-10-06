<?php 

	define("HOST", "localhost");
	define("USER", "root");
	define("PASS", "");
	define("DBNM", "crud2");

	function connect()
	{
		$conn = new mysqli(HOST,USER,PASS,DBNM);
		if ($conn) {
			return $conn;
		}
		return null;
	}

?>