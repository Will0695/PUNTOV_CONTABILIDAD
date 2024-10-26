<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "DELETE FROM ventas WHERE id = $id";
    if ($conn->query($query)) {
        echo "Venta eliminada exitosamente.";
    } else {
        echo "Error al eliminar la venta: " . $conn->error;
    }
} else {
    echo "ID de venta no especificado.";
}

$conn->close();
?>
