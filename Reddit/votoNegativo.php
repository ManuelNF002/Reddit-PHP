<?php
include "conexion.php";
session_start();
if (isset($_SESSION["usuario"])){
    $idPost=$_GET["id"];
    $usuarioVotador=$_SESSION["usuario"];
    $pdo = new PDO($dsn, $username, $password, $opciones);

    //Esta es la consulta para comprobar si este usuario ha votado o no anteriormente
    $consulta = $pdo->prepare("SELECT * FROM votosnegativos WHERE id_post=:idPost AND usuario=:usu");
    $consulta->bindParam(":idPost", $idPost);
    $consulta->bindParam(":usu", $usuarioVotador);
    $consulta->execute();
    $result = $consulta->fetch();

    //Si no ha votado se guardará su voto, si ha votado no podrá volver a votar.
    if (!$result){
        //Aquí se guarda el voto negativo del usuario en la BBDD
        $stmt = $pdo->prepare("INSERT INTO votosnegativos (id_post, usuario) VALUES (:idP, :usu)");
        $stmt->bindParam(":idP", $idPost);
        $stmt->bindParam(":usu",$usuarioVotador);
        $stmt->execute();

        //Aqui compruebo si este usuario ha votado positivamente para borrarlo y dejar solo el voto negativo, ya que solo se
        //puede votar uno u otro
        $usuarioVotoP = $pdo->prepare("SELECT * FROM votospositivos WHERE usuario=:usu AND id_post=:idPost");
        $usuarioVotoP->bindParam(":usu", $usuarioVotador);
        $usuarioVotoP->bindParam(":idPost", $idPost);
        $usuarioVotoP->execute();
        $votoUsuP = $usuarioVotoP->fetch();

        //Si este usuario votó positivamente se borrará para dejar solo el negativo, de esta manera solo se podrá
        //tener un voto positivo o un voto negativo
        if ($votoUsuP){
            //Tengo que hacer un header porque sinó no funciona, por alguna razón no se ejecuta la consulta delete,
            //de esta forma si funciona
            header("Location: borrarVoto.php?idPost={$idPost}&&tabla=votospositivos");
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