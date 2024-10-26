<?php
include 'verificar_rol.php'; 
verificarPermiso(['admin', 'contador']);
include 'db.php'; // Conexión a la base de datos

// Obtener pagos de la base de datos
$query = "SELECT * FROM pagos";
$pagos = $conn->query($query);

// Obtener lista de bancos para el selector
$query_bancos = "SELECT id, nombre FROM bancos";
$bancos = $conn->query($query_bancos);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="dashboard.php">Panel Contador</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <div class="container my-4">
        <h1 class="text-center">Gestión de Pagos</h1>

        <!-- Botón para agregar nuevo pago -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#nuevoPagoModal">Agregar Nuevo Pago</button>

        <!-- Tabla de pagos -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Forma de Pago</th>
                    <th>Monto</th>
                    <th>Número de Referencia</th>
                    <th>Banco</th>
                    <th>Cliente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pago = $pagos->fetch_assoc()) { ?>
                    <tr id="pago-<?php echo $pago['id']; ?>">
                        <td><?php echo $pago['fecha']; ?></td>
                        <td><?php echo $pago['forma_pago']; ?></td>
                        <td><?php echo $pago['monto']; ?></td>
                        <td><?php echo $pago['numero_referencia']; ?></td>
                        <td><?php echo $pago['banco_id']; ?></td>
                        <td><?php echo $pago['cliente_id']; ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editarPago(<?php echo $pago['id']; ?>)">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarPago(<?php echo $pago['id']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar nuevo pago -->
    <div class="modal fade" id="nuevoPagoModal" tabindex="-1" aria-labelledby="nuevoPagoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoPagoLabel">Nuevo Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNuevoPago" action="guardar_pago.php" method="post">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="forma_pago">Forma de Pago</label>
                            <select class="form-control" id="forma_pago" name="forma_pago" required>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monto">Monto</label>
                            <input type="number" class="form-control" id="monto" name="monto" required>
                        </div>
                        <div class="form-group">
                            <label for="numero_referencia">Número de Referencia</label>
                            <input type="text" class="form-control" id="numero_referencia" name="numero_referencia">
                        </div>
                        <div class="form-group">
                            <label for="banco_id">Banco</label>
                            <select class="form-control" id="banco_id" name="banco_id" required>
                                <?php while ($banco = $bancos->fetch_assoc()) { ?>
                                    <option value="<?php echo $banco['id']; ?>"><?php echo $banco['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cliente_id">Cliente ID</label>
                            <input type="number" class="form-control" id="cliente_id" name="cliente_id" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="formNuevoPago">Guardar Pago</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar pago -->
    <div class="modal fade" id="editarPagoModal" tabindex="-1" aria-labelledby="editarPagoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPagoLabel">Editar Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarPago">
                        <input type="hidden" id="editar_id" name="id">
                        <div class="form-group">
                            <label for="editar_fecha">Fecha</label>
                            <input type="date" class="form-control" id="editar_fecha" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="editar_forma_pago">Forma de Pago</label>
                            <select class="form-control" id="editar_forma_pago" name="forma_pago" required>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editar_monto">Monto</label>
                            <input type="number" class="form-control" id="editar_monto" name="monto" required>
                        </div>
                        <div class="form-group">
                            <label for="editar_numero_referencia">Número de Referencia</label>
                            <input type="text" class="form-control" id="editar_numero_referencia" name="numero_referencia">
                        </div>
                        <div class="form-group">
                            <label for="editar_banco_id">Banco</label>
                            <select class="form-control" id="editar_banco_id" name="banco_id" required>
                                <?php $bancos->data_seek(0); // Reiniciar el resultado de bancos
                                while ($banco = $bancos->fetch_assoc()) { ?>
                                    <option value="<?php echo $banco['id']; ?>"><?php echo $banco['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editar_cliente_id">Cliente ID</label>
                            <input type="number" class="form-control" id="editar_cliente_id" name="cliente_id" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambiosPago()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function editarPago(id) {
            $.get('obtener_pago.php', { id: id }, function(data) {
                const pago = JSON.parse(data);
                $('#editar_id').val(pago.id);
                $('#editar_fecha').val(pago.fecha);
                $('#editar_forma_pago').val(pago.forma_pago);
                $('#editar_monto').val(pago.monto);
                $('#editar_numero_referencia').val(pago.numero_referencia);
                $('#editar_banco_id').val(pago.banco_id);
                $('#editar_cliente_id').val(pago.cliente_id);
                $('#editarPagoModal').modal('show');
            });
        }

        function guardarCambiosPago() {
            $.post('actualizar_pago.php', $('#formEditarPago').serialize(), function(response) {
                alert(response);
                $('#editarPagoModal').modal('hide');
                location.reload();
            });
        }

        function eliminarPago(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este pago?")) {
                $.post('eliminar_pago.php', { id: id }, function(response) {
                    alert(response);
                    location.reload();
                });
            }
        }
    </script>
</body>
</html>
