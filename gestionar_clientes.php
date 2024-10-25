<?php
// Iniciar la sesión
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión primero.";
    exit();
}

// Incluir la conexión a la base de datos
include 'db.php';

// Verificar si el usuario tiene el rol adecuado para acceder a esta página
$rol = $_SESSION['rol'];
$permisos = [];

// Consultar los permisos del rol actual en la base de datos
$sql = "SELECT ventana FROM permisos WHERE rol = '$rol'";
$result = $conn->query($sql);

// Guardar los permisos en un array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $permisos[] = $row['ventana'];
    }
}

// Verificar si tiene permiso para gestionar clientes
if (!in_array('clientes', $permisos)) {
    echo "No tienes permisos para acceder a esta ventana.";
    exit();
}

// Agregar un nuevo cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_cliente'])) {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $sexo = $_POST['sexo'];
    $nit = $_POST['nit'];
    $cui = $_POST['cui'];
    $seguro_medico = $_POST['seguro_medico'];
    $numero_poliza = $_POST['numero_poliza'];

    $sql = "INSERT INTO clientes (nombre, direccion, telefono, correo, sexo, NIT, CUI, seguro_medico, numero_poliza) 
            VALUES ('$nombre', '$direccion', '$telefono', '$correo', '$sexo', '$nit', '$cui', '$seguro_medico', '$numero_poliza')";
    if ($conn->query($sql)) {
        echo "Cliente agregado exitosamente.";
    } else {
        echo "Error al agregar cliente: " . $conn->error;
    }
}

// Editar un cliente existente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar_cliente'])) {
    $id_cliente = $_POST['id_cliente'];
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
    } else {
        echo "Error al actualizar cliente: " . $conn->error;
    }
}

// Desactivar un cliente
if (isset($_GET['desactivar_cliente'])) {
    $id_cliente = $_GET['desactivar_cliente'];
    $sql = "UPDATE clientes SET estado='I' WHERE id='$id_cliente'";
    if ($conn->query($sql)) {
        echo "Cliente desactivado exitosamente.";
    } else {
        echo "Error al desactivar cliente: " . $conn->error;
    }
}

// Obtener lista de clientes
$sql = "SELECT * FROM clientes WHERE estado='A'";
$clientes = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Gestión de Clientes</h1>

    <!-- Formulario para agregar un nuevo cliente -->
    <h3>Agregar Cliente</h3>
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="form-group">
            <label for="sexo">Sexo:</label>
            <select class="form-control" id="sexo" name="sexo">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </div>
        <div class="form-group">
            <label for="nit">NIT:</label>
            <input type="text" class="form-control" id="nit" name="nit" required>
        </div>
        <div class="form-group">
            <label for="cui">CUI:</label>
            <input type="text" class="form-control" id="cui" name="cui">
        </div>
        <div class="form-group">
            <label for="seguro_medico">Seguro Médico:</label>
            <input type="text" class="form-control" id="seguro_medico" name="seguro_medico">
        </div>
        <div class="form-group">
            <label for="numero_poliza">Número de Póliza:</label>
            <input type="text" class="form-control" id="numero_poliza" name="numero_poliza">
        </div>
        <button type="submit" name="agregar_cliente" class="btn btn-primary">Agregar Cliente</button>
    </form>

    <!-- Tabla de clientes registrados -->
    <h3 class="mt-5">Clientes Registrados</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>NIT</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cliente = $clientes->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $cliente['nombre']; ?></td>
                <td><?php echo $cliente['direccion']; ?></td>
                <td><?php echo $cliente['telefono']; ?></td>
                <td><?php echo $cliente['correo']; ?></td>
                <td><?php echo $cliente['NIT']; ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>" class="btn btn-info">Editar</a>
                    <a href="gestionar_clientes.php?desactivar_cliente=<?php echo $cliente['id']; ?>" class="btn btn-danger">Desactivar</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
