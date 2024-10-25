<?php
// Iniciar la sesión
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión primero.";
    exit();
}

// Incluir la conexión a la base de datos
include 'db.php';

$id_cliente = $_GET['id'];

// Obtener los datos del cliente
$sql = "SELECT * FROM clientes WHERE id='$id_cliente'";
$result = $conn->query($sql);
$cliente = $result->fetch_assoc();

// Editar el cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $sexo = $_POST['sexo'];
    $nit = $_POST['nit'];
    $cui = $_POST['cui'];
    $seguro_medico = $_POST['seguro_medico'];
    $numero_poliza = $_POST['numero_poliza'];

    $sql = "UPDATE clientes SET 
            nombre='$nombre', direccion='$direccion', telefono='$telefono', correo='$correo', 
            sexo='$sexo', NIT='$nit', CUI='$cui', seguro_medico='$seguro_medico', numero_poliza='$numero_poliza'
            WHERE id='$id_cliente'";

    if ($conn->query($sql)) {
        echo "Cliente actualizado exitosamente.";
        header("Location: gestionar_clientes.php");
    } else {
        echo "Error al actualizar cliente: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Editar Cliente</h1>
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $cliente['direccion']; ?>" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $cliente['correo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="sexo">Sexo:</label>
            <select class="form-control" id="sexo" name="sexo">
                <option value="M" <?php if ($cliente['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
                <option value="F" <?php if ($cliente['sexo'] == 'F') echo 'selected'; ?>>Femenino</option>
            </select>
        </div>
        <div class="form-group">
            <label for="nit">NIT:</label>
            <input type="text" class="form-control" id="nit" name="nit" value="<?php echo $cliente['NIT']; ?>" required>
        </div>
        <div class="form-group">
            <label for="cui">CUI:</label>
            <input type="text" class="form-control" id="cui" name="cui" value="<?php echo $cliente['CUI']; ?>">
        </div>
        <div class="form-group">
            <label for="seguro_medico">Seguro Médico:</label>
            <input type="text" class="form-control" id="seguro_medico" name="seguro_medico" value="<?php echo $cliente['seguro_medico']; ?>">
        </div>
        <div class="form-group">
            <label for="numero_poliza">Número de Póliza:</label>
            <input type="text" class="form-control" id="numero_poliza" name="numero_poliza" value="<?php echo $cliente['numero_poliza']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
