<?php
session_start();
if (isset($_SESSION["usuario"])){
    $idPost=$_GET["idP"];
    $idComentario=$_GET["idC"];
    echo("
        <script>
            let confirmado=confirm('¿Estas seguro de que quieres borrarlo?')
            if (confirmado){
                window.location.href=`borrarComentario.php?idC={$idComentario}&&idP={$idPost}`;
            }else{
                window.location.href=`entrarPost.php?id={$idPost}`;
            }
        </script>
    ");
}else{
    echo "Acceso no permitido";
}
?>
