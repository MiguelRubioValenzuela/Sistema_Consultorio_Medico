<?php 
    include("LOGIN.php");
    include("script.php");
    
    $type = $_GET['tipo'];
    if($type == "registro")
    {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTH</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/sign_in.css">
</head>
<body>
    <div class="formulario">
        <h1>AUTORIZACION</h1>
       <form method="post" action="../conexion/conexion_auth.php?tipo=<?php echo $type?>">
                <div class="username">
                <label for="">Contraseña de administrador para autorizar:</label>
                    <input name="ID" type="password" onkeypress="return Solo_numeros(event)" maxlength="20" pattern=".{1,20}" title="Se requiere ID max 20 caracteres." required>
                </div>
                <button>Autorizar registro.</button>
                <div class="registrarse">
                    ¿No tienes ID de autorizacion? <a href="Main.php">Volver a inicio.</a>
                </div>
            </form>
    </div>
</body>
</html>

<?php
    }elseif($type == "abastecer")
    {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTH</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/sign_in.css">
</head>
<body>
    <div class="formulario">
        <h1>AUTORIZACION</h1>
       <form method="post" action="../conexion/conexion_auth.php?tipo=<?php echo $type?>">
                <div class="username">
                <label for="">Contraseña de administrador para autorizar:</label>
                    <input name="ID" type="password" onkeypress="return Solo_numeros(event)" maxlength="20" pattern=".{1,20}" title="Se requiere ID max 20 caracteres." required>
                </div>
                <form action="">
                    <button>Autorizar abastecimiento.</button>
                </form>
                <div class="registrarse">
                    ¿No tienes ID de autorizacion? <a href="Main.php">Volver a inicio.</a>
                </div>
            </form>
    </div>
</body>
</html>

<?php
    }elseif($type == "modificar")
    {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTH</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/sign_in.css">
</head>
<body>
    <div class="formulario">
        <h1>AUTORIZACION</h1>
       <form method="post" action="../conexion/conexion_auth.php?tipo=<?php echo $type?>">
                <div class="username">
                <label for="">Contraseña de administrador para autorizar:</label>
                    <input name="ID" type="password" onkeypress="return Solo_numeros(event)" maxlength="20" pattern=".{1,20}" title="Se requiere ID max 20 caracteres." required>
                </div>
                <form action="">
                    <button>Autorizar modificacion.</button>
                </form>
                <div class="registrarse">
                    ¿No tienes ID de autorizacion? <a href="Main.php">Volver a inicio.</a>
                </div>
            </form>
    </div>
</body>
</html>

<?php
    }
?>