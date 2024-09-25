<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar</title>
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
    if (isset($_POST['editar']) && $_POST['editar'] == 'Confirmar') {
        if (is_uploaded_file($_FILES['contenido']['tmp_name'])) {
            $nombre = $_FILES['contenido']['name'];
            move_uploaded_file($_FILES['contenido']['tmp_name'], "posts/{$nombre}");

            echo "<p>Post actualizado con éxito por $nombre</p>";
            include "conexion.php";
            $pdo = new PDO($dsn, $username, $password, $opciones);
            $titulo=$_POST["titulo"];
            $descripcion=$_POST["desc"];
            $idPost=$_GET["id"];
            $stmt = $pdo->prepare("UPDATE post SET titulo = :tit, contenido = :cont, descripcion = :desc WHERE id = :id");
            $stmt->bindParam("id",$idPost);
            $stmt->bindParam(":tit", $titulo);
            $stmt->bindValue(":cont", "posts/".$nombre);
            $stmt->bindParam(":desc", $descripcion);
            $stmt->execute();
            echo("<input type='button' value='Volver al Post' onclick='window.location.href=`entrarPost.php?id={$idPost}`'>");
        }
    }
}else{
    echo("Acceso no permitido");
}

?>
</body>
</html>