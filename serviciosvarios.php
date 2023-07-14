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

// Mostrar todas las tablas y su contenido
$conn = CConexion::ConexionBD();

// Comprueba si la conexión es exitosa
if ($conn) {
    $query = "SELECT table_name FROM information_schema.tables WHERE table_schema='public'";

    $stmt = $conn->prepare($query);

    if ($stmt->execute()) {
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if (!empty($tables)) {
            foreach ($tables as $table) {
                echo "Tabla: $table<br>";
                $queryData = "SELECT * FROM $table";
                $stmtData = $conn->prepare($queryData);
                if ($stmtData->execute()) {
                    $tableData = $stmtData->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($tableData)) {
                        echo "<table border='1'>";
                        echo "<tr>";
                        foreach ($tableData[0] as $column => $value) {
                            echo "<th>$column</th>";
                        }
                        echo "</tr>";
                        foreach ($tableData as $row) {
                            echo "<tr>";
                            foreach ($row as $value) {
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "La tabla está vacía.";
                    }
                } else {
                    echo "Error al obtener los datos de la tabla $table.";
                }
                echo "<br><br>";
            }
        } else {
            echo "No se encontraron tablas en la base de datos.";
        }
    } else {
        echo "Error al obtener las tablas.";
    }
} else {
    echo "Error al conectar a la base de datos.";
}

?>
