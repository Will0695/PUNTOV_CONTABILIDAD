<?php
include 'db.php';

if (isset($_POST['nit_cliente'])) {
    $nit_cliente = $conn->real_escape_string($_POST['nit_cliente']);

    // Consultar los clientes cuyo NIT coincida parcialmente
    $sql = "SELECT nombre, NIT FROM clientes WHERE NIT LIKE '%$nit_cliente%' AND estado = 'A' LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar sugerencias con nombre y NIT en formato JSON para manejar fácilmente ambos campos
        while ($row = $result->fetch_assoc()) {
            echo '<a href="#" class="list-group-item list-group-item-action sugerencia-item" data-nit="'.$row['NIT'].'" data-nombre="'.$row['nombre'].'">'.$row['nombre'].' ('.$row['NIT'].')</a>';
        }
    } else {
        echo '<a href="#" class="list-group-item list-group-item-action disabled">No se encontraron coincidencias</a>';
    }
}
?>
