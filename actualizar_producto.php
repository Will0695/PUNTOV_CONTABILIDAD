<?php
include 'db.php'; // Asegúrate de que la conexión a la base de datos está incluida

// Verificar si se recibieron todos los datos necesarios
if (isset($_POST['id'], $_POST['codigo_producto'], $_POST['descripcion'], $_POST['precio_unitario'], $_POST['impuestos'], $_POST['numero_serie'])) {
    // Sanitizar y asignar los datos recibidos
    $id = $conn->real_escape_string($_POST['id']);
    $codigo_producto = $conn->real_escape_string($_POST['codigo_producto']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio_unitario = $conn->real_escape_string($_POST['precio_unitario']);
    $impuestos = $conn->real_escape_string($_POST['impuestos']);
    $numero_serie = $conn->real_escape_string($_POST['numero_serie']);

    // Actualizar el producto en la base de datos
    $query = "UPDATE productos SET 
                codigo_producto = '$codigo_producto',
                descripcion = '$descripcion',
                precio_unitario = '$precio_unitario',
                impuestos = '$impuestos',
                numero_serie = '$numero_serie'
              WHERE id = '$id'";

    if ($conn->query($query)) {
        echo "Producto actualizado exitosamente.";
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
} else {
    echo "Datos incompletos. No se pudo actualizar el producto.";
}
?>
