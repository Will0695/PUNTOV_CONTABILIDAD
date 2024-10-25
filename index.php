<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm" method="POST" action="login.php">
        <label for="nombre_usuario">Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required><br>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>
        
        <button type="submit">Login</button>
    </form>
    
    <div id="error-message"></div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            var nombreUsuario = document.getElementById('nombre_usuario').value;
            var contrasena = document.getElementById('contrasena').value;

            if (nombreUsuario === '' || contrasena === '') {
                event.preventDefault();
                document.getElementById('error-message').innerText = 'Por favor, llene todos los campos.';
            }
        });
    </script>
</body>
</html>
