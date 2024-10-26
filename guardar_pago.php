<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $forma_pago = $_POST['forma_pago'];
    $monto = $_POST['monto'];
    $numero_referencia = $_POST['numero_referencia'];
    $banco_id = $_POST['banco_id'];
    $cliente_id = $_POST['cliente_id'];

    $query = "INSERT INTO pagos (fecha, forma_pago, monto, numero_referencia, banco_id, cliente_id) 
              VALUES ('$fecha', '$forma_pago', $monto, '$numero_referencia', $banco_id, $cliente_id)";

    if ($conn->query($query)) {
        echo "Pago guardado correctamente.";
    } else {
        echo "Error al guardar el pago: " . $conn->error;
    }
}
?>
