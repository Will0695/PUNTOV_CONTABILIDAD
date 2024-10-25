<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que todos los datos necesarios estén presentes
    if (!isset($_POST['nit_cliente']) || !isset($_POST['forma_pago']) || !isset($_POST['productos']) || !isset($_POST['total_general'])) {
        echo "Error: Uno o más datos necesarios no fueron enviados.";
        var_dump($_POST);
        exit();
    }

    $nit_cliente = $_POST['nit_cliente'];
    $forma_pago = $_POST['forma_pago'];
    $productos = json_decode($_POST['productos'], true);
    $total_general = $_POST['total_general'];

    if (empty($productos) || $total_general <= 0) {
        echo "Error: No se pueden procesar ventas sin productos o con un total inválido.";
        exit();
    }

    $numero_factura = 'F' . time();

    // Buscar el cliente por NIT usando una declaración preparada
    $sql_cliente = $conn->prepare("SELECT id FROM clientes WHERE NIT = ?");
    $sql_cliente->bind_param("s", $nit_cliente);
    $sql_cliente->execute();
    $result_cliente = $sql_cliente->get_result();

    if ($result_cliente->num_rows > 0) {
        $row_cliente = $result_cliente->fetch_assoc();
        $cliente_id = $row_cliente['id'];
    } else {
        echo "Cliente no encontrado.";
        exit();
    }

    $fecha_venta = date('Y-m-d H:i:s');
    $descuento = 0;
    $cuenta_corriente = ($forma_pago == 'credito') ? $total_general : 0;

    // Insertar la venta en la tabla `ventas`
    $sql_venta = $conn->prepare("INSERT INTO ventas (fecha, forma_pago, numero_factura, descuento, total, cliente_id, cuenta_corriente) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql_venta->bind_param("ssssdis", $fecha_venta, $forma_pago, $numero_factura, $descuento, $total_general, $cliente_id, $cuenta_corriente);

    if ($sql_venta->execute()) {
        $venta_id = $conn->insert_id;
        
        // Preparar la consulta para detalle_ventas
        $sql_detalle = $conn->prepare("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario) 
                                       VALUES (?, ?, ?, ?)");

        foreach ($productos as $producto) {
            $producto_id = $producto['id'];
            $cantidad = $producto['cantidad'];
            $precio_unitario = $producto['precio_unitario'];

            // Verificar que el producto exista en la base de datos
            $consulta_producto = $conn->prepare("SELECT id FROM productos WHERE id = ?");
            $consulta_producto->bind_param("i", $producto_id);
            $consulta_producto->execute();
            $resultado_producto = $consulta_producto->get_result();

            if ($resultado_producto->num_rows === 0) {
                echo "Error: El producto con ID $producto_id no existe en la base de datos.";
                exit();
            }

            // Insertar el detalle de la venta
            $sql_detalle->bind_param("iiid", $venta_id, $producto_id, $cantidad, $precio_unitario);

            if (!$sql_detalle->execute()) {
                echo "Error al guardar el detalle de la venta: " . $conn->error;
                exit();
            }
        }

        echo "Venta registrada exitosamente.";
    } else {
        echo "Error al registrar la venta: " . $conn->error;
    }

    $sql_cliente->close();
    $sql_venta->close();
    $sql_detalle->close();
    $conn->close();
}
?>
