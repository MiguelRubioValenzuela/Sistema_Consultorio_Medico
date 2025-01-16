<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Usuario</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/Registrar.css">

</head>
<body>

<?php
    include("../php/script.php");
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $obtiene_admin = "SELECT * FROM usuarios WHERE Tipo ='Admin'";
    $ID_admin = mysqli_query($link, $obtiene_admin);
    $admin = mysqli_num_rows($ID_admin);
    if($admin)
    {
        $obtiene_ID = "SELECT MAX(ID_usuario) AS maximo FROM usuarios WHERE Tipo != 'Medico'";
        $obtener_maximo = mysqli_query($link, $obtiene_ID);
        $row = $obtener_maximo->fetch_array();
        $new_id = $row['maximo']+1;
        $vector = array(0, 0, 0, 0, 0, 0, 0, 0);
        #Verifica y crea un nuevo id que sea diferente del nuevo maximo para agregar 8 digitos
        for($var = 7; $var >= 0; $var--)
        {
            $vector[$var] = $new_id % 10;
            $new_id /= 10;
        }
        $new_id = $vector[0].$vector[1].$vector[2].$vector[3].$vector[4].$vector[5].$vector[6].$vector[7];
?>
    <div class="formulario">
        <h1>Registrar nuevo usuario</h1>
        <form name="Data_Main" method="post" action="../conexion/conexion.php" >
        <label style="font-size: larger; text-align:center; margin-left:80px; font-weight:22px;">ID usuario: <?php echo $new_id?> o cedula medica</label>
            <div class="username">
                <input type="password"  pattern=".{6,20}" maxlength="20" name="IDs" title="Es obligatorio rellenar el ID del administrador con maximo 20 caracteres" required> 
                <label for=""> Contraseña Administrador:</label>
            </div>
            <div class="username">
                <input type="text" name="nombre" onkeypress="return Solo_letras(event);">
                <label for="">Nombre completo:</label>
            </div>
            <div class="username">
                <input type="email" name="email" title="Se requiere obligatoriamente el email" required>
                <label for=""> Correo electronico:</label>
            </div>
            <div class="username">
                <input type="password" name="password" pattern=".{8,20}" title="Se requiere Contraseña minimo 8 caracteres, maximo 20" maxlength="20" required>
                <label> Contraseña:</label>
            </div>
            <div class="username">
                <input type="tel" name="telefono" pattern=".{10,10}" title="El telfono requiere 10 digitos" maxlength="10" onkeypress="return Solo_numeros(event)">
                <label for=""> Telefono:</label>
            </div>
            <div class="username">
                <input type="text" name="curp" pattern=".{18,18}" title="La CURP requiere 18 caracteres" maxlength="18" onkeyup="this.value=this.value.toUpperCase(); required">
                <label for=""> CURP:</label>
            </div>
                <p id="tipo">Tipo de usuario: </p>
                <select name="type" id="seleccion">
                    <option value="Encargado">Encargado en caja</option>
                    <option value="Medico">Medico</option>
                </select>
            <div class="username">
                <input type="tel" name="cedula_medica" id="cedula" disabled placeholder="Ingrese entre 9 y 10 digitos obligatoriamente:" onkeypress="return Solo_numeros(event)" pattern=".{9,10}" maxlength="10" title="Es obligatorio rellenar la cedula medica con un minimo de 8 caracteres"> 
                <label> Cedula medica:</label>
            </div>
            <script src="../JS/Habiltar.js"></script>
            <button id="enviar">Registrar</button>
            
            <div class="registrarse">
                Volver a  <a href="../php/Sign_in.php">Inicio de sesion</a>
            </div>
        </form>
    </div>
<?php
    }else{
?>
    <div class="formulario">
        <h1>Registrar nuevo Administrador</h1>
        <form name="Data_Main" method="post" action="../conexion/conexion.php?IDs=0&type=Admin" >
                <label style="font-size: larger; text-align:center; margin-left:130px">ID de administrador: 00000000</label>
            <div class="username">
                <input type="text" name="nombre" onkeypress="return Solo_letras(event);">
                <label for="">Nombre completo:</label>
            </div>
            <div class="username">
                <input type="email" name="email" title="Se requiere obligatoriamente el email" required>
                <label for=""> Correo electronico:</label>
            </div>
            <div class="username">
                <input type="password" name="password" pattern=".{8,20}" title="Se requiere Contraseña minimo 8 caracteres, maximo 20" maxlength="20" required>
                <label> Contraseña:</label>
            </div>
            <div class="username">
                <input type="tel" name="telefono" pattern=".{10,10}" title="El telfono requiere 10 digitos" maxlength="10" onkeypress="return Solo_numeros(event)">
                <label for=""> Telefono:</label>
            </div>
            <div class="username">
                <input type="text" name="curp" pattern=".{18,18}" title="La CURP requiere 18 caracteres" maxlength="18" onkeyup="this.value=this.value.toUpperCase();" required>
                <label for=""> CURP:</label>
            </div>
            <script src="../JS/Habiltar.js"></script>
            <button id="enviar">Registrar</button>
            
            <div class="registrarse">
                Volver a  <a href="../php/Sign_in.php">Inicio de sesion</a>
            </div>
        </form>
    </div>
<?php
    }
?>
</body>
</html>
