<?php
function verificarPermisoVentana($rol, $ventana) {
    include 'db.php'; // Conectar a la base de datos

    $sql = "SELECT * FROM permisos WHERE rol = '$rol' AND ventana = '$ventana'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "No tienes permisos para acceder a esta ventana.";
        exit();
    }
}
?>
