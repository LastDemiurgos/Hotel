Configurar la conexión a la base de datos: En el archivo PHP, puedes utilizar la función pg_connect() 
para establecer la conexión con la base de datos de PostgreSQL. Asegúrate de proporcionar los detalles
 correctos de la base de datos, como el nombre de host, el puerto, el nombre de usuario, la contraseña 
 y el nombre de la base de datos.


 <?php
$host = 'localhost';
$port = '5432';
$dbname = 'nombre_base_de_datos';
$user = 'nombre_usuario';
$password = 'contraseña';

$db = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$db) {
    die('Error al conectar a la base de datos');
}
?>

Realizar consultas a la base de datos:
 Utiliza las funciones de PostgreSQL en PHP, como pg_query(), para ejecutar consultas 
 SQL en la base de datos. Puedes realizar consultas de selección (SELECT), inserción (INSERT), 
 actualización (UPDATE), eliminación (DELETE), entre otras.

 <?php
// Ejemplo de consulta SELECT
$query = "SELECT * FROM tabla";
$result = pg_query($db, $query);

if (!$result) {
    die('Error en la consulta');
}

// Obtener los resultados de la consulta
while ($row = pg_fetch_assoc($result)) {
    // Procesar los datos
    // ...
}

// Liberar el resultado
pg_free_result($result);
?>

Integrar la lógica de PHP en la página HTML: Puedes utilizar etiquetas PHP dentro del código 
HTML para integrar la lógica de PHP y mostrar los datos obtenidos de la base de datos en la página web.


<!DOCTYPE html>
<html>
<head>
    <title>Página web con PostgreSQL</title>
</head>
<body>
    <h1>Lista de usuarios</h1>

    <ul>
        <?php
        // Consulta para obtener la lista de usuarios
        $query = "SELECT * FROM usuarios";
        $result = pg_query($db, $query);

        if (!$result) {
            die('Error en la consulta');
        }

        // Mostrar los usuarios en la lista
        while ($row = pg_fetch_assoc($result)) {
            echo "<li>{$row['nombre']}</li>";
        }

        // Liberar el resultado
        pg_free_result($result);
        ?>
    </ul>
</body>
</html>
