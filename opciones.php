<?php
include 'verificar_rol.php'; 
verificarPermiso(['admin', 'vendedor']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .option-button {
            width: 200px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 1.2rem;
            margin: 1rem;
        }
    </style>
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
                <li class="nav-item"><a class="nav-link" href="clientes.php">Nuevo Cliente</a></li>
                <li class="nav-item"><a class="nav-link" href="productos.php">Nuevo Producto</a></li>
                <li class="nav-item"><a class="nav-link" href="ventas.php">Ventas</a></li>
                <li class="nav-item"><a class="nav-link" href="opciones.php">Opciones</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenedor de opciones -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="text-center d-flex flex-wrap justify-content-center">

            <!-- Opción de Devoluciones -->
            <button class="btn btn-info option-button" data-toggle="modal" data-target="#editarDevolucionModal" onclick="editarDevolucion(1)">
                <i class="fas fa-undo-alt mb-2" style="font-size: 3rem;"></i>
                <span>Devoluciones</span>
            </button>

            <!-- Opción de Pagos -->
            <!-- Botón para abrir la sección de pagos -->
<button class="btn btn-primary option-button" onclick="window.location.href='pagos.php'">
    <i class="fas fa-money-check-alt mb-2" style="font-size: 3rem;"></i>
    <span>Pagos</span>
</button>


            <!-- Opción de Inventarios -->
            <button class="btn btn-warning option-button" data-toggle="modal" data-target="#inventariosModal">
                <i class="fas fa-boxes mb-2" style="font-size: 3rem;"></i>
                <span>Inventarios</span>
            </button>

            <!-- Opción de Respaldos -->
            <button class="btn btn-secondary option-button" data-toggle="modal" data-target="#respaldosModal">
                <i class="fas fa-database mb-2" style="font-size: 3rem;"></i>
                <span>Respaldos</span>
            </button>

        </div>
    </div>

    <!-- Modales para cada funcionalidad -->
    
    <!-- Modal para Editar Devolución -->
    <div class="modal fade" id="editarDevolucionModal" tabindex="-1" aria-labelledby="editarDevolucionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarDevolucionLabel">Editar Devolución</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarDevolucion">
                        <input type="hidden" id="devolucion_id" name="id">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="motivo">Motivo</label>
                            <input type="text" class="form-control" id="motivo" name="motivo" required>
                        </div>
                        <div class="form-group">
                            <label for="venta_id">ID de Venta</label>
                            <input type="number" class="form-control" id="venta_id" name="venta_id" required>
                        </div>
                        <div class="form-group">
                            <label for="producto_id">ID de Producto</label>
                            <input type="number" class="form-control" id="producto_id" name="producto_id" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambiosDevolucion()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para manejar la edición de devoluciones -->
    <script>
        function editarDevolucion(id) {
            console.log("Intentando editar devolución con ID:", id); // Diagnóstico en consola
            $.get('obtener_devolucion.php', { id: id }, function(data) {
                console.log("Datos recibidos para la devolución:", data); // Diagnóstico en consola
                const devolucion = JSON.parse(data);

                // Cargar los datos en el formulario del modal
                $('#devolucion_id').val(devolucion.id);
                $('#fecha').val(devolucion.fecha);
                $('#motivo').val(devolucion.motivo);
                $('#venta_id').val(devolucion.venta_id);
                $('#producto_id').val(devolucion.producto_id);
                $('#cantidad').val(devolucion.cantidad);

                // Mostrar el modal de edición
                $('#editarDevolucionModal').modal('show');
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                alert("Error al obtener los datos de la devolución.");
            });
        }

        function guardarCambiosDevolucion() {
            $.post('actualizar_devolucion.php', $('#formEditarDevolucion').serialize(), function(response) {
                alert(response);
                $('#editarDevolucionModal').modal('hide'); // Cerrar el modal
                location.reload(); // Recargar la página para ver los cambios
            });
        }

        function eliminarDevolucion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta devolución?")) {
                $.post('eliminar_devolucion.php', { id: id }, function(response) {
                    alert(response);
                    location.reload();
                });
            }
        }
    </script>

    

    <!-- Modal para Inventarios -->
    <div class="modal fade" id="inventariosModal" tabindex="-1" aria-labelledby="inventariosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inventariosModalLabel">Inventarios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Registra y consulta el inventario, incluyendo la cantidad inicial, cantidad vendida, recibida y en existencia.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Respaldos -->
    <div class="modal fade" id="respaldosModal" tabindex="-1" aria-labelledby="respaldosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="respaldosModalLabel">Respaldos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Realiza copias de seguridad de los datos de la base periódicamente para evitar pérdidas de información.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
