<?php
// Verifica si la sesión ya está iniciada antes de llamar a session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Función para verificar el rol y los permisos
function verificarPermiso($rolesPermitidos) {
    if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $rolesPermitidos)) {
        echo "No tienes permisos para acceder a esta sección.";
        exit();
    }
}
?>
