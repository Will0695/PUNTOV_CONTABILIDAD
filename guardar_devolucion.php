<?php
include 'verificar_rol.php'; 
verificarPermiso(['admin', 'vendedor']);
include 'db.php'; // Conexión a la base de datos

// Verificar si se envió el formulario de nueva devolución
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $motivo = $_POST['motivo'];
    $venta_id = $_POST['venta_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Validar que todos los campos estén llenos
    if (empty($fecha) || empty($motivo) || empty($venta_id) || empty($producto_id) || empty($cantidad)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Insertar la nueva devolución en la base de datos
    $query = "INSERT INTO devoluciones (fecha, motivo, venta_id, producto_id, cantidad) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiii", $fecha, $motivo, $venta_id, $producto_id, $cantidad);

    if ($stmt->execute()) {
        echo "Devolución registrada exitosamente.";
    } else {
        echo "Error al registrar devolución: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}
?>
