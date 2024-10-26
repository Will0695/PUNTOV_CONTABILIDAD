<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM pagos WHERE id = $id";

    if ($conn->query($query)) {
        echo "Pago eliminado correctamente.";
    } else {
        echo "Error al eliminar el pago: " . $conn->error;
    }
}
?>
