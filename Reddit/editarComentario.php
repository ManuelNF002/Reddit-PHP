<?php
session_start();
if (isset($_SESSION["usuario"])){
    $idComentario=$_GET["idC"];
    $idPost=$_GET["idP"];
    //Esta consulta es para recuperar el contenido del comentario antes de ser editado
    include "conexion.php";
    include "Comments.php";
    $pdo = new PDO($dsn, $username, $password, $opciones);
    $recComentario=$pdo->prepare("SELECT contenido FROM comentario WHERE id_comentario=:id");
    $recComentario->bindParam(":id",$idComentario);
    $recComentario->setFetchMode(PDO::FETCH_CLASS, 'Comments');
    $recComentario->execute();
    while ($comentario = $recComentario->fetch()){
        $contenidoActual=$comentario->getContenido();
    }
    echo("
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Editar Comentario</title>
        <style>
            input[type=text]{
                width: 500px;
                padding: 5px;
            }
            body{
                background-color: #6b888f;
                color: white;
            }
        </style>
    </head>
    <body>
    <h2>Editar tu comentario</h2>
    <form enctype='multipart/form-data' action='confirmarEditarComentario.php?idC={$idComentario}&&idP={$idPost}'  method='POST''>
        <label for='cont'>Cambiar contenido de tu comentario:</label><br>
        <input type='text' id='cont' name='cont' maxlength='100' value='$contenidoActual' placeholder='Escribe aquí...' required><br><br>
        <input type='submit' name='editar' value='Confirmar'>
        <input type='button' value='Cancelar' onclick='window.location.href=`entrarPost.php?id={$idPost}`'>
    </form>
    </body>
    </html>
    ");
}else{
    echo "Acceso no permitido";
}
