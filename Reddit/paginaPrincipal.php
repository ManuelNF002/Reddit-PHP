<?php
include "conexion.php";
session_start();
//Compruebo si existe la cookie para iniciar sesión
if (isset($_COOKIE['token'])){
    $pdo = new PDO($dsn, $username, $password, $opciones);
    $recordarToken = $pdo->prepare("SELECT usuario from usuario WHERE token = :token");
    $recordarToken->bindParam(":token", $_COOKIE['token']);
    $recordarToken->execute();
    $result = $recordarToken->fetch();
    $_SESSION["usuario"]=$result["usuario"];
}
?>
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
            }
            body{
                background-color: #6b888f;
                color: white;
            }
            table{
                background-color: #566493;
                text-align: center;
                width: 500px;
                height: 500px;
                color: white;
                margin-bottom: 30px;
            }
            main{
                width: auto;
                height: auto;
                display: flex;
                flex-direction: column;
                justify-items: center;
                align-items: center;
            }
            img{
                width: 400px;
                height: 300px;
            }
            h1{
                font-size: 70px;
                color: #cbc9c9;
                margin-top: 50px;
                margin-bottom: 30px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
                letter-spacing: 2px;
                font-family: 'Arial', sans-serif;
            }
            a,span{
                margin-left: 10px;
                text-decoration: none;
            }
        </style>
    </head>
    <body>

<?php
//Si no ha iniciado sesion se mostrará un icono donde podrá darle para iniciar sesion, si ya está logeado o se logea, saldrá
//el nombre de usuario y varios botones para subir post, cerrar sesion y ver todos los post que ha subido ese usuario.
if (!isset($_SESSION["usuario"])){
    echo("<a href='login.php'><ion-icon id='iconoLogin' name='person-circle-outline'></ion-icon></a>");
}else{
    $usuario=$_SESSION["usuario"];
    echo("<h3><ion-icon name='person-circle-outline'></ion-icon> $usuario</h3>
          <input type='button' value='Subir post' onclick='window.location.href=`subirPost.php`'>
          <input type='button' onclick='window.location.href=`cerrarSesion.php`' value='Cerrar Sesión'><br>
          <input type='button' onclick='window.location.href=`verMisPost.php`' style='margin-top: 3px' value='Ver mis Posts'>
    ");
}
include "conexion.php";
include "Post.php";
$conexion = new PDO($dsn, $username, $password, $opciones);

//----------------------------------------------------------------------------------------------------------------------
//Aquí realizo todo lo realcionado con la paginación, en cuanto a las consultas.
// Definir la cantidad de resultados por página
$resultados_por_pagina = 5;
// Comprobar página actual
if (isset($_GET['pagina'])) {
    $pagina_actual = $_GET['pagina'];
} else {
    $pagina_actual = 1;
}
// Calcular el inicio del resultado para la consulta
$inicio = ($pagina_actual - 1) * $resultados_por_pagina;
// Consulta para obtener el total de filas
$total_filas_query = "SELECT COUNT(*) as total_filas FROM post";
$total_filas_result = $conexion->query($total_filas_query);
$total_filas = $total_filas_result->fetch(PDO::FETCH_ASSOC)['total_filas'];
// Calcular el total de páginas
$total_paginas = ceil($total_filas / $resultados_por_pagina);
// Consulta para obtener los resultados de la página actual

//----------------------------------------------------------------------------------------------------------------------
//Aqui recorro todos los post para mostrarlos en tablas
$sql = 'SELECT id,titulo,contenido,autor FROM post ORDER BY fecha_publicacion DESC LIMIT :inicio, :resultados_por_pagina';
$sentencia = $conexion->prepare($sql);
$sentencia->bindParam(':inicio', $inicio, PDO::PARAM_INT);
$sentencia->bindParam(':resultados_por_pagina', $resultados_por_pagina, PDO::PARAM_INT);
$sentencia->setFetchMode(PDO::FETCH_CLASS, 'Post');
$sentencia->execute();
echo("<main>");
echo("<h1>Reddit</h1>");
while ($post = $sentencia->fetch()) {
    echo ("
        <table border='1' onclick='window.location.href=`entrarPost.php?id={$post->getId()}`'>
            <tr><th>Titulo: {$post->getTitulo()}</th></tr>
            <tr><td><img src='{$post->getContenido()}' alt='Contenido'></td></tr>
            <tr><td>Autor: Usuario {$post->getAutor()}</td></tr>
        </table>
    ");
}
//-----------------------------------------------------------------------------------------------------
// Aqui muestro los enlaces de la paginacion, que serían las páginas y le doy funcionalidad
echo("<div>");
if ($pagina_actual > 1){
    $pagina_anterior = $pagina_actual - 1;
    echo("<a href='?pagina=$pagina_anterior'>Anterior</a>");
}
for ($i = max(1, $pagina_actual - 2); $i <= min($pagina_actual + 2, $total_paginas); $i++){
    if ($i == $pagina_actual) {
        echo("<span> $i </span>");
    }else{
            echo("<a href='?pagina=$i'> $i </a>");
        }
    }
if ($pagina_actual < $total_paginas){
    $pagina_siguiente = $pagina_actual + 1;
    echo("<a href='?pagina=$pagina_siguiente'> Siguiente </a>");
}
echo ("</div>");
//-----------------------------------------------------------------------------------------------------
echo("</main>");
?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
