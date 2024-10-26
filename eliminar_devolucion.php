<?php
include 'verificar_rol.php'; 
verificarPermiso(['admin', 'vendedor']);
include 'db.php'; // Conexión a la base de datos

// Verificar si se envió el ID de la devolución a eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Eliminar la devolución de la base de datos
    $query = "DELETE FROM devoluciones WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Devolución eliminada exitosamente.";
    } else {
        echo "Error al eliminar devolución: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Solicitud inválida.";
}
?>
