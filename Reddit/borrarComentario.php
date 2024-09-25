<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Comentario</title>
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
    include "conexion.php";
    $pdo = new PDO($dsn, $username, $password, $opciones);
    $idPost=$_GET["idP"];
    $idComentario=$_GET["idC"];
    $borrarSelec=$pdo->prepare("DELETE FROM comentario WHERE id_comentario=:id");
    $borrarSelec->bindParam(":id",$idComentario);
    $borrarSelec->execute();
    echo("
        <script>
            alert('Comentario borrado exitósamente');
            window.location.href=`entrarPost.php?id={$idPost}`;
        </script>
    
    ");
}else{
    echo "Acceso no permitido";
}

?>
</body>
</html>