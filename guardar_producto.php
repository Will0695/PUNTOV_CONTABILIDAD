<?php
include 'db.php'; // Asegúrate de que esta ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_producto = $_POST['codigo_producto'];
    $descripcion = $_POST['descripcion'];
    $precio_unitario = $_POST['precio_unitario'];
    $impuestos = $_POST['impuestos'];
    $numero_serie = $_POST['numero_serie'];
    $categoria_id = $_POST['categoria_id'];

    $sql = "INSERT INTO productos (codigo_producto, descripcion, precio_unitario, impuestos, numero_serie, categoria_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddsi", $codigo_producto, $descripcion, $precio_unitario, $impuestos, $numero_serie, $categoria_id);

    // guardar_producto.php
if ($stmt->execute()) {
    header("Location: productos.php?status=success&type=producto");
    exit();
}


    $stmt->close();
    $conn->close();
}
?>
