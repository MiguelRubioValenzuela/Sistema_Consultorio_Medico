<?php
    include("../php/LOGIN.php");
    include("../php/script.php");
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $Curp_paciente = $_GET['curp'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificacion Paciente</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/modificar_paciente.css">
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
            <li><a href="../registrar/Registrar_paciente.php">Registro nuevos usuarios.</a>
                <p>El registro solo es para pacientes nuevos.</p>
            </li>
            <br>
            <li><a href="../consulta/Consulta_pacientes.php"> Visualizar registro de paciente.</a>
                <p>
                    Si quiere modificar registo dirijase a la siguiente seccion.
                </p>
            </li>
            <br>
            <li><a href="../php/Main.php">Volver a inicio.</a>
                <p>
                    Para regresar a el menu inicial puede
                    acceder a "Inicio." en la parte superior de la pantalla.
                    o acceder desde este enlace. 
                </p>
            </li>
        </div>
<?php
$obtener_datos = "SELECT * FROM paciente WHERE Curp_paciente = '$Curp_paciente';";
$resultado = mysqli_query($link, $obtener_datos);
if($resultado -> num_rows > 0){
    $mostrar = mysqli_fetch_array($resultado);
    if($mostrar['sexo'] == 'M')
        $sexo = 'Masculino';
    if($mostrar['sexo'] == 'F')
        $sexo = 'Femenino';
    if($mostrar['sexo'] == 'X')
        $sexo = 'Sin especificar';
?>
        <div class="contenedor2">
            <div class="info">
                <h1>
                    VISUALIZACION DE REGISTRO DEL PACIENTE.
                </h1>
                <li> 
                    <h2>CURP:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Curp_paciente'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Nombre Completo:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Nombre_completo_paciente'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Telefono:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Telefono_paciente'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Correo electronico:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Correo_electronico_paciente'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Fecha de nacimiento:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Fecha_nacimiento'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Sexo:</h2>
                    <div class="text">
                        <p><?php echo $sexo;?></p>
                    </div>
                </li>
            </div>
            <div class="info">
                <form method="post"  action="../conexion/conexion_modificar_paciente.php?curp_paciente=<?php echo $Curp_paciente?>">
                    <h1>MODIFICACION DE REGISTRO.</h1>
                <li> 
                    <h2>Ingrese CURP actual:</h2>
                    <input name="curp" type="text" pattern=".{18,18}" maxlength="18" onkeyup="this.value=this.value.toUpperCase();">
                </li>
                <li> 
                    <h2>Ingrese Nombre actual:</h2>
                    <input name="nombre" type="text"  onkeypress="return Solo_letras(event);">
                </li>
                <li> 
                    <h2>Ingrese Telefono actual:</h2>
                    <input name="telefono" type="tel"  onkeypress="return Solo_numeros(event)" pattern=".{10,10}" maxlength="10" title="El telfono requiere 10 digitos">
                </li>
                <li> 
                    <h2>Ingrese Email actual:</h2>
                    <input name="correo" type="email"  title="Se requiere obligatoriamente el email">
                </li>
                    <button class="actualizar" onclick="return confirma_modificacion()">Actualizar registro.</button>   
                </form>
                <div class="mover">
                    <form method="post" action="../conexion/conexion_eliminar_paciente.php?curp_paciente=<?php echo $Curp_paciente?>">   
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