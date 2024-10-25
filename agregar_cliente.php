<?php
session_start();
include 'db.php'; // Asegúrate de que la conexión a la base de datos está incluida

// Verificar si el usuario tiene el rol adecuado
if (!isset($_SESSION['usuario']) || !in_array('clientes', $_SESSION['permisos'])) {
    echo "No tienes permisos para agregar clientes.";
    exit();
}

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $nit = $conn->real_escape_string($_POST['nit']);

    // Insertar el nuevo cliente en la base de datos
    $sql = "INSERT INTO clientes (nombre, direccion, telefono, correo, NIT, estado) VALUES ('$nombre', '$direccion', '$telefono', '$correo', '$nit', 'A')";

    if ($conn->query($sql)) {
        // Redirigir de vuelta a la página de gestión de clientes
        header("Location: clientes.php");
        exit();
    } else {
        // Mostrar el error si ocurre
        echo "Error al agregar cliente: " . $conn->error;
    }
} else {
    echo "Solicitud no válida.";
}
?>
