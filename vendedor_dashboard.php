
<!DOCTYPE html>
<html lang="es">
<head>
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

<!-- Contenedor Principal -->
<div class="container-fluid mt-3">
    <div class="row">
        <!-- Columna Izquierda: Sistema de Ventas -->
        <div class="col-md-6 p-3">
            <h4>SISTEMA DE VENTAS</h4>
            <form id="form_venta" action="procesar_venta.php" method="POST" onsubmit="return prepararDatos();">
                <!-- Campo de NIT del cliente con autocompletado -->
                <div class="form-group">
                    <label for="nit_cliente">NIT del Cliente:</label>
                    <input type="text" class="form-control" id="nit_cliente" name="nit_cliente" placeholder="Ingrese NIT del Cliente" onkeyup="buscarCliente()">
                    <div id="sugerencias_cliente" class="list-group" style="position: absolute; z-index: 1000;"></div>
                </div>

                <!-- Campo para mostrar el nombre del cliente -->
                <div class="form-group">
                    <label for="nombre_cliente">Nombre del Cliente:</label>
                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" readonly>
                </div>

                <!-- Campo para buscar productos por nombre o código con autocompletado -->
                <div class="form-group">
                    <label for="producto">Producto:</label>
                    <input type="text" class="form-control" id="producto" name="producto" placeholder="Código o Nombre del Producto" onkeyup="buscarProducto()">
                    <div id="sugerencias_producto" class="list-group" style="position: absolute; z-index: 1000;"></div>
                </div>

                <!-- Campo para mostrar el nombre del producto -->
                <div class="form-group">
                    <label for="nombre_producto">Nombre del Producto:</label>
                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" readonly>
                </div>

                <!-- Campo para mostrar el precio unitario del producto -->
                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario:</label>
                    <input type="text" class="form-control" id="precio_unitario" name="precio_unitario" readonly>
                </div>

                <!-- Campo para ingresar la cantidad -->
                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" oninput="calcularTotal()">
                </div>

                <!-- Botón para agregar producto -->
                <button type="button" class="btn btn-primary" onclick="agregarProducto()">Agregar Producto</button>

                <!-- Campos ocultos para los datos a enviar -->
                <input type="hidden" id="productos" name="productos">
                <input type="hidden" id="total_a_pagar" name="total_general">
                
                <!-- Campo de selección de forma de pago -->
                <div class="form-group">
                    <label for="forma_pago">Forma de Pago:</label>
                    <select class="form-control" id="forma_pago" name="forma_pago">
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="credito">Crédito</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Columna Central: Lista de productos agregados -->
        <div class="col-md-3 p-3">
            <h4>Productos Agregados</h4>
            <ul id="lista_productos" class="list-group"></ul>
        </div>

        <!-- Columna Derecha: Total General -->
        <div class="col-md-3 p-3 bg-light text-center">
            <h4>Total a Pagar</h4>
            <h1 id="total_general_text">0.00</h1>
            <button class="btn btn-success btn-lg btn-block mt-3" type="button" onclick="pagar()">PAGAR</button>
            <button class="btn btn-secondary btn-lg btn-block mt-3" onclick="imprimir()">IMPRIMIR</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    var totalGeneral = 0;
    var productosSeleccionados = [];

    function agregarProducto() {
        var nombre = $('#nombre_producto').val();
        var cantidad = $('#cantidad').val();
        var precioUnitario = $('#precio_unitario').val();
        var total = cantidad * precioUnitario;

        if (nombre && cantidad > 0 && precioUnitario > 0) {
            productosSeleccionados.push({
                id: $('#producto').val(),
                nombre: nombre,
                cantidad: cantidad,
                precio_unitario: precioUnitario
            });

            var productoHTML = `<li class="list-group-item d-flex justify-content-between align-items-center">
                                    ${nombre} x${cantidad}
                                    <span>Q. ${total.toFixed(2)}</span>
                                </li>`;
            $('#lista_productos').append(productoHTML);

            totalGeneral += total;
            $('#total_general_text').text(totalGeneral.toFixed(2));

            $('#producto').val('');
            $('#nombre_producto').val('');
            $('#precio_unitario').val('');
            $('#cantidad').val('');
        } else {
            alert("Por favor, selecciona un producto y cantidad válidos.");
        }
    }

    function prepararDatos() {
        $('#productos').val(JSON.stringify(productosSeleccionados));
        $('#total_a_pagar').val(totalGeneral.toFixed(2));

        if (productosSeleccionados.length === 0 || totalGeneral <= 0) {
            alert("Por favor, agregue al menos un producto y verifique el total.");
            return false;
        }

        return true;
    }

    function pagar() {
        if (prepararDatos()) {
            $('#form_venta').submit(); // Envía el formulario si la preparación de datos es exitosa
        }
    }

    function buscarCliente() {
        var nit_cliente = $('#nit_cliente').val();
        if (nit_cliente.length > 0) {
            $.ajax({
                url: 'buscar_cliente.php',
                method: 'POST',
                data: { nit_cliente: nit_cliente },
                success: function(response) {
                    $('#sugerencias_cliente').html(response).fadeIn();
                }
            });
        } else {
            $('#sugerencias_cliente').fadeOut();
        }
    }

    $(document).on('click', '.sugerencia-item', function(){
        var nombre_cliente = $(this).data('nombre');
        var nit_cliente = $(this).data('nit');
        $('#nombre_cliente').val(nombre_cliente);
        $('#nit_cliente').val(nit_cliente);
        $('#sugerencias_cliente').fadeOut();
    });

    function buscarProducto() {
        var producto = $('#producto').val();
        if (producto.length > 0) {
            $.ajax({
                url: 'buscar_producto.php',
                method: 'POST',
                data: { producto: producto },
                success: function(response) {
                    $('#sugerencias_producto').html(response).fadeIn();
                }
            });
        } else {
            $('#sugerencias_producto').fadeOut();
        }
    }

    $(document).on('click', '.sugerencia-item-producto', function(){
        var nombre_producto = $(this).data('nombre');
        var producto_id = $(this).data('id');
        var precio_unitario = $(this).data('precio');

        $('#producto').val(producto_id);
        $('#nombre_producto').val(nombre_producto);
        $('#precio_unitario').val(precio_unitario);

        $('#sugerencias_producto').fadeOut();
    });

    function imprimir() {
        alert("Generando recibo de impresión...");
    }
</script>
</body>
</html>
