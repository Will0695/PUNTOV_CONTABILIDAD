<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión primero.";
    exit();
}

include 'db.php';

// Verificar el rol del usuario y obtener permisos
$rol = $_SESSION['rol'];
$permisos = [];

// Consultar los permisos del rol actual en la base de datos
$sql = "SELECT ventana FROM permisos WHERE rol = '$rol'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $permisos[] = $row['ventana'];
    }
}

// Función para verificar permisos específicos
function tienePermiso($permiso) {
    global $permisos;
    return in_array($permiso, $permisos);
}
?>
