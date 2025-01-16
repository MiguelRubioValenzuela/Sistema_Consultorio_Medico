<?php
session_start();
$_SESSION['user'] = '';
header("location:sign_in.php");
?>