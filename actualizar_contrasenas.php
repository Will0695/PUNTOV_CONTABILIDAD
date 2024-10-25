<?php
include 'db.php'; // Incluir la conexión a la base de datos

// Seleccionar los usuarios que tienen contraseñas no cifradas
$sql = "SELECT id, contrasena FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Cifrar la contraseña existente
        $id_usuario = $row['id'];
        $contrasena_cifrada = password_hash($row['contrasena'], PASSWORD_DEFAULT);

        // Actualizar la contraseña cifrada en la base de datos
        $update_sql = "UPDATE usuarios SET contrasena = '$contrasena_cifrada' WHERE id = $id_usuario";
        if ($conn->query($update_sql) === TRUE) {
            echo "Contraseña para el usuario con ID $id_usuario actualizada correctamente.<br>";
        } else {
            echo "Error al actualizar la contraseña para el usuario con ID $id_usuario: " . $conn->error . "<br>";
        }
    }
} else {
    echo "No se encontraron usuarios en la base de datos.";
}

$conn->close();
?>
