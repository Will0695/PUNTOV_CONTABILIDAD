<?php
include 'db.php';

if (isset($_POST['producto'])) {
    $producto = $conn->real_escape_string($_POST['producto']);

    // Consultar productos por descripción, código de producto y obtener el precio unitario
    $sql = "SELECT descripcion, codigo_producto, precio_unitario FROM productos WHERE descripcion LIKE '%$producto%' OR codigo_producto LIKE '%$producto%' LIMIT 5";
    $result = $conn->query($sql);

    // Verificar si la consulta falló
    if (!$result) {
        // Mostrar el error de la consulta SQL
        echo "Error en la consulta: " . $conn->error;
        exit();
    }

    if ($result->num_rows > 0) {
        // Mostrar las sugerencias en formato HTML
        while ($row = $result->fetch_assoc()) {
            echo '<a href="#" class="list-group-item list-group-item-action sugerencia-item-producto" 
                   data-nombre="'.$row['descripcion'].'" 
                   data-codigo="'.$row['codigo_producto'].'" 
                   data-precio="'.$row['precio_unitario'].'">'
                   .$row['descripcion'].' ('.$row['codigo_producto'].')</a>';
        }
    } else {
        echo '<a href="#" class="list-group-item list-group-item-action disabled">No se encontraron coincidencias</a>';
    }
}
?>
