<?php
    session_start();
    $usuario = $_SESSION['user'];
    if(!$usuario)
    header("location:../php/Sign_in.php");

?>