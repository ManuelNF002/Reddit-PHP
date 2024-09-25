<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body{
            background-color: #6b888f;
            color: white;
        }
    </style>
</head>
<body>
<h2>Registrar Usuario</h2>
<form action="nuevoUsuario.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required><br><br>

    <input type="submit" value="Guardar">
    <input type="button" onclick="window.location.href='login.php'" value="Cancelar">
</form>
</body>
</html>
