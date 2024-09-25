<?php
session_start();
//Aquí lo que hago es pasar por la URL el id del post y que tabla va a modificarse
if (isset($_SESSION["usuario"])){
    echo("Entra");
    $idPost=$_GET["idPost"];
    $tabla=$_GET["tabla"];
    $usuarioVotador=$_SESSION["usuario"];
    include "conexion.php";
    $pdo = new PDO($dsn, $username, $password, $opciones);
    $borrarVN = $pdo->prepare("DELETE FROM $tabla WHERE usuario = :usu AND id_post = :idPost");
    $borrarVN->bindParam(":usu", $usuarioVotador);
    $borrarVN->bindParam(":idPost", $idPost);
    $borrarVN->execute();

    header("Location: entrarPost.php?id={$idPost}");
    exit();
}else{
    echo "Acceso no permitido";
}

