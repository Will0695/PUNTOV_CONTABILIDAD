<?php
include 'db.php';

function obtenerClientesActivos() {
    global $conn;
    $sql = "SELECT * FROM clientes WHERE estado = 'A'";
    $result = $conn->query($sql);

    if (!$result) {
        echo "Error en la consulta: " . $conn->error;
        exit();
    }

    return $result;
}
?>
