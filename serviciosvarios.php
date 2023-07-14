<?php

class CConexion {
	static function ConexionBD(){
		
		$host = 'localhost';
		$dbname = 'hotel';
		$username = 'postgres';
		$password = 'panda';

		try {
			$conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
			return $conn;
		} catch (PDOException $exp) {
			echo "no se pudo, " . $exp->getMessage();
			return null;
		}
	}
}

// Crear la vista "serviciosvarios"
$conn = CConexion::ConexionBD();

// Comprueba si la conexión es exitosa


?>
