<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Color de fondo suave */
        }
        .login-container {
            max-width: 400px; /* Ancho máximo del formulario */
            margin: 100px auto; /* Centrado vertical y horizontal */
            padding: 20px; /* Espaciado interno */
            background-color: white; /* Fondo blanco */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }
        .error-message {
            color: red; /* Color rojo para el mensaje de error */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Login</h2>
        <form id="loginForm" method="POST" action="login.php">
            <div class="form-group">
                <label for="nombre_usuario">Usuario:</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
        </form>
        <div id="error-message" class="error-message text-center"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            var nombreUsuario = document.getElementById('nombre_usuario').value;
            var contrasena = document.getElementById('contrasena').value;

            if (nombreUsuario === '' || contrasena === '') {
                event.preventDefault();
                document.getElementById('error-message').innerText = 'Por favor, llene todos los campos.';
            } else {
                document.getElementById('error-message').innerText = ''; // Limpiar mensaje de error si todo está correcto
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
