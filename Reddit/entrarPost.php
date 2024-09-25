<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Reddit</title>
    <style>
        #iconoLogin{
            width: 30px;
            height: 30px;
            margin: 0px;
        }
        body{
            background-color: #6b888f;
            color: white;
        }
        p{
            margin: 5px;
            border: solid black 1px;
            border-radius: 7%;
            background-color: #cecbcb;
            width: 130px;
            height: auto;
            padding: 10px;
            color: black;
        }
        div{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 500px;
            height: auto;
        }
        table{
            background-color: #566493;
            text-align: center;
            width: 500px;
            height: 500px;

        }
        img{
            width: 400px;
            height: 300px;
        }
        a{
            text-decoration: none;
            color: black;
        }
        a:hover{
            color: red;
        }
        #comentario{
            width: 200px;
            height: auto;
            padding: 10px;
            margin-top: 20px;
            margin-right: 55%;
        }

        .comment-input,.comentarios {
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            resize: vertical;
        }
        .comentarios .editarC{
            margin-left:100px;
            color: blue;
        }
        .comentarios .editarC:hover{
            color: #808040;
        }
        .comentarios .borrarC{
            margin-left:20px;
            color: blue;
        }
        .comentarios .borrarC:hover{
            color: #808040;
        }
        main{
            width: auto;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-items: center;
            align-items: center;
        }
        th{
            font-size: 30px;
        }

    </style>
</head>
<body>

    <?php
    session_start();
    if (!isset($_SESSION["usuario"])){
        echo("<a href='login.php'><ion-icon id='iconoLogin' name='person-circle-outline'></ion-icon></a>");
        echo("<br><input type='button' onclick='window.location.href=`paginaPrincipal.php`' value='Volver a la página principal'>");
    }else{
        $usuario=$_SESSION["usuario"];
        echo("<h3><ion-icon name='person-circle-outline'></ion-icon> $usuario</h3>
          <input type='button' onclick='window.location.href=`paginaPrincipal.php`' value='Volver a la página principal'>
    ");
    }
    include "conexion.php";
    include "Post.php";
    include "Comments.php";
    $conexion = new PDO($dsn, $username, $password, $opciones);
    $sql = 'SELECT id,titulo,contenido,descripcion,autor FROM post where id=:id';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindParam(":id",$_GET["id"]);
    $sentencia->setFetchMode(PDO::FETCH_CLASS, 'Post');
    $sentencia->execute();

    while ($post = $sentencia->fetch()) {
        $idPost=$post->getId();
        echo ("
<main>
    <div>
        <table border='1'`'>");
            //Si el usuario que ha iniciado sesión es el que ha creado el post, podrá borrarlo o editarlo
            if (isset($_SESSION["usuario"])&&($post->getAutor() === $_SESSION["usuario"])){
                echo("<input type='button' onclick='window.location.href=`preguntarBorrarPost.php?id={$idPost}`' value='Borrar Post'><input type='button' onclick='window.location.href=`editarPost.php?id={$idPost}`' value='Editar Post'>");
            }
            echo ("
            <tr><th>{$post->getTitulo()}</th></tr>
            <tr><td><img src='{$post->getContenido()}' alt='Contenido'></td></tr>
            <tr><td>Autor:<br>{$post->getAutor()}</td></tr>
            <tr><td>Descripción:<br>{$post->getDescripcion()}</td></tr>
        </table>
        ");
        //Consulta para los votos positivos de este post
        $cantidadVotosP = $conexion->prepare("select count(*) from votospositivos where id_post=:idPost");
        $cantidadVotosP->bindParam(":idPost", $idPost);
        $cantidadVotosP->execute();
        $cantP = $cantidadVotosP->fetchColumn();

        //Consulta para los votos negativos de este post
        $cantidadVotosN = $conexion->prepare("select count(*) from votosnegativos where id_post=:idPost");
        $cantidadVotosN->bindParam(":idPost", $idPost);
        $cantidadVotosN->execute();
        $cantN = $cantidadVotosN->fetchColumn();

        //Aquí muestro la cantidad de votos positivos y negativos que tiene el post
        echo("<p> {$cantP} <a href='votoPositivo.php?id={$idPost}'><ion-icon id='like' name='arrow-up-outline'></ion-icon></a> Votar <a href='votoNegativo.php?id={$post->getId()}'><ion-icon like='disLike' name='arrow-down-outline'></ion-icon></a> {$cantN} </p>");

        echo ("
        <form action='aniadirComentario.php?id={$idPost}' method='post'>
            <input id='comentario' type='submit' value='+ Añadir comentario'>
            <input type='text' required name='coment' class='comment-input' maxlength='100' placeholder='Escribe tu comentario aquí...'>
        </form>
    ");
    }
    $sql2 = 'SELECT * FROM comentario where id_post=:id order by fecha_publicacion desc ';
    $comentariosPost = $conexion->prepare($sql2);
    $comentariosPost->bindParam(":id",$_GET["id"]);
    $comentariosPost->setFetchMode(PDO::FETCH_CLASS, 'Comments');
    $comentariosPost->execute();
    while ($comentario = $comentariosPost->fetch()){
        echo("    
            <span class='comentarios'>
                <span class='autorComentario'>{$comentario->getNombreComentador()} </span><br>
                <input type='text' name='comentarios' class='comentarios' disabled value='{$comentario->getContenido()}'>
        ");
        if (isset($_SESSION["usuario"])&&($comentario->getNombreComentador() === $_SESSION["usuario"])){
            echo("
                <span class='fechaComentario'>{$comentario->fecha_publicacion} 
                    <a class='editarC' href='editarComentario.php?idC={$comentario->getIdComentario()}&&idP={$_GET["id"]}'>Editar</a>
                    <a class='borrarC' href='preguntarBorrarComent.php?idC={$comentario->getIdComentario()}&&idP={$_GET["id"]}'>Borrar</a>
                </span>
            </span>
            ");
        }else {
            echo("
                <span class='fechaComentario'>{$comentario->fecha_publicacion}</span>
            </span>
            ");
        }
    }
    echo("</div>
</main>");
    ?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

