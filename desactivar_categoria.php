<?php
include 'db.php'; // Conexión a la base de datos

// Verificar si se recibió el ID
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Cambiar el estado de la categoría a 'inactiva' (suponiendo que tienes un campo estado)
    $query = "UPDATE categorias SET estado = 'inactiva' WHERE id = $id";
    if ($conn->query($query)) {
        echo "Categoría desactivada exitosamente.";
    } else {
        echo "Error al desactivar la categoría: " . $conn->error;
    }
} else {
    echo "ID de categoría no especificado.";
}

$conn->close();
?>
