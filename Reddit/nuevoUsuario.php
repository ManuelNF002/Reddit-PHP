<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario Registrado</title>
    <style>
        body{
            background-color: #6b888f;
            color: white;
        }
    </style>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nombre']) && !empty($_POST['usuario']) && !empty($_POST['password']) && !empty($_POST['email'])) {
        try {
            include "conexion.php";
            // Establecemos la conexión
            $pdo = new PDO($dsn, $username, $password, $opciones);

            // Datos recogidos del formulario de registro
            $nombre = $_POST['nombre'];
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            //Este lo pongo a 0 para que los nuevos usuarios que se registren empiezen con 0 intentos
            $intentos=0;
            // Generar salt aleatorio
            $salt = uniqid(mt_rand(), true);

            // Concatenamos la contraseña con salt
            $passwordSalted = $password . $salt;

            // Encriptamos la contraseña con el salt añadido
            $passwordHash = password_hash($passwordSalted, PASSWORD_DEFAULT);



            // Preparo y ejecuto la consulta, metiendo los valores recogidos del formulario utilizando bindParam.
            $stmt = $pdo->prepare("INSERT INTO usuario (nombre, usuario, password, email, salt, intentos, token) VALUES (:nomb, :user, :pass, :email, :salt, :ints, :token)");
            $stmt->bindParam(":nomb", $nombre);
            $stmt->bindParam(":user", $usuario);
            $stmt->bindParam(":pass", $passwordHash);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":salt", $salt);
            $stmt->bindParam(":ints", $intentos);
            $stmt->bindValue(":token", 0);
            $stmt->execute();

            echo "El usuario $usuario ha sido introducido en el sistema con el correo electrónico de recuperación en $email";
            echo "<br><br><input type='button' value='Iniciar Sesión' onclick='window.location.href=`login.php`'>";
        } catch (PDOException $e) {
            echo "No se ha podido registrar el usuario porque ya existe. ";
            echo "<br><br><input type='button' value='Volver' onclick='window.location.href=`registro.php`'>";
        }
    } else {
        echo "Error. Hay que rellenar todos los campos.";
        echo "<br><br><input type='button' value='Volver' onclick='window.location.href=`registro.php`'>";
    }
} else {
    echo "Acceso no permitido";
}
?>
</body>
</html>