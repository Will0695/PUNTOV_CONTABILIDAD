<?php
session_start();
include 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión primero.";
    exit();
}

// Asignar permisos básicos según el rol (esto es temporal y debe moverse al sistema de autenticación)
if (!isset($_SESSION['permisos'])) {
    if ($_SESSION['rol'] === 'vendedor') {
        $_SESSION['permisos'] = ['clientes', 'productos', 'ventas']; // Permisos básicos del vendedor
    } elseif ($_SESSION['rol'] === 'admin') {
        $_SESSION['permisos'] = ['clientes', 'productos', 'ventas', 'devoluciones', 'pagos', 'inventarios', 'respaldos'];
    } elseif ($_SESSION['rol'] === 'contador') {
        $_SESSION['permisos'] = ['devoluciones', 'pagos'];
    }
}

// Verificar si el usuario tiene el permiso adecuado para agregar clientes
if (!isset($_SESSION['permisos']) || !is_array($_SESSION['permisos']) || !in_array('clientes', $_SESSION['permisos'])) {
    echo "No tienes permisos para agregar clientes.";
    exit();
}

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recolectar y limpiar los datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $nit = $conn->real_escape_string($_POST['nit']);
    $cui = $conn->real_escape_string($_POST['cui']);
    $seguro_medico = $conn->real_escape_string($_POST['seguro_medico']);
    $numero_poliza = $conn->real_escape_string($_POST['numero_poliza']);

    // Insertar el nuevo cliente en la base de datos con todos los campos
    $sql = "INSERT INTO clientes (nombre, direccion, telefono, correo, sexo, NIT, CUI, seguro_medico, numero_poliza, estado) 
            VALUES ('$nombre', '$direccion', '$telefono', '$correo', '$sexo', '$nit', '$cui', '$seguro_medico', '$numero_poliza', 'A')";

    if ($conn->query($sql)) {
        // Redirigir de vuelta a la página de gestión de clientes
        header("Location: clientes.php");
        exit();
    } else {
        // Mostrar el error si ocurre
        echo "Error al agregar cliente: " . $conn->error;
    }
} else {
    echo "Solicitud no válida.";
}
?>
