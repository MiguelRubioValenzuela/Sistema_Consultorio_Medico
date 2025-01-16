<?php 








?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN IN</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/sign_in.css">

<?php  
    include("script.php");
?>

</head>
<body>
    <div class="formulario">
        <h1>INICIO DE SESION</h1>
        <form method="post" action="../conexion/conexion_sign_in.php">
            <div class="username">
                <input name="ID" type="text" onkeypress="return Solo_numeros(event)" maxlength="10" pattern=".{0,10}" title="Se requiere ID de 8 caracteres." required>
                <label for=""> ID user o cedula medica:</label>
            </div>
            <div class="username">
            <input name="password" type="password" pattern=".{7,20}" title="Se requiere Contraseña minimo 8 caracteres, maximo 20" maxlength="20" required>
                <label for="">Contraseña:</label>
            </div>
            <form action="">
                <button>INICIAR SESION</button>
            </form>
            <div class="registrarse">
                ¿Aún no estas registrado? <a href="../registrar/Registrar_usuario.php">Registrarse</a>
            </div>
        </form>
    </div>

</body>
</html>