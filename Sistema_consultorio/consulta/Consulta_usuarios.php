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
    <title>USUARIOS</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/ver.css">
    <link rel="stylesheet" href="../CSS/Consulta_perfil.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body>
    <header>   
        <div class="container">
            <p class="logo">Consulta_Pacientes.</p>
            <nav>
                <a href="../php/Main.php">Inicio.</a>
                <a href="Consulta_cita.php">Citas.</a>
                <a href="../consulta/Consulta_ventas.php">Ventas.</a>
                <a href="Consulta_abastecimiento.php">Abastecer.</a>
                <a href="consulta_pacientes.php">Pacientes.</a>
                <a href="Consulta_usuarios.php">Usuario.</a>
            </nav>
        </div>
    </header>
    <div class="contenedor">
        <div class="carta">
            <h1>Paginas a visitar.</h1>
            <li><a href="../php/Main.php">Volver a inicio.</a>
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
            <li><a id="cerrar" onclick="return confirma_cierre_sesion()" href="../php/Log_out.php">Cerrar sesión.</a>
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
    elseif($mostrar['Tipo'] == "Medico"){
        $tipo = "Medico";
    }else{
        $tipo = "Admin";
    }
?>
        <div class="cont">
            <div class="information">
                <h1>VISUALIZACION DE PERFIL USUARIO.</h1>
                <h1>Bienvenido.</h1>
                <h1 id="nombre"><?php echo $mostrar['Nombre_completo_usuario'];?></h1>
                <p id="p"> Aqui se muestra la informacion de perfil del usuario con  <br> numero de identificacion <?php echo $mostrar['ID_usuario'];?> 
                     que inició sesión en la plataforma.
                </p>
                <div class="Just">
                    <li class="text"> 
                        <h2>CURP de usuario conectado:</h2>
                        <div class="data">
                            <p><?php echo $mostrar['Curp_usuario'];?></p>
                        </div>
                    </li>
                    <li class="text"> 
                        <h2>Numero de identificacion: </h2>
                        <div class="data">
                            <p> <?php echo $mostrar['ID_usuario'];?></p>
                        </div>
                    </li>
                </div>
                <div class="just">
                    <li class="text"> 
                        <h2>Nombre del usuario actual:</h2>
                        <div class="data">
                            <p><?php echo $mostrar['Nombre_completo_usuario'];?></p>
                        </div>
                    </li>
                    <li class="text"> 
                        <h2>Telefono del usuario:</h2>
                        <div class="data">
                            <p><?php echo $mostrar['Telefono_usuario'];?></p>
                        </div>
                    </li>
                </div>
                <div class="just">
                    <li class="text"> 
                        <h2>Tipo de usuario que maneja este perfil:</h2>
                        <div class="data">
                            <p><?php echo $tipo?></p>
                        </div>
                    </li>
                    <li class="text"> 
                        <h2>Correo electronico:</h2>
                        <div class="data">
                            <p><?php echo $mostrar['Correo_electronico_usuario'];?></p>
                        </div>
                    </li>
                </div>
            </div>
            <div class="margin">
                <a id="mod" href="../modificar/modificar_usuario.php">Modificar.</a>
            </div>
        </div>
        <?php
}
        ?>
    </div>
</body>
</html>