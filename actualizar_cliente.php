<?php
include 'db.php';

// Verificar si se han enviado los datos necesarios
if (isset($_POST['id'], $_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['correo'], $_POST['sexo'], $_POST['nit'], $_POST['cui'], $_POST['seguro_medico'], $_POST['numero_poliza'])) {
    
    // Obtener y limpiar los datos recibidos
    $id = $conn->real_escape_string($_POST['id']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $nit = $conn->real_escape_string($_POST['nit']);
    $cui = $conn->real_escape_string($_POST['cui']);
    $seguro_medico = $conn->real_escape_string($_POST['seguro_medico']);
    $numero_poliza = $conn->real_escape_string($_POST['numero_poliza']);

    // Consulta SQL para actualizar el cliente en la base de datos
    $sql = "UPDATE clientes SET 
                nombre = '$nombre', 
                direccion = '$direccion', 
                telefono = '$telefono', 
                correo = '$correo', 
                sexo = '$sexo', 
                NIT = '$nit', 
                CUI = '$cui', 
                seguro_medico = '$seguro_medico', 
                numero_poliza = '$numero_poliza' 
            WHERE id = '$id'";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Cliente actualizado exitosamente.";
    } else {
        echo "Error al actualizar el cliente: " . $conn->error;
    }
} else {
    echo "Datos incompletos para actualizar el cliente.";
}

$conn->close();
