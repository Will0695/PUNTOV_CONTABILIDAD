<?php
include 'db.php';

// Verificar que se ha recibido el ID del cliente
if (isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);

    // Actualizar el estado del cliente a "I" para inactivo
    $sql = "UPDATE clientes SET estado = 'I' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Cliente desactivado exitosamente.";
    } else {
        echo "Error al desactivar el cliente: " . $conn->error;
    }
} else {
    echo "ID de cliente no proporcionado.";
}

$conn->close();
