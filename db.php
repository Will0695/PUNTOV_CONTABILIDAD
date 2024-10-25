<?php
$servername = "localhost";  // Cambia según tu configuración
$username = "root";         // Cambia según tu configuración
$password = "";             // Cambia según tu configuración
$dbname = "PuntoVentaContabilidad";  // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
