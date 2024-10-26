<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin</title>
    
    <!-- Incluir Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Incluir jQuery y Bootstrap JS para el modal -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, Admin</h1>
        <p>Este es el panel de control del administrador.</p>

        <!-- Botón para abrir el modal de crear nuevo usuario -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearUsuarioModal">
            Crear Nuevo Usuario
        </button>

        <!-- Botón para abrir el modal de asignar permisos -->
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#asignarPermisosModal">
            Asignar Permisos
        </button>

        <br><br>

        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>

    <!-- Modal para Crear Nuevo Usuario -->
    <div class="modal fade" id="crearUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="crearUsuarioModalLabel">Crear Nuevo Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="formCrearUsuario" action="guardar_usuario.php" method="POST">
                <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="form-control" id="rol" name="rol" required>
                        <option value="">Seleccione un rol</option>
                        <option value="admin">Admin</option>
                        <option value="vendedor">Vendedor</option>
                        <option value="contador">Contador</option>
                    </select>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" form="formCrearUsuario">Crear Usuario</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para Asignar Permisos -->
    <div class="modal fade" id="asignarPermisosModal" tabindex="-1" role="dialog" aria-labelledby="asignarPermisosModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="asignarPermisosModalLabel">Asignar Permisos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>¿Deseas redirigirte a la página de asignación de permisos?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <!-- Botón para redirigir a la página de asignar permisos -->
            <a href="asignar_permisos.php" class="btn btn-primary">Ir a Asignar Permisos</a>
          </div>
        </div>
      </div>
    </div>

</body>
</html>
