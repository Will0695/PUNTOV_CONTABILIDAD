<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión primero.";
    exit();
}

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

// Consultar la lista de clientes
$sql_clientes = "SELECT * FROM clientes WHERE estado = 'A'";
$result_clientes = $conn->query($sql_clientes);

// Verificar si la consulta ha fallado
if (!$result_clientes) {
    echo "Error en la consulta: " . $conn->error;
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Gestionar Clientes</title>
</head>
<body>
    <div class="container">
        <h3>Lista de Clientes</h3>
        
        <!-- Mostrar la tabla de clientes -->
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
                <?php if ($result_clientes->num_rows > 0) { ?>
                    <?php while ($cliente = $result_clientes->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $cliente['nombre']; ?></td>
                            <td><?php echo $cliente['direccion']; ?></td>
                            <td><?php echo $cliente['telefono']; ?></td>
                            <td><?php echo $cliente['correo']; ?></td>
                            <td><?php echo $cliente['NIT']; ?></td>
                            <td>
                                <!-- Botón para editar cliente -->
                                <button class="btn btn-info btn-sm">Editar</button>
                                <!-- Botón para desactivar cliente -->
                                <button class="btn btn-danger btn-sm">Desactivar</button>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6">No hay clientes registrados.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Formulario para agregar un nuevo cliente -->
        <h4>Agregar Cliente</h4>
        <form method="POST" action="agregar_cliente.php">
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
                <label for="nit">NIT:</label>
                <input type="text" class="form-control" id="nit" name="nit" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Cliente</button>
        </form>
    </div>
</body>
</html>
