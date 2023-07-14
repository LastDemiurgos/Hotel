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

// Función para ingresar un cliente
function IngresarCliente($pasaporte_NUEVO, $correo_NUEVO, $nombre_NUEVO, $apellido_NUEVO, $telefono_NUEVO, $nacionalidad_NUEVO, $fecha_nac_NUEVO, $codigo_tc) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $conn->beginTransaction();
            
            $stmt1 = $conn->prepare("INSERT INTO Info_Cliente (Correo, Nombre, Apellido) VALUES (?, ?, ?)");
            $stmt1->execute([$correo_NUEVO, $nombre_NUEVO, $apellido_NUEVO]);
            
            $stmt2 = $conn->prepare("INSERT INTO Cliente (Pasaporte, Correo, Nacionalidad, Fecha_Nac, Codigo_TC) VALUES (?, ?, ?, ?, ?)");
            $stmt2->execute([$pasaporte_NUEVO, $correo_NUEVO, $nacionalidad_NUEVO, $fecha_nac_NUEVO, $codigo_tc]);
            
            $stmt3 = $conn->prepare("INSERT INTO Telefono_Cliente (Telefono, Pasaporte) VALUES (?, ?)");
            $stmt3->execute([$telefono_NUEVO, $pasaporte_NUEVO]);
            
            $conn->commit();
            
            echo "Cliente ingresado exitosamente.";
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error al ingresar el cliente: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para modificar un cliente
function ModificarCliente($pasaporte_cliente, $nuevo_correo, $nuevo_nombre, $nuevo_apellido, $nuevo_telefono, $nueva_nacionalidad, $nueva_fecha_nac, $nuevo_codigo_tc) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $conn->beginTransaction();
            
            $stmt1 = $conn->prepare("UPDATE Info_Cliente SET Correo = ?, Nombre = ?, Apellido = ? WHERE Correo = (SELECT Correo FROM Cliente WHERE Pasaporte = ?)");
            $stmt1->execute([$nuevo_correo, $nuevo_nombre, $nuevo_apellido, $pasaporte_cliente]);
            
            $stmt2 = $conn->prepare("UPDATE Cliente SET Correo = ?, Nacionalidad = ?, Fecha_Nac = ?, Codigo_TC = ? WHERE Pasaporte = ?");
            $stmt2->execute([$nuevo_correo, $nueva_nacionalidad, $nueva_fecha_nac, $nuevo_codigo_tc, $pasaporte_cliente]);
            
            $stmt3 = $conn->prepare("UPDATE Telefono_Cliente SET Telefono = ? WHERE Pasaporte = ?");
            $stmt3->execute([$nuevo_telefono, $pasaporte_cliente]);
            
            $conn->commit();
            
            echo "Cliente modificado exitosamente.";
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error al modificar el cliente: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para eliminar un cliente
function EliminarCliente($pasaporte_cliente) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $conn->beginTransaction();
            
            $stmt1 = $conn->prepare("SELECT Correo FROM Cliente WHERE Pasaporte = ?");
            $stmt1->execute([$pasaporte_cliente]);
            $correo_cliente = $stmt1->fetchColumn();
            
            $stmt2 = $conn->prepare("DELETE FROM Cliente WHERE Pasaporte = ?");
            $stmt2->execute([$pasaporte_cliente]);
            
            $stmt3 = $conn->prepare("DELETE FROM Info_Cliente WHERE Correo = ?");
            $stmt3->execute([$correo_cliente]);
            
            $stmt4 = $conn->prepare("DELETE FROM Telefono_Cliente WHERE Pasaporte = ?");
            $stmt4->execute([$pasaporte_cliente]);
            
            $conn->commit();
            
            echo "Cliente eliminado exitosamente.";
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error al eliminar el cliente: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Procesar formulario de ingresar cliente
if (isset($_POST['pasaporte']) && isset($_POST['correo']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['telefono']) && isset($_POST['nacionalidad']) && isset($_POST['fecha_nac']) && isset($_POST['codigo_tc'])) {
    $pasaporte = $_POST['pasaporte'];
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $nacionalidad = $_POST['nacionalidad'];
    $fecha_nac = $_POST['fecha_nac'];
    $codigo_tc = $_POST['codigo_tc'];
    
    IngresarCliente($pasaporte, $correo, $nombre, $apellido, $telefono, $nacionalidad, $fecha_nac, $codigo_tc);
}

// Procesar formulario de modificar cliente
if (isset($_POST['pasaporte_mod']) && isset($_POST['nuevo_correo']) && isset($_POST['nuevo_nombre']) && isset($_POST['nuevo_apellido']) && isset($_POST['nuevo_telefono']) && isset($_POST['nueva_nacionalidad']) && isset($_POST['nueva_fecha_nac']) && isset($_POST['nuevo_codigo_tc'])) {
    $pasaporte_mod = $_POST['pasaporte_mod'];
    $nuevo_correo = $_POST['nuevo_correo'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_apellido = $_POST['nuevo_apellido'];
    $nuevo_telefono = $_POST['nuevo_telefono'];
    $nueva_nacionalidad = $_POST['nueva_nacionalidad'];
    $nueva_fecha_nac = $_POST['nueva_fecha_nac'];
    $nuevo_codigo_tc = $_POST['nuevo_codigo_tc'];
    
    ModificarCliente($pasaporte_mod, $nuevo_correo, $nuevo_nombre, $nuevo_apellido, $nuevo_telefono, $nueva_nacionalidad, $nueva_fecha_nac, $nuevo_codigo_tc);
}

// Procesar formulario de eliminar cliente
if (isset($_POST['pasaporte_elim'])) {
    $pasaporte_elim = $_POST['pasaporte_elim'];
    
    EliminarCliente($pasaporte_elim);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administrar Clientes</title>
</head>
<body>
    <h2>Ingresar Cliente</h2>
    <form method="POST" action="cliente.php">
        <label for="pasaporte">Pasaporte:</label>
        <input type="number" name="pasaporte" required>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>
        <br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <br>
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required>
        <br>
        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" required>
        <br>
        <label for="nacionalidad">Nacionalidad:</label>
        <input type="text" name="nacionalidad" required>
        <br>
        <label for="fecha_nac">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nac" required>
        <br>
        <label for="codigo_tc">Código Tipo Cliente:</label>
        <input type="number" name="codigo_tc" required>
        <br>
        <input type="submit" value="Ingresar Cliente">
    </form>

    <h2>Modificar Cliente</h2>
    <form method="POST" action="cliente.php">
        <label for="pasaporte_mod">Pasaporte:</label>
        <input type="number" name="pasaporte_mod" required>
        <br>
        <label for="nuevo_correo">Nuevo Correo:</label>
        <input type="email" name="nuevo_correo" required>
        <br>
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" name="nuevo_nombre" required>
        <br>
        <label for="nuevo_apellido">Nuevo Apellido:</label>
        <input type="text" name="nuevo_apellido" required>
        <br>
        <label for="nuevo_telefono">Nuevo Teléfono:</label>
        <input type="tel" name="nuevo_telefono" required>
        <br>
        <label for="nueva_nacionalidad">Nueva Nacionalidad:</label>
        <input type="text" name="nueva_nacionalidad" required>
        <br>
        <label for="nueva_fecha_nac">Nueva Fecha de Nacimiento:</label>
        <input type="date" name="nueva_fecha_nac" required>
        <br>
        <label for="nuevo_codigo_tc">Nuevo Código Tipo Cliente:</label>
        <input type="number" name="nuevo_codigo_tc" required>
        <br>
        <input type="submit" value="Modificar Cliente">
    </form>

    <h2>Eliminar Cliente</h2>
    <form method="POST" action="cliente.php">
        <label for="pasaporte_elim">Pasaporte:</label>
        <input type="number" name="pasaporte_elim" required>
        <br>
        <input type="submit" value="Eliminar Cliente">
    </form>

    <h2>Tabla Cliente</h2>
    <?php

    
    // Mostrar tabla Cliente
    $conn = CConexion::ConexionBD();
    if ($conn) {
        $query = "SELECT * FROM Cliente";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($clientes)) {
            echo "<table>";
            echo "<tr>";
            foreach ($clientes[0] as $column => $value) {
                echo "<th>$column</th>";
            }
            echo "</tr>";
            
            foreach ($clientes as $cliente) {
                echo "<tr>";
                foreach ($cliente as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "No se encontraron registros en la tabla Cliente.";
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
    ?>
</body>
</html>
