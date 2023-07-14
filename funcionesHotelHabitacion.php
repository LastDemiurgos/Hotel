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

// Función para ingresar un hotel
function IngresarHotel($codigo_h, $nombre, $direccion, $ciudad) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO Hotel (Codigo_H, Nombre, Direccion, Ciudad) VALUES (?, ?, ?, ?)");
            $stmt->execute([$codigo_h, $nombre, $direccion, $ciudad]);
            
            echo "Hotel ingresado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al ingresar el hotel: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para modificar un hotel
function ModificarHotel($hotel_codigo_h, $hotel_nombre, $hotel_direccion, $hotel_ciudad) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("UPDATE Hotel SET Nombre = ?, Direccion = ?, Ciudad = ? WHERE Codigo_H = ?");
            $stmt->execute([$hotel_nombre, $hotel_direccion, $hotel_ciudad, $hotel_codigo_h]);
            
            echo "Hotel modificado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al modificar el hotel: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para eliminar un hotel
function EliminarHotel($codigo_h) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("DELETE FROM Hotel WHERE Codigo_H = ?");
            $stmt->execute([$codigo_h]);
            
            echo "Hotel eliminado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al eliminar el hotel: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para ingresar una habitación
function IngresarHabitacion($codigo_ha, $precio, $codigo_h, $codigo_th) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO Habitacion (Codigo_HA, Precio, Codigo_H, Codigo_TH) VALUES (?, ?, ?, ?)");
            $stmt->execute([$codigo_ha, $precio, $codigo_h, $codigo_th]);
            
            echo "Habitación ingresada exitosamente.";
        } catch (PDOException $e) {
            echo "Error al ingresar la habitación: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para modificar una habitación
function ModificarHabitacion($codigo_ha_NUEVO, $precio_nuevo, $codigo_h_nuevo, $codigo_th_nuevo) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("UPDATE Habitacion SET Codigo_H = ?, Precio = ?, Codigo_TH = ? WHERE Codigo_HA = ?");
            $stmt->execute([$codigo_h_nuevo, $precio_nuevo, $codigo_th_nuevo, $codigo_ha_NUEVO]);
            
            echo "Habitación modificada exitosamente.";
        } catch (PDOException $e) {
            echo "Error al modificar la habitación: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para eliminar una habitación
function EliminarHabitacion($codigo_ha) {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("DELETE FROM Habitacion WHERE Codigo_HA = ?");
            $stmt->execute([$codigo_ha]);
            
            echo "Habitación eliminada exitosamente.";
        } catch (PDOException $e) {
            echo "Error al eliminar la habitación: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Función para ver las tablas
function VerTablas() {
    $conn = CConexion::ConexionBD();
    if ($conn) {
        try {
            $stmt = $conn->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            echo "Tablas existentes en la base de datos:<br>";
            foreach ($tables as $table) {
                echo $table . "<br>";
            }
        } catch (PDOException $e) {
            echo "Error al obtener las tablas: " . $e->getMessage();
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}

// Procesar formulario de ingresar hotel
if (isset($_POST['codigo_h'])) {
    $codigo_h = $_POST['codigo_h'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    
    IngresarHotel($codigo_h, $nombre, $direccion, $ciudad);
}

// Procesar formulario de modificar hotel
if (isset($_POST['hotel_codigo_h'])) {
    $hotel_codigo_h = $_POST['hotel_codigo_h'];
    $hotel_nombre = $_POST['hotel_nombre'];
    $hotel_direccion = $_POST['hotel_direccion'];
    $hotel_ciudad = $_POST['hotel_ciudad'];
    
    ModificarHotel($hotel_codigo_h, $hotel_nombre, $hotel_direccion, $hotel_ciudad);
}

// Procesar formulario de eliminar hotel
if (isset($_POST['codigo_h_elim'])) {
    $codigo_h_elim = $_POST['codigo_h_elim'];
    
    EliminarHotel($codigo_h_elim);
}

// Procesar formulario de ingresar habitación
if (isset($_POST['codigo_ha'])) {
    $codigo_ha = $_POST['codigo_ha'];
    $precio = $_POST['precio'];
    $codigo_h = $_POST['codigo_h'];
    $codigo_th = $_POST['codigo_th'];
    
    IngresarHabitacion($codigo_ha, $precio, $codigo_h, $codigo_th);
}

// Procesar formulario de modificar habitación
if (isset($_POST['codigo_ha_mod'])) {
    $codigo_ha_mod = $_POST['codigo_ha_mod'];
    $precio_mod = $_POST['precio_mod'];
    $codigo_h_nuevo = $_POST['codigo_h_nuevo'];
    $codigo_th_nuevo = $_POST['codigo_th_nuevo'];
    
    ModificarHabitacion($codigo_ha_mod, $precio_mod, $codigo_h_nuevo, $codigo_th_nuevo);
}

// Procesar formulario de eliminar habitación
if (isset($_POST['codigo_ha_elim'])) {
    $codigo_ha_elim = $_POST['codigo_ha_elim'];
    
    EliminarHabitacion($codigo_ha_elim);
}

// Procesar formulario de ver tablas
if (isset($_POST['ver_tablas'])) {
    VerTablas();
}

?>
