<?php
include 'verificar_rol.php'; 
verificarPermiso(['admin', 'vendedor']);
include 'db.php'; // Asegúrate de que esta ruta sea correcta para la conexión a la base de datos

// Obtener categorías de la base de datos para mostrarlas en el formulario de productos
$query = "SELECT id, nombre FROM categorias";
$resultado = $conn->query($query);
$categorias = [];
while ($fila = $resultado->fetch_assoc()) {
    $categorias[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Gestionar Productos</title>
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
                <a class="nav-link" href="opciones.php">Opciones</a>
            </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-danger text-white" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>
        
  <!-- Contenedor principal para centrar los botones en la pantalla -->
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center d-flex flex-wrap justify-content-center">
        
        <!-- Botón de Agregar Producto -->
        <button class="btn btn-primary m-3 d-flex flex-column align-items-center p-4" 
                data-toggle="modal" data-target="#nuevoProductoModal" style="width: 200px; height: 200px;">
            <i class="fas fa-box mb-2" style="font-size: 3rem;"></i>
            <span>Agregar Nuevo Producto</span>
        </button>
        
        <!-- Botón de Ver Productos -->
        <button class="btn btn-info m-3 d-flex flex-column align-items-center p-4" 
                data-toggle="modal" data-target="#verProductoModal" style="width: 200px; height: 200px;">
            <i class="fas fa-eye mb-2" style="font-size: 3rem;"></i>
            <span>Ver Productos</span>
        </button>

        <!-- Botón de Agregar Categoría -->
        <button class="btn btn-secondary m-3 d-flex flex-column align-items-center p-4" 
                data-toggle="modal" data-target="#nuevaCategoriaModal" style="width: 200px; height: 200px;">
            <i class="fas fa-tags mb-2" style="font-size: 3rem;"></i>
            <span>Agregar Nueva Categoría</span>
        </button>

        <!-- Botón de Ver Categorías -->
        <button class="btn btn-warning m-3 d-flex flex-column align-items-center p-4" 
                data-toggle="modal" data-target="#verCategoriaModal" style="width: 200px; height: 200px;">
            <i class="fas fa-list-alt mb-2" style="font-size: 3rem;"></i>
            <span>Ver Categorías</span>
        </button>

    </div>
</div>

<!-- Cargar Font Awesome para los íconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">




    <!-- Modal para notificación de éxito -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-check-circle" style="font-size: 3rem; color: green;"></i>
                    <p class="mt-3">Categoría creada exitosamente.</p>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal para agregar nuevo producto -->
<div class="modal fade" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoProductoLabel">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formNuevoProducto" action="guardar_producto.php" method="post">
                    <div class="form-group">
                        <label for="codigoProducto">Código del Producto</label>
                        <input type="text" class="form-control" id="codigoProducto" name="codigo_producto" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="form-group">
                        <label for="precioUnitario">Precio Unitario</label>
                        <input type="number" class="form-control" id="precioUnitario" name="precio_unitario" required step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="impuestos">Impuestos</label>
                        <input type="number" class="form-control" id="impuestos" name="impuestos" required step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="numeroSerie">Número de Serie</label>
                        <input type="text" class="form-control" id="numeroSerie" name="numero_serie">
                    </div>
                    <div class="form-group">
                        <label for="categoriaId">Categoría</label>
                        <select class="form-control" id="categoriaId" name="categoria_id" required>
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="formNuevoProducto">Guardar Producto</button>
            </div>
        </div>
    </div>
</div>

        
    <!-- Modal para agregar nueva categoría -->
    <div class="modal fade" id="nuevaCategoriaModal" tabindex="-1" aria-labelledby="nuevaCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaCategoriaLabel">Nueva Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNuevaCategoria" action="guardar_categoria.php" method="post">
                        <div class="form-group">
                            <label for="nombreCategoria">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="nombreCategoria" name="nombre" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="formNuevaCategoria">Guardar Categoría</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<!-- Modal para ver y editar productos -->
<div class="modal fade" id="verProductoModal" tabindex="-1" aria-labelledby="verProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verProductoLabel">Lista de Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Precio Unitario</th>
                            <th>Impuestos</th>
                            <th>Número de Serie</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $productos = $conn->query("SELECT p.id, p.codigo_producto AS codigo, p.descripcion, 
                                                   p.precio_unitario, p.impuestos, p.numero_serie, 
                                                   c.nombre AS categoria 
                                                   FROM productos p 
                                                   LEFT JOIN categorias c ON p.categoria_id = c.id");

                        if ($productos) {
                            while ($producto = $productos->fetch_assoc()) {
                                echo "<tr id='producto-{$producto['id']}'>
                                        <td><input type='text' class='form-control' value='{$producto['codigo']}' readonly></td>
                                        <td><input type='text' class='form-control' value='{$producto['descripcion']}' readonly></td>
                                        <td><input type='number' class='form-control' value='{$producto['precio_unitario']}' readonly></td>
                                        <td><input type='number' class='form-control' value='{$producto['impuestos']}' readonly></td>
                                        <td><input type='text' class='form-control' value='{$producto['numero_serie']}' readonly></td>
                                        <td>{$producto['categoria']}</td>
                                        <td>
                                            <button class='btn btn-info btn-sm' onclick='habilitarEdicion({$producto['id']})'>Editar</button>
                                            <button class='btn btn-success btn-sm' onclick='guardarEdicion({$producto['id']})' style='display:none;'>Guardar</button>
                                            <button class='btn btn-danger btn-sm' onclick='desactivarProducto({$producto['id']})'>Desactivar</button>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Error en la consulta de productos: " . $conn->error . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function habilitarEdicion(id) {
        // Habilitar los campos para edición
        $('#producto-' + id + ' input').prop('readonly', false);

        // Mostrar el botón de "Guardar" y ocultar el botón de "Editar"
        $('#producto-' + id + ' .btn-info').hide();
        $('#producto-' + id + ' .btn-success').show();
    }

    function guardarEdicion(id) {
        // Obtener los datos de los campos editables
        var datos = {
            id: id,
            codigo_producto: $('#producto-' + id + ' input').eq(0).val(),
            descripcion: $('#producto-' + id + ' input').eq(1).val(),
            precio_unitario: $('#producto-' + id + ' input').eq(2).val(),
            impuestos: $('#producto-' + id + ' input').eq(3).val(),
            numero_serie: $('#producto-' + id + ' input').eq(4).val()
        };

        // Enviar datos al servidor con AJAX para actualizar el producto
        $.post('actualizar_producto.php', datos, function(response) {
            alert(response); // Mostrar mensaje de respuesta
            $('#producto-' + id + ' input').prop('readonly', true); // Desactivar campos
            $('#producto-' + id + ' .btn-info').show();
            $('#producto-' + id + ' .btn-success').hide();
        });
    }

    function desactivarProducto(id) {
        if (confirm("¿Estás seguro de que deseas desactivar este producto?")) {
            $.post('desactivar_producto.php', { id: id }, function(response) {
                alert(response); // Mostrar mensaje de respuesta
                $('#producto-' + id).remove(); // Remover producto de la tabla
            });
        }
    }
</script>


<!-- Modal para ver categorías -->
<div class="modal fade" id="verCategoriaModal" tabindex="-1" aria-labelledby="verCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verCategoriaLabel">Lista de Categorías</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de la Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener las categorías desde la base de datos
                        $categorias = $conn->query("SELECT id, nombre FROM categorias");

                        if ($categorias) {
                            while ($categoria = $categorias->fetch_assoc()) {
                                echo "<tr id='categoria-{$categoria['id']}'>
                                        <td>{$categoria['id']}</td>
                                        <td><input type='text' class='form-control' value='{$categoria['nombre']}' readonly></td>
                                        <td>
                                            <button class='btn btn-info btn-sm' onclick='habilitarEdicionCategoria({$categoria['id']})'>Editar</button>
                                            <button class='btn btn-success btn-sm' onclick='guardarEdicionCategoria({$categoria['id']})' style='display:none;'>Guardar</button>
                                            <button class='btn btn-danger btn-sm' onclick='desactivarCategoria({$categoria['id']})'>Desactivar</button>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Error al cargar las categorías: " . $conn->error . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Habilitar la edición de una categoría
    function habilitarEdicionCategoria(id) {
        // Habilitar el campo de nombre para edición
        $('#categoria-' + id + ' input').prop('readonly', false);

        // Mostrar el botón de "Guardar" y ocultar el botón de "Editar"
        $('#categoria-' + id + ' .btn-info').hide();
        $('#categoria-' + id + ' .btn-success').show();
    }

    // Guardar los cambios de una categoría
    function guardarEdicionCategoria(id) {
        var nombre = $('#categoria-' + id + ' input').val(); // Obtener el nuevo nombre de la categoría

        // Enviar los datos al servidor mediante AJAX
        $.post('actualizar_categoria.php', { id: id, nombre: nombre }, function(response) {
            alert(response); // Mostrar mensaje de respuesta

            // Deshabilitar el campo de nombre después de guardar
            $('#categoria-' + id + ' input').prop('readonly', true);

            // Restaurar los botones
            $('#categoria-' + id + ' .btn-info').show();
            $('#categoria-' + id + ' .btn-success').hide();
        });
    }

    // Desactivar una categoría
    function desactivarCategoria(id) {
        if (confirm("¿Estás seguro de que deseas desactivar esta categoría?")) {
            // Enviar solicitud para desactivar la categoría
            $.post('desactivar_categoria.php', { id: id }, function(response) {
                alert(response); // Mostrar mensaje de respuesta
                location.reload(); // Recargar la página para actualizar la lista
            });
        }
    }
</script>




    <script>
        // Mostrar el modal de éxito adecuado según el tipo en la URL
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                const type = urlParams.get('type');
                
                if (type === 'producto') {
                    $('#successModal .modal-body p').text('Producto creado exitosamente.');
                } else if (type === 'categoria') {
                    $('#successModal .modal-body p').text('Categoría creada exitosamente.');
                }

                $('#successModal').modal('show');
                
                // Cerrar el modal automáticamente después de 2 segundos
                setTimeout(function() {
                    $('#successModal').modal('hide');
                }, 2000);
            }
        });
    </script>

</body>
</html>
