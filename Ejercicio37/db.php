<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "ejercicio36";

$conn = mysqli_connect($host, $usuario, $contrasena, $base_datos);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>