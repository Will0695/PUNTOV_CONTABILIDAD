<?php
include 'db.php'; // Asegúrate de que esta ruta sea correcta para la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    // Validar que los campos no estén vacíos
    if (empty($nombre_usuario) || empty($contrasena) || empty($rol)) {
        echo "Error: Todos los campos son obligatorios.";
        exit();
    }

    // Hashear la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

    // Preparar la consulta para insertar el nuevo usuario
    $sql = "INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre_usuario, $contrasena_hash, $rol);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a admin_dashboard.php después de crear el usuario
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error al crear el usuario: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
