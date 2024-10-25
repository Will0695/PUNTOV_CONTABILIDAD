<?php
include 'db.php';
include 'verificar_rol.php';
verificarPermiso(['admin']); // Solo el admin puede asignar permisos

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rol = $_POST['rol'];
    $ventanas = isset($_POST['ventanas']) ? $_POST['ventanas'] : [];

    // Eliminar los permisos anteriores para este rol
    $sql_delete = "DELETE FROM permisos WHERE rol = '$rol'";
    $conn->query($sql_delete);

    // Insertar los nuevos permisos seleccionados
    foreach ($ventanas as $ventana) {
        $sql_insert = "INSERT INTO permisos (rol, ventana) VALUES ('$rol', '$ventana')";
        $conn->query($sql_insert);
    }

    echo "Permisos actualizados para el rol $rol.";
}

// Obtener las ventanas que ya tienen permisos asignados para cada rol
function obtenerVentanasAsignadas($rol) {
    global $conn;
    $ventanas = [];
    $sql = "SELECT ventana FROM permisos WHERE rol = '$rol'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $ventanas[] = $row['ventana'];
    }
    return $ventanas;
}

$ventanasAdmin = obtenerVentanasAsignadas('admin');
$ventanasVendedor = obtenerVentanasAsignadas('vendedor');
$ventanasContador = obtenerVentanasAsignadas('contador');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asignar Permisos</title>
</head>
<body>
    <h1>Asignar Permisos a Roles</h1>

    <!-- Formulario para asignar permisos al Vendedor -->
    <form method="POST" action="">
        <h2>Permisos para Vendedor</h2>
        <input type="hidden" name="rol" value="vendedor">
        <label><input type="checkbox" name="ventanas[]" value="clientes" <?php if (in_array('clientes', $ventanasVendedor)) echo 'checked'; ?>> Clientes</label><br>
        <label><input type="checkbox" name="ventanas[]" value="productos" <?php if (in_array('productos', $ventanasVendedor)) echo 'checked'; ?>> Productos</label><br>
        <label><input type="checkbox" name="ventanas[]" value="ventas" <?php if (in_array('ventas', $ventanasVendedor)) echo 'checked'; ?>> Ventas</label><br>
        <button type="submit">Guardar Permisos</button>
    </form>

    <!-- Formulario para asignar permisos al Contador -->
    <form method="POST" action="">
        <h2>Permisos para Contador</h2>
        <input type="hidden" name="rol" value="contador">
        <label><input type="checkbox" name="ventanas[]" value="devoluciones" <?php if (in_array('devoluciones', $ventanasContador)) echo 'checked'; ?>> Devoluciones</label><br>
        <label><input type="checkbox" name="ventanas[]" value="pagos" <?php if (in_array('pagos', $ventanasContador)) echo 'checked'; ?>> Pagos</label><br>
        <button type="submit">Guardar Permisos</button>
    </form>

    <!-- Formulario para asignar permisos al Admin -->
    <form method="POST" action="">
        <h2>Permisos para Admin</h2>
        <input type="hidden" name="rol" value="admin">
        <label><input type="checkbox" name="ventanas[]" value="clientes" <?php if (in_array('clientes', $ventanasAdmin)) echo 'checked'; ?>> Clientes</label><br>
        <label><input type="checkbox" name="ventanas[]" value="productos" <?php if (in_array('productos', $ventanasAdmin)) echo 'checked'; ?>> Productos</label><br>
        <label><input type="checkbox" name="ventanas[]" value="ventas" <?php if (in_array('ventas', $ventanasAdmin)) echo 'checked'; ?>> Ventas</label><br>
        <label><input type="checkbox" name="ventanas[]" value="devoluciones" <?php if (in_array('devoluciones', $ventanasAdmin)) echo 'checked'; ?>> Devoluciones</label><br>
        <label><input type="checkbox" name="ventanas[]" value="pagos" <?php if (in_array('pagos', $ventanasAdmin)) echo 'checked'; ?>> Pagos</label><br>
        <label><input type="checkbox" name="ventanas[]" value="inventarios" <?php if (in_array('inventarios', $ventanasAdmin)) echo 'checked'; ?>> Inventarios</label><br>
        <label><input type="checkbox" name="ventanas[]" value="respaldos" <?php if (in_array('respaldos', $ventanasAdmin)) echo 'checked'; ?>> Respaldos</label><br>
        <button type="submit">Guardar Permisos</button>
    </form>
</body>
</html>
