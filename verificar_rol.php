<?php
function verificarPermiso($rolesPermitidos) {
    session_start();
    if (!isset($_SESSION['rol'])) {
        // Redirigir al login si el rol no está definido
        header("Location: login.php");
        exit();
    }

    // Verificar si el rol del usuario está en la lista de roles permitidos
    if (!in_array($_SESSION['rol'], $rolesPermitidos)) {
        echo "No tienes permisos para acceder a esta página.";
        exit();
    }
}
?>
