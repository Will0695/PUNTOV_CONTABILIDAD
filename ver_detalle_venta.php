<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "SELECT * FROM ventas WHERE id = $id";
    $resultado = $conn->query($query);

    if ($resultado && $venta = $resultado->fetch_assoc()) {
        echo "<p><strong>Fecha:</strong> {$venta['fecha']}</p>";
        echo "<p><strong>Forma de Pago:</strong> {$venta['forma_pago']}</p>";
        echo "<p><strong>Número de Factura:</strong> {$venta['numero_factura']}</p>";
        echo "<p><strong>Descuento:</strong> {$venta['descuento']}</p>";
        echo "<p><strong>Total:</strong> {$venta['total']}</p>";
        echo "<p><strong>ID Cliente:</strong> {$venta['cliente_id']}</p>";
        echo "<p><strong>Cuenta Corriente:</strong> {$venta['cuenta_corriente']}</p>";
    } else {
        echo "Error al obtener detalles de la venta.";
    }
}
$conn->close();
?>
