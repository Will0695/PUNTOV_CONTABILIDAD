<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fecha = $_POST['fecha'];
    $forma_pago = $_POST['forma_pago'];
    $monto = $_POST['monto'];
    $numero_referencia = $_POST['numero_referencia'];
    $banco_id = $_POST['banco_id'];
    $cliente_id = $_POST['cliente_id'];

    $query = "UPDATE pagos 
              SET fecha = '$fecha', forma_pago = '$forma_pago', monto = $monto, 
                  numero_referencia = '$numero_referencia', banco_id = $banco_id, cliente_id = $cliente_id 
              WHERE id = $id";

    if ($conn->query($query)) {
        echo "Pago actualizado correctamente.";
    } else {
        echo "Error al actualizar el pago: " . $conn->error;
    }
}
?>
