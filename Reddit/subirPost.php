<?php
session_start();
if (isset($_SESSION["usuario"])){
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
    <h2>Post</h2>
    <form enctype='multipart/form-data' action='postSubido.php'  method='POST''>
        <label for='titulo'>Titulo:</label>
        <input type='text' id='titulo' name='titulo' required><br><br>
        <label for='contenido'>Imagen para subir:</label>
        <input type='file' id='contenido' name='contenido' required><br><br>
        <label for='desc'>Descripción:</label><br>
        <textarea name='desc' id='desc' placeholder='Escribe aquí...(max. 50)' maxlength='100' rows='2' cols='50' required></textarea><br><br>
        <input type='submit' name='Subido' value='Subir Post'>
        <input type='button' value='Volver a la página principal' onclick='window.location.href=`paginaPrincipal.php`'>
    </form>
    </body>
    </html>
    ");
}else{
    echo("No se puede subir un post sin iniciar sesión<br><br>");
    echo("<input type='button' value='Iniciar sesión' onclick='window.location.href=`login.php`'>");
    echo("<input type='button' value='Volver a la página principal' onclick='window.location.href=`paginaPrincipal.php`'>");
}

?>