<?php
include "conexion.php";
//Primero comprueba que existe la cookie del token que se crea al darle a recordar para buscar al usuario al cual
//pertenezca ese token, para poder mandarlo a la zona privada directamente si existe ese token guardado en la BBDD.
    if (isset($_COOKIE['token'])){
        session_start();
        $pdo = new PDO($dsn, $username, $password, $opciones);
        $recordarToken = $pdo->prepare("SELECT usuario from usuario WHERE token = :token");
        $recordarToken->bindParam(":token", $_COOKIE['token']);
        $recordarToken->execute();
        $result = $recordarToken->fetch();
        $_SESSION["usuario"]=$result["usuario"];
        header("Location: paginaPrincipal.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body{
            background-color: #6b888f;
            color: white;
        }
    </style>
</head>
<body>
<h2>Iniciar Sesión</h2>
<form action="validarUsuario.php" method="post">
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="rec">Recordar:</label>
    <input type="checkbox" id="rec" name="rec"><br><br>

    <input type="submit" value="Iniciar Sesión">
    <input type="button" onclick="window.location.href='registro.php'" value="Registrarse">
    <input type="button" onclick="window.location.href='paginaPrincipal.php'" value="Volver a la página principal">
</form>
</body>
</html>
