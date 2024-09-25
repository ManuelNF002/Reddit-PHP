<?php
session_start();
if (isset($_SESSION["usuario"])){

            include "conexion.php";
            $pdo = new PDO($dsn, $username, $password, $opciones);
            $contenidoNuevo=$_POST["cont"];
            $idComentario=$_GET["idC"];
            $idPost=$_GET["idP"];
            $stmt = $pdo->prepare("UPDATE comentario SET contenido = :cont WHERE id_comentario = :id");
            $stmt->bindValue(":cont", $contenidoNuevo);
            $stmt->bindParam("id",$idComentario);
            $stmt->execute();

            echo("
                <script>
                    alert('Comentario editado');
                    window.location.href=`entrarPost.php?id={$idPost}`;
                </script>
            ");

}else{
    echo("Acceso no permitido");
}
