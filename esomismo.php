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
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
            return null;
        }
    }
}

// Función para obtener la información de un hotel
function ObtenerHotel($codigo_h) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM Hotel WHERE Codigo_H = ?");
            $stmt->execute([$codigo_h]);
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $hotel;
        } catch (PDOException $e) {
            echo "Error al obtener la información del hotel: " . $e->getMessage();
            return null;
        }
    } else {
        echo "Error al conectar a la base de datos.";
        return null;
    }
}

// Función para obtener la información de un recepcionista
function ObtenerRecepcionista($rut_r) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM Recepcionista WHERE Rut_R = ?");
            $stmt->execute([$rut_r]);
            $recepcionista = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $recepcionista;
        } catch (PDOException $e) {
            echo "Error al obtener la información del recepcionista: " . $e->getMessage();
            return null;
        }
    } else {
        echo "Error al conectar a la base de datos.";
        return null;
    }
}

// Función para obtener las habitaciones de un hotel
function ObtenerHabitacionesHotel($codigo_h) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM Habitacion WHERE Codigo_H = ?");
            $stmt->execute([$codigo_h]);
            $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $habitaciones;
        } catch (PDOException $e) {
            echo "Error al obtener las habitaciones del hotel: " . $e->getMessage();
            return null;
        }
    } else {
        echo "Error al conectar a la base de datos.";
        return null;
    }
}

// Función para obtener la información de un cliente por su pasaporte
function ObtenerCliente($pasaporte) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM Cliente WHERE Pasaporte = ?");
            $stmt->execute([$pasaporte]);
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $cliente;
        } catch (PDOException $e) {
            echo "Error al obtener la información del cliente: " . $e->getMessage();
            return null;
        }
    } else {
        echo "Error al conectar a la base de datos.";
        return null;
    }
}

// Función para ingresar una estadia de un cliente en un hotel
function IngresarEstadia($codigo_h, $rut_r, $codigo_ha, $fecha_ingreso, $fecha_salida) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO Reservar (Fecha_Ingreso, Fecha_Salida, Pasaporte, Codigo_HA) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fecha_ingreso, $fecha_salida, $_POST['pasaporte'], $codigo_ha]);
            
            echo "Estadia ingresada exitosamente.";
        } catch (PDOException $e) {
            echo "Error al ingresar la estadia: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para verificar si un cliente ha excedido el límite de 3 habitaciones en un periodo de tiempo
function VerificarLimiteHabitaciones($pasaporte, $fecha_ingreso, $fecha_salida) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM Reservar WHERE Pasaporte = ? AND ((Fecha_Ingreso <= ? AND Fecha_Salida >= ?) OR (Fecha_Ingreso >= ? AND Fecha_Ingreso <= ?))");
            $stmt->execute([$pasaporte, $fecha_ingreso, $fecha_salida, $fecha_ingreso, $fecha_salida]);
            $count = $stmt->fetchColumn();
            
            return $count >= 3;
        } catch (PDOException $e) {
            echo "Error al verificar el límite de habitaciones: " . $e->getMessage();
            return false;
        }
    } else {
        echo "Error al conectar a la base de datos.";
        return false;
    }
}

// Procesar formulario de ingresar estadia
if (isset($_POST['codigo_h']) && isset($_POST['rut_r']) && isset($_POST['codigo_ha']) && isset($_POST['fecha_ingreso']) && isset($_POST['fecha_salida'])) {
    $codigo_h = $_POST['codigo_h'];
    $rut_r = $_POST['rut_r'];
    $codigo_ha = $_POST['codigo_ha'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_salida = $_POST['fecha_salida'];
    
    $cliente = ObtenerCliente($_POST['pasaporte']);
    if ($cliente) {
        $nombre_cliente = isset($cliente['Nombre']) ? $cliente['Nombre'] : 'Nombre no disponible';
        $apellido_cliente = isset($cliente['Apellido']) ? $cliente['Apellido'] : 'Apellido no disponible';
        
        $hotel = ObtenerHotel($codigo_h);
        if ($hotel) {
            $nombre_hotel = $hotel['Nombre'];
            
            $recepcionista = ObtenerRecepcionista($rut_r);
            if ($recepcionista) {
                $nombre_recepcionista = $recepcionista['Nombre'];
                $apellido_recepcionista = $recepcionista['Apellido'];
                
                if (VerificarLimiteHabitaciones($_POST['pasaporte'], $fecha_ingreso, $fecha_salida)) {
                    echo "El cliente ha excedido el límite de 3 habitaciones en el periodo de tiempo especificado.";
                } else {
                    IngresarEstadia($codigo_h, $rut_r, $codigo_ha, $fecha_ingreso, $fecha_salida);
                }
            } else {
                echo "El recepcionista no existe.";
            }
        } else {
            echo "El hotel no existe.";
        }
    } else {
        echo "El cliente no existe.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ingresar Estadia</title>
</head>
<body>
    <h1>Ingresar Estadia</h1>
    <form method="POST" action="">
        <label for="pasaporte">Pasaporte del Cliente:</label>
        <input type="number" name="pasaporte" required><br><br>
        
        <label for="codigo_h">Código del Hotel:</label>
        <input type="number" name="codigo_h" required><br><br>
        
        <label for="rut_r">Rut del Recepcionista:</label>
        <input type="text" name="rut_r" required><br><br>
        
        <label for="codigo_ha">Código de la Habitación:</label>
        <input type="number" name="codigo_ha" required><br><br>
        
        <label for="fecha_ingreso">Fecha de Ingreso:</label>
        <input type="datetime-local" name="fecha_ingreso" required><br><br>
        
        <label for="fecha_salida">Fecha de Salida:</label>
        <input type="datetime-local" name="fecha_salida" required><br><br>
        
        <input type="submit" value="Ingresar Estadia">
    </form>
</body>
</html>
