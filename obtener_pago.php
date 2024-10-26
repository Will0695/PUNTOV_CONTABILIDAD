<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM pagos WHERE id = $id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $pago = $result->fetch_assoc();
        echo json_encode($pago);
    } else {
        echo json_encode(['error' => 'Pago no encontrado']);
    }
}
?>
