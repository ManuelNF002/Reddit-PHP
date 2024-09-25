<?php
session_start();
if (isset($_SESSION["usuario"])){
    include "conexion.php";
    $pdo = new PDO($dsn, $username, $password, $opciones);
    $idPost=$_GET["id"];
    $borrarSelec=$pdo->prepare("DELETE FROM post WHERE id=:id");
    $borrarSelec->bindParam(":id",$idPost);
    $borrarSelec->execute();
    echo("
        <script>
            alert('Post borrado correctamente.');
            window.location.href=`paginaPrincipal.php`;
        </script>
    
    ");
}else{
    echo "Acceso no permitido";
}
