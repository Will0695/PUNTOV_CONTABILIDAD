<?php
include 'db.php'; // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nit_cliente = $_POST['nit_cliente'];
    $forma_pago = $_POST['forma_pago'];
    $productos = json_decode($_POST['productos'], true); // Decodificar los productos enviados como JSON
    $total_general = $_POST['total_general'];
    
    // Generar un número de factura
    $numero_factura = 'F' . time(); // Número de factura generado automáticamente

    // Buscar el cliente por NIT
    $sql_cliente = "SELECT id FROM clientes WHERE NIT = '$nit_cliente'";
    $result_cliente = $conn->query($sql_cliente);
    if ($result_cliente->num_rows > 0) {
        $row_cliente = $result_cliente->fetch_assoc();
        $cliente_id = $row_cliente['id'];
    } else {
        echo "Cliente no encontrado.";
        exit();
    }

    // Insertar la venta en la tabla `ventas`
    $fecha_venta = date('Y-m-d H:i:s');
    $descuento = 0; // Puedes agregar lógica para manejar descuentos
    $cuenta_corriente = ($forma_pago == 'credito') ? $total_general : 0;

    $sql_venta = "INSERT INTO ventas (fecha, forma_pago, numero_factura, descuento, total, cliente_id, cuenta_corriente) 
                  VALUES ('$fecha_venta', '$forma_pago', '$numero_factura', '$descuento', '$total_general', '$cliente_id', '$cuenta_corriente')";

    if ($conn->query($sql_venta) === TRUE) {
        // Obtener el ID de la venta que se acaba de insertar
        $venta_id = $conn->insert_id;

        // Insertar los productos en el detalle de la venta
        foreach ($productos as $producto) {
            $producto_id = $producto['id'];
            $cantidad = $producto['cantidad'];
            $precio_unitario = $producto['precio_unitario'];

            $sql_detalle = "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario) 
                            VALUES ('$venta_id', '$producto_id', '$cantidad', '$precio_unitario')";

            if (!$conn->query($sql_detalle)) {
                echo "Error al guardar el detalle de la venta: " . $conn->error;
                exit();
            }
        }

        echo "Venta registrada exitosamente.";
    } else {
        echo "Error al registrar la venta: " . $conn->error;
    }

    $conn->close();
}
?>
