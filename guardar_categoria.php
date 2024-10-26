<?php
include 'db.php'; // Asegúrate de que esta ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO categorias (nombre) VALUES (?)";
    $stmt = $conn->prepare($sql); // Asegúrate de que esté usando $conn o $conexion, según tu configuración
    $stmt->bind_param("s", $nombre);

   // guardar_categoria.php
if ($stmt->execute()) {
    header("Location: productos.php?status=success&type=categoria");
    exit();
}


    $stmt->close();
    $conn->close();
}
?>
