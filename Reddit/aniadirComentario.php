<?php
session_start();
if (isset($_SESSION["usuario"])){
    include "conexion.php";
    $pdo = new PDO($dsn, $username, $password, $opciones);
    $valueComentario=$_POST["coment"];
    $autorComentario=$_SESSION["usuario"];

    $stmt = $pdo->prepare("INSERT INTO comentario (id_post, nombreComentador, contenido) VALUES (:idPost, :nomb, :cont)");
    $stmt->bindParam(":idPost", $_GET["id"]);
    $stmt->bindParam(":nomb", $autorComentario);
    $stmt->bindParam(":cont", $valueComentario);
    $stmt->execute();

    header("Location: entrarPost.php?id={$_GET["id"]}");
    exit();
}else{
    header("Location: login.php");
    exit();
}



