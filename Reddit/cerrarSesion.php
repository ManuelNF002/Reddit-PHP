<?php
//En este archivo.php cierro la session y borro la cookie.
session_start();

session_unset();

session_destroy();

if (isset($_COOKIE['token'])) {
    setcookie('token', "", time() - 100);
}
header('Location: paginaPrincipal.php');
exit();
?>