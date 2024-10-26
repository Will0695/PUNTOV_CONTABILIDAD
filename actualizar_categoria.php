<?php
include 'db.php'; // Conexión a la base de datos

// Verificar si se recibió el ID y el nuevo nombre
if (isset($_POST['id']) && isset($_POST['nombre'])) {
    $id = intval($_POST['id']);
    $nombre = $conn->real_escape_string($_POST['nombre']);

    // Actualizar el nombre de la categoría en la base de datos
    $query = "UPDATE categorias SET nombre = '$nombre' WHERE id = $id";
    if ($conn->query($query)) {
        echo "Categoría actualizada exitosamente.";
    } else {
        echo "Error al actualizar la categoría: " . $conn->error;
    }
} else {
    echo "Datos insuficientes para actualizar la categoría.";
}

$conn->close();
?>
