<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'contador') {
    header("Location: login.php");
    exit();
}
?>
<h1>Bienvenido, Contador</h1>
<p>Este es el panel de control del contador.</p>
<a href="logout.php">Cerrar sesión</a>
