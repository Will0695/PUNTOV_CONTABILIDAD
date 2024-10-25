<?php
include 'db.php'; // Incluir la conexión a la base de datos

// Cifrar las contraseñas antes de insertarlas
$contrasena_admin = password_hash('admin123', PASSWORD_DEFAULT);
$contrasena_vendedor = password_hash('vendedor123', PASSWORD_DEFAULT);
$contrasena_contador = password_hash('contador123', PASSWORD_DEFAULT);

// Insertar usuarios con contraseñas cifradas
$sql = "INSERT INTO usuarios (nombre_usuario, correo, contrasena, rol, estado)
        VALUES 
        ('admin01', 'admin@punto.com', '$contrasena_admin', 'admin', 'A'),
        ('vendedor01', 'vendedor@punto.com', '$contrasena_vendedor', 'vendedor', 'A'),
        ('contador01', 'contador@punto.com', '$contrasena_contador', 'contador', 'A')";

if ($conn->query($sql) === TRUE) {
    echo "Usuarios creados correctamente con contraseñas cifradas.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
