<?php
session_start();
if (isset($_SESSION["usuario"])){
    $idPost=$_GET["id"];
    echo("
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Subir Post</title>
        <style>
            body{
                background-color: #6b888f;
                color: white;
            }
        </style>
    </head>
    <body>
    <h2>Editar Post con ID $idPost</h2>
    <form enctype='multipart/form-data' action='confirmarEditarPost.php?id=$idPost'  method='POST''>
        <label for='titulo'>Cambiar Titulo:</label>
        <input type='text' id='titulo' name='titulo' required><br><br>
        <label for='contenido'>Cambiar imagen:</label>
        <input type='file' id='contenido' name='contenido' required><br><br>
        <label for='desc'>Descripción:</label><br>
        <textarea name='desc' id='desc' placeholder='Escribe aquí...(max. 50)' maxlength='100' rows='2' cols='50' required></textarea><br><br>
        <input type='submit' name='editar' value='Confirmar'>
        <input type='button' value='Cancelar' onclick='window.location.href=`entrarPost.php?id={$idPost}`'>
    </form>
    </body>
    </html>
    ");
}else{
    echo "Acceso no permitido";
}
