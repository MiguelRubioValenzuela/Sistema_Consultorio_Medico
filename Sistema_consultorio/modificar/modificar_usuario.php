<?php
    include("../php/LOGIN.php");
    include("../php/script.php");
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificacion Usuarios</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/modificar_paciente.css">
    <link rel="stylesheet" href="../CSS/modifica_usuario.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body>
    <header>   
        <div class="container">
            <p class="logo">Consulta_Pacientes.</p>
            <nav>
                <a href="../php/Main.php">Inicio.</a>
                <a href="../consulta/Consulta_cita.php">Citas.</a>
                <a href="../consulta/Consulta_ventas.php">Ventas.</a>
                <a href="../consulta/Consulta_abastecimiento.php">Abastecer.</a>
                <a href="../consulta/consulta_pacientes.php">Pacientes.</a>
                <a href="../consulta/Consulta_usuarios.php">Usuario.</a>
            </nav>
        </div>
    </header>
    <div class="contenedor">
        <div class="carta">
        <h1>Paginas a visitar.</h1>
            <li><a href="../consulta/Consulta_usuarios.php">Visualizar perfil.</a>
                <p> Para regresar a el menu inicial puede
                    acceder a "Inicio." en la parte superior de la pantalla.
                    o acceder desde este enlace.  .</p>
            </li>
            <br>
            <li><a href="../modificar/modificar_usuario.php"> Modificar perfil.</a>
                <p>
                    Si quiere modificar si perfil de clic en el vinculo anterior.
                </p>
            </li>
            <br>
            <li><a href="../php/Main.php">Volver a inicio.</a>
                <p> Para regresar a el menu inicial puede
                    acceder a "Inicio." en la parte superior de la pantalla.
                    o acceder desde este enlace.  .</p>
            </li>
            <br>
            <li><a id="cerrar" onclick="return confirma_cierre_sesion()" href="Log_out.php">Cerrar sesión.</a>
                <p>
                    De clic en el menu anterior para cerrar la sesion del usuario.
                </p>
            </li>
            
        </div>
<?php
$obtener_datos = "SELECT * FROM usuarios WHERE ID_usuario = '$usuario';";
$resultado = mysqli_query($link, $obtener_datos);
if($resultado -> num_rows > 0){
    $mostrar = mysqli_fetch_array($resultado);
    if($mostrar['Tipo'] == "Encargado"){
        $tipo = "Encargado en caja";
    }
    else{
        $tipo = "Medico";
    }
?>
        <div class="contenedor2">
            <div class="info">
                <h1 class="header">
                    Datos del perfil de usuario.
                </h1>
                <li> 
                    <h2>Numero ID usuario:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['ID_usuario'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>CURP usuario:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Curp_usuario'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Nombre Completo:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Nombre_completo_usuario'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Correo electronico:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Correo_electronico_usuario'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Telefono:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Telefono_usuario'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Tipo de usuario:</h2>
                    <div class="text">
                        <p><?php echo $tipo;?></p>
                    </div>
                </li>
            </div>
            <div class="info">
                <form method="post"  action="../conexion/conexion_modificar_usuario.php?user=<?php echo $usuario?>">
                    <h1>MODIFICACION DE REGISTRO.</h1>
                <li> 
                    <h2>Ingrese CURP nueva:</h2>
                    <input name="curp" type="text" pattern=".{18,18}" maxlength="18" onkeyup="this.value=this.value.toUpperCase();">
                </li>
                <li> 
                    <h2>Ingrese Nombre nuevo:</h2>
                    <input name="nombre" type="text"  onkeypress="return Solo_letras(event);">
                </li>
                <li> 
                    <h2>Ingrese Telefono nuevo:</h2>
                    <input name="telefono" type="tel"  onkeypress="return Solo_numeros(event)" pattern=".{10,10}" maxlength="10" title="El telfono requiere 10 digitos">
                </li>
                <li> 
                    <h2>Ingrese Email nuevo:</h2>
                    <input name="correo" type="email"  title="Se requiere el email">
                </li>
                <li> 
                    <h2>Nueva contraseña:</h2>
                    <input name="password" type="password" pattern=".{8,20}" title="Se requiere Contraseña minimo 8 caracteres, maximo 20" maxlength="20">
                </li>
                <li> 
                    <h2>Confirme la contraseña:</h2>
                    <input name="confirm" type="password" pattern=".{8,20}" title="Se requiere Contraseña minimo 8 caracteres, maximo 20" maxlength="20">
                </li>
                    <button class="actualizar" onclick="return confirma_modificacion()">Actualizar registro.</button>   
                </form>
                <div class="mover">
                    <h2>Ingrese ID de administrador para eliminar registro.</h2>
                    <form method="post" action="../conexion/conexion_eliminar_usuario.php?user=<?php echo $usuario?>">
                        <input name="IDadmin" type="password" onkeypress="return Solo_numeros(event)" placeholder="ID administrador." maxlength="20" pattern=".{0,20}" title="Se requiere ID de max 20 caracteres.">   
                        <button class="eliminar" onclick="return eliminacion(event)">Eliminar Registro.</button>
                    </form> 
                </div>
            </div>
        </div>
        <?php
}else
{
        ?>
        <div class="contenedor2">
            <div class="info">
                <h1>
                    VISUALIZACION DE REGISTRO.
                </h1>
                 <h2>No hay registros de pacientes ingresados</h2>
            </div>
        </div>
        <?php
}
        ?>
    </div>
</body>
</html>