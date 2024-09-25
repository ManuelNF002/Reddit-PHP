<?php
include "conexion.php";
session_start();
if (isset($_SESSION["usuario"])){
    $idPost=$_GET["id"];
    $usuarioVotador=$_SESSION["usuario"];
    $pdo = new PDO($dsn, $username, $password, $opciones);

    //Esta es la consulta para comprobar si este usuario ha votado o no anteriormente
    $consulta = $pdo->prepare("SELECT * FROM votospositivos WHERE id_post=:idPost AND usuario=:usu");
    $consulta->bindParam(":idPost", $idPost);
    $consulta->bindParam(":usu", $usuarioVotador);
    $consulta->execute();
    $result = $consulta->fetch();

    //Si no ha votado se guardará su voto, si ha votado no podrá volver a votar.
    if (!$result){

        //Aquí se guarda el voto positivo del usuario en la BBDD
        $stmt = $pdo->prepare("INSERT INTO votospositivos (id_post, usuario) VALUES (:idP, :usu)");
        $stmt->bindParam(":idP", $idPost);
        $stmt->bindParam(":usu",$usuarioVotador);
        $stmt->execute();

        //Aqui compruebo si este usuario ha votado negativamente para borrarlo y dejar solo el voto positivo, ya que solo se
        //puede votar uno u otro
        $usuarioVotoN = $pdo->prepare("SELECT * FROM votosnegativos WHERE usuario=:usu AND id_post=:idPost");
        $usuarioVotoN->bindParam(":usu", $usuarioVotador);
        $usuarioVotoN->bindParam(":idPost", $idPost);
        $usuarioVotoN->execute();
        $votoUsuN = $usuarioVotoN->fetch();

        //Si este usuario votó negativamente se borrará para dejar solo el positivo, de esta manera solo se podrá
        //tener un voto positivo o un voto negativo
        if ($votoUsuN){
            //Tengo que hacer un header porque sinó no funciona, por alguna razón no se ejecuta la consulta delete,
            //de esta forma si funciona
            header("Location: borrarVoto.php?idPost={$idPost}&&tabla=votosnegativos");
            exit();
        }
        header("Location: entrarPost.php?id={$idPost}");
        exit();

    }else{
        header("Location: entrarPost.php?id={$idPost}");
        exit();
    }

}else{
    header("Location: login.php");
    exit();
}