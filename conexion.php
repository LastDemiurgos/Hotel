<?php

class CConexion {
	function ConexionBD(){
		
		$host = 'localhost';
		$dbname = 'hotel';
		$username = 'postgres';
		$password = 'panda';

		try {
			$conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
			echo "se conectó";
		} catch (PDOException $exp) {
			echo "no se pudo, " . $exp->getMessage();
		}
		return $conn;
	}

}

?>
