<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Mis Post Subidos</title>
    <style>
        #iconoLogin{
            width: 30px;
            height: 30px;
        }
        body{
            background-color: #6b888f;
            color: white;
        }
        table{
            background-color: #566493;
            text-align: center;
            width: 500px;
            height: 500px;
            color: white;
            margin-bottom: 30px;
        }
        main{
            width: auto;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-items: center;
            align-items: center;
        }
        img{
            width: 400px;
            height: 300px;
        }
        h1{
            font-size: 30px;
            color: #cbc9c9;
            margin-top: 50px;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            letter-spacing: 2px;
            font-family: 'Arial', sans-serif;
        }
        a,span{
            margin-left: 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php
include "conexion.php";
include "Post.php";
session_start();
$usuario=$_SESSION["usuario"];
    echo("<h3><ion-icon name='person-circle-outline'></ion-icon> $usuario</h3>");
    echo("<br><input type='button' onclick='window.location.href=`paginaPrincipal.php`' value='Atrás'>");
if (isset($_SESSION["usuario"])){

    $pdo = new PDO($dsn, $username, $password, $opciones);
    $sql = 'SELECT id,titulo,contenido,autor FROM post WHERE autor=:aut ORDER BY fecha_publicacion ';
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(":aut",$usuario);
    $sentencia->setFetchMode(PDO::FETCH_CLASS, 'Post');
    $sentencia->execute();

    echo("<main>");
    echo("<h1>Mis Post</h1>");
    while ($post = $sentencia->fetch()) {
        echo ("
        <table border='1' onclick='window.location.href=`entrarPost.php?id={$post->getId()}`'>
            <tr><th>Titulo: {$post->getTitulo()}</th></tr>
            <tr><td><img src='{$post->getContenido()}' alt='Contenido'></td></tr>
            <tr><td>Autor: Usuario {$post->getAutor()}</td></tr>
        </table>
    ");
    }
}else{
    echo "Acceso no permitido";
}
?>
</body>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

