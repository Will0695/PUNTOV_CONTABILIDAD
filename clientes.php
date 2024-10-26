<?php
include 'verificar_permisos.php';

// Verificar si el usuario tiene permiso para gestionar clientes
if (!tienePermiso('clientes')) {
    echo "No tienes permisos para acceder a esta ventana.";
    exit();
}

include 'obtener_clientes.php';
$result_clientes = obtenerClientesActivos();
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
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="vendedor_dashboard.php">Panel Vendedor</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="clientes.php">Nuevo Cliente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="productos.php">Nuevo Producto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php">Ventas</a>
                </li>

                <li class="nav-item">
                <a class="nav-link" href="opciones.php">Opciones</a></li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-danger text-white" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container my-4">
        <h1 class="text-center">Gestión de Clientes</h1>
        
        <!-- Sección para agregar un nuevo cliente -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Agregar Cliente</h4>
            </div>
            <div class="card-body">
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
                        <label for="sexo">Sexo:</label>
                        <select class="form-control" id="sexo" name="sexo">
                            <option value="">Seleccione</option>
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
                    <button type="submit" class="btn btn-primary">Agregar Cliente</button>
                </form>
            </div>
        </div>

        <!-- Sección para mostrar la lista de clientes -->
        <div class="card">
            <div class="card-header">
                <h3>Lista de Clientes</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Sexo</th>
                            <th>NIT</th>
                            <th>CUI</th>
                            <th>Seguro Médico</th>
                            <th>Número de Póliza</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_clientes->num_rows > 0) { ?>
                            <?php while ($cliente = $result_clientes->fetch_assoc()) { ?>
                                <tr id="cliente-<?php echo $cliente['id']; ?>">
                                    <td><input type="text" class="form-control" value="<?php echo $cliente['nombre']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" value="<?php echo $cliente['direccion']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" value="<?php echo $cliente['telefono']; ?>" readonly></td>
                                    <td><input type="email" class="form-control" value="<?php echo $cliente['correo']; ?>" readonly></td>
                                    <td>
                                        <select class="form-control" readonly>
                                            <option value="M" <?php echo ($cliente['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                                            <option value="F" <?php echo ($cliente['sexo'] == 'F') ? 'selected' : ''; ?>>Femenino</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" value="<?php echo $cliente['NIT']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" value="<?php echo $cliente['CUI']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" value="<?php echo $cliente['seguro_medico']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" value="<?php echo $cliente['numero_poliza']; ?>" readonly></td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="habilitarEdicion(<?php echo $cliente['id']; ?>)">Editar</button>
                                        <button class="btn btn-success btn-sm" onclick="guardarEdicion(<?php echo $cliente['id']; ?>)" style="display:none;">Guardar</button>
                                        <button class="btn btn-danger btn-sm" onclick="desactivarCliente(<?php echo $cliente['id']; ?>)">Desactivar</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="10" class="text-center">No hay clientes registrados.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function habilitarEdicion(id) {
            $('#cliente-' + id + ' input, #cliente-' + id + ' select').prop('readonly', false);
            $('#cliente-' + id + ' .btn-info').hide();
            $('#cliente-' + id + ' .btn-success').show();
        }

        function guardarEdicion(id) {
            var datos = {
                id: id,
                nombre: $('#cliente-' + id + ' input').eq(0).val(),
                direccion: $('#cliente-' + id + ' input').eq(1).val(),
                telefono: $('#cliente-' + id + ' input').eq(2).val(),
                correo: $('#cliente-' + id + ' input').eq(3).val(),
                sexo: $('#cliente-' + id + ' select').val(),
                nit: $('#cliente-' + id + ' input').eq(4).val(),
                cui: $('#cliente-' + id + ' input').eq(5).val(),
                seguro_medico: $('#cliente-' + id + ' input').eq(6).val(),
                numero_poliza: $('#cliente-' + id + ' input').eq(7).val()
            };

            $.post('actualizar_cliente.php', datos, function(response) {
                alert(response);
                $('#cliente-' + id + ' input, #cliente-' + id + ' select').prop('readonly', true);
                $('#cliente-' + id + ' .btn-info').show();
                $('#cliente-' + id + ' .btn-success').hide();
            });
        }

        function desactivarCliente(id) {
            if (confirm("¿Estás seguro de que deseas desactivar este cliente?")) {
                $.post('desactivar_cliente.php', { id: id }, function(response) {
                    alert(response);
                    location.reload();
                });
            }
        }
    </script>
</body>
</html>
