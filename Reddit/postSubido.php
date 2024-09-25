<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Subido</title>
    <style>
        body{
            background-color: #6b888f;
            color: white;
        }
    </style>
</head>
<body>
<?php
session_start();
if (isset($_SESSION["usuario"])){

    //Aquí cada vez que se ejecuta la aplicacion desde un dispositivo diferente, hay que hacer un cambio en el nombre de la carpet, ya que da fallo
    //como que no existe por alguna razón.
    if (isset($_POST['Subido']) && $_POST['Subido'] == 'Subir Post') {
        if (is_uploaded_file($_FILES['contenido']['tmp_name'])) {
            $nombre = $_FILES['contenido']['name'];
            $carpeta="posts/{$nombre}";
            move_uploaded_file($_FILES['contenido']['tmp_name'], $carpeta);

            echo "<p>Archivo $nombre subido con éxito</p>";
            include "conexion.php";
            $pdo = new PDO($dsn, $username, $password, $opciones);
            $titulo=$_POST["titulo"];
            $descripcion=$_POST["desc"];
            $autor=$_SESSION["usuario"];
            $stmt = $pdo->prepare("INSERT INTO post (titulo, contenido, descripcion, autor) VALUES (:tit, :cont, :desc, :aut)");
            $stmt->bindParam(":tit", $titulo);
            $stmt->bindValue(":cont", "posts/".$nombre);
            $stmt->bindParam(":desc",$descripcion);
            $stmt->bindParam(":aut",$autor );
            $stmt->execute();
            echo("<input type='button' value='Volver a la página principal' onclick='window.location.href=`paginaPrincipal.php`'>");
        }
    }
}else{
    echo("Acceso no permitido");
}
?>
</body>
</html>