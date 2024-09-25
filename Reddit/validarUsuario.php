<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Usuario</title>
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
    if (isset($_POST['usuario']) && isset($_POST['password'])) {
        try {
            include "conexion.php";
            // Establecemos conexión
            $pdo = new PDO($dsn, $username, $password, $opciones);

            // Recogemos los datos del formulario de login
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            // Preparamos la consulta y la ejecutamos
            $consulta = $pdo->prepare("SELECT password, salt FROM usuario WHERE usuario = :user");
            $consulta->bindParam(":user", $usuario);
            $consulta->execute();
            $result = $consulta->fetch();

            // Verificamos si el usuario existe y la contraseña es correcta
            if ($result && password_verify($password.$result['salt'], $result['password'])) {
                //Aquí hago una consulta para ver cuantos intentos tiene el usuario que está intentando iniciar sesión, si es mas de 4 se le bloqueará la cuenta
                $consultaIntentos = $pdo->prepare("SELECT * FROM usuario WHERE usuario = :usu");
                $consultaIntentos->bindParam(":usu", $usuario);
                $consultaIntentos->execute();
                $resultIntentos = $consultaIntentos->fetch();
                $intentosUsu=$resultIntentos["intentos"];
                if ($intentosUsu>4){
                    header("Location: usuarioBloqueado.php");
                    exit();
                }else{
                    $intentos=0;
                    $sumarIntento = $pdo->prepare("UPDATE usuario SET intentos = :intentos WHERE usuario = :usu");
                    $sumarIntento->bindParam(":intentos", $intentos);
                    $sumarIntento->bindParam(":usu", $usuario);
                    $sumarIntento->execute();
                }
                //Si se le da a recordar creo la cookie con el token generado, el cual se le introducerá al usuario en la BBDD.
                //cada vez que el usuario le dé a recordar se le asignará un token nuevo
                if (isset($_POST["rec"])) {
                    // Generamos un token aleatorio
                    $token = bin2hex(random_bytes(16));
                    //Insertamos el token a ese usuario, lo he buscado por usuario porque no se puede repetir ese nombre
                    $insertarToken = $pdo->prepare("UPDATE usuario SET token = :token WHERE usuario = :usu");
                    $insertarToken->bindParam(":token", $token);
                    $insertarToken->bindParam(":usu", $usuario);
                    $insertarToken->execute();
                    $resultToken = $insertarToken->fetch();

                    setcookie('token',$token,time()+ 60 * 60 * 24 * 30);
                }
                session_start();
                $_SESSION['usuario'] = $usuario;
                header("Location: paginaPrincipal.php");
                exit();
            } else {
                echo "Usuario o contraseña incorrectos.";
                $consultaIntentos = $pdo->prepare("SELECT * FROM usuario WHERE usuario = :usu");
                $consultaIntentos->bindParam(":usu", $usuario);
                $consultaIntentos->execute();
                $resultIntentos = $consultaIntentos->fetch();
                if (isset($resultIntentos["intentos"])){
                    $intentos=$resultIntentos["intentos"]+1;
                    $sumarIntento = $pdo->prepare("UPDATE usuario SET intentos = :intentos WHERE usuario = :usu");
                    $sumarIntento->bindParam(":intentos", $intentos);
                    $sumarIntento->bindParam(":usu", $usuario);
                    $sumarIntento->execute();
                    $resultSumarIntento = $sumarIntento->fetch();
                }
                echo "<br><br><input type='button' value='Volver a intentarlo' onclick='window.location.href=`login.php`'>";
            }
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
    } else {
        echo "Debes introducir el usuario y la contraseña";
    }
} else {
    echo "Acceso no permitido";
}

?>
</body>
</html>
