<?php
include 'verificar_rol.php'; 
verificarPermiso(['admin', 'vendedor']);
include 'db.php'; // Conexión a la base de datos

// Consultar los registros de ventas
$query = "SELECT * FROM ventas";
$resultado = $conn->query($query);
?>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Vendedor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="vendedor_dashboard.php">Panel Vendedor</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Opciones del Menú -->
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
                <a class="nav-link" href="opciones.php">Opciones</a>
            </li>
            
        </ul>
        <!-- Botón de Cerrar Sesión -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link btn btn-danger text-white" href="logout.php">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container my-4">
<h1 class="text-center">Gestión de Ventas</h1>
        
        <!-- Tabla de ventas -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Forma de Pago</th>
                    <th>Número de Factura</th>
                    <th>Descuento</th>
                    <th>Total</th>
                    <th>ID Cliente</th>
                    <th>Cuenta Corriente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0) { ?>
                    <?php while ($venta = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $venta['id']; ?></td>
                            <td><?php echo $venta['fecha']; ?></td>
                            <td><?php echo $venta['forma_pago']; ?></td>
                            <td><?php echo $venta['numero_factura']; ?></td>
                            <td><?php echo number_format($venta['descuento'], 2); ?></td>
                            <td><?php echo number_format($venta['total'], 2); ?></td>
                            <td><?php echo $venta['cliente_id']; ?></td>
                            <td><?php echo number_format($venta['cuenta_corriente'], 2); ?></td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="verDetallesVenta(<?php echo $venta['id']; ?>)">Ver</button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarVenta(<?php echo $venta['id']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="9" class="text-center">No hay registros de ventas.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para ver detalles de una venta -->
    <div class="modal fade" id="detalleVentaModal" tabindex="-1" aria-labelledby="detalleVentaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleVentaLabel">Detalles de la Venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detalleVentaContent">
                    <!-- Aquí se cargarán los detalles de la venta con AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función para ver los detalles de una venta
        function verDetallesVenta(id) {
            $.ajax({
                url: 'ver_detalle_venta.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    $('#detalleVentaContent').html(response);
                    $('#detalleVentaModal').modal('show');
                }
            });
        }

        // Función para eliminar una venta
        function eliminarVenta(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta venta?')) {
                $.ajax({
                    url: 'eliminar_venta.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html>
