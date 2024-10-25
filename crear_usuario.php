<?php
include 'db.php'; // Conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    // Validar que el nombre de usuario y correo sean únicos
    $nombre_usuario = $conn->real_escape_string($nombre_usuario);
    $correo = $conn->real_escape_string($correo);
    $contrasena = $conn->real_escape_string($contrasena);
    $rol = $conn->real_escape_string($rol);
    $estado = $conn->real_escape_string($estado);

    // Consultar si ya existe el nombre de usuario o el correo
    $check_user_sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' OR correo = '$correo'";
    $check_user_result = $conn->query($check_user_sql);

    if ($check_user_result->num_rows > 0) {
        echo "El nombre de usuario o correo ya existe.";
    } else {
        // Insertar nuevo usuario
        $sql = "INSERT INTO usuarios (nombre_usuario, correo, contrasena, rol, estado)
                VALUES ('$nombre_usuario', '$correo', '$contrasena', '$rol', '$estado')";

        if ($conn->query($sql) === TRUE) {
            echo "Usuario creado exitosamente.";
        } else {
            echo "Error al crear el usuario: " . $conn->error;
        }
    }

    // Cerrar conexión
    $conn->close();
}
?>
