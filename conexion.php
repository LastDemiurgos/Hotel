<?php
$con = pg_connect("host=localhost port=5432 password=123456 user=juaramir dbname=postgres");
if(pg_ErrorMessage($con)){
	echo "<br>Error al conectarme</br>";


}
?>
