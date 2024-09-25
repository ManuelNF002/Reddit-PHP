<?php
session_start();
if (isset($_SESSION["usuario"])) {
    include "conexion.php";
    $pdo = new PDO($dsn, $username, $password, $opciones);
    $idPost = $_GET["id"];
    echo("
        <script>
            let confirmacion = confirm('¿Seguro que quieres borrar la publicación?');
            if (confirmacion){
                window.location.href=`borrarPost.php?id={$idPost}`;
            }else{
                window.location.href=`entrarPost.php?id={$idPost}`;
            }
        </script>
    
    ");
} else {
    echo "Acceso no permitido";
}
