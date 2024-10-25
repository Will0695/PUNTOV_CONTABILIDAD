<?php
session_start();
include 'db.php'; // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los valores del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Evitar inyección SQL
    $nombre_usuario = $conn->real_escape_string($nombre_usuario);

    // Consultar si el usuario existe y está activo
    $sql = "SELECT id, contrasena, rol, estado FROM usuarios WHERE LOWER(nombre_usuario) = LOWER('$nombre_usuario') AND estado = 'A'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña usando password_verify
        if (password_verify($contrasena, $row['contrasena'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['usuario'] = $nombre_usuario;
            $_SESSION['rol'] = $row['rol'];

            // Redirigir según el rol del usuario
            if ($row['rol'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($row['rol'] == 'vendedor') {
                header("Location: vendedor_dashboard.php");
            } else {
                header("Location: contador_dashboard.php");
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado o inactivo.";
    }
}

$conn->close();
?>
