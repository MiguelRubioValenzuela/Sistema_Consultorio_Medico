<?php
    include("../php/LOGIN.php");
    include("../php/script.php");
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $folio = $_GET['folio'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificacion medicamentos</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/modifica_medicamento.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body class="cuerpo">
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
            <li><a href="../consulta/consulta_cita_agendada.php?folio=<?php echo $folio?>">Volver a la pagina anterior.</a>
                <p> Da click en el enlace anterior para volver a la pagina de la que vienes, y usar una opcion diferente a la que usó.</p>
            </li>
            <br>
            <li><a href="../consulta/Consulta_cita.php">Consulta y/o registra cita.</a>
                <p>Si quiere modificar un medicamento de clic en el link anterior.</p>
            </li>
            <br>
            <li><a href="../php/Main.php">Volver a inicio.</a>
                <p> Para regresar a el menu inicial puede
                    acceder a "Inicio." en la parte superior de la pantalla.
                    o acceder desde este enlace.  .</p>
            </li>
        </div>
<?php
$obtener_datos = "SELECT * FROM citas WHERE Folio_cita = '$folio';";
$resultado = mysqli_query($link, $obtener_datos);
if($resultado -> num_rows > 0){
    $mostrar = mysqli_fetch_array($resultado);
$id_usuario = $mostrar['ID_Usuario'];
$curp = $mostrar['CURP_Paciente'];

$obtener_usuario = "SELECT Nombre_completo_usuario FROM usuarios WHERE ID_usuario = '$id_usuario';";
$USER = mysqli_query($link, $obtener_usuario);
$Nombre_usuario = mysqli_fetch_array($USER);

$obtener_paciente = "SELECT Nombre_completo_paciente FROM paciente WHERE CURP_Paciente = '$curp';";
$pac = mysqli_query($link, $obtener_paciente);
$paciente = mysqli_fetch_array($pac);
?>
        <div class="contenedor2">
            <div class="info" style="background-color:gainsboro; height:900px;">
                <h1 class="header">
                    Datos de la cita
                </h1>
                <li> 
                    <h2>Numero de cita:</h2>
                    <div class="text">
                        <p><?php echo $folio;?></p>
                    </div>
                </li>
                <li> 
                    <h2>Nombre del paciente :</h2>
                    <div class="text">
                        <p><?php echo $paciente['Nombre_completo_paciente'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Fecha de la cita:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Fecha_inicio'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Hora de inicio de cita:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Hora_inicio'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Hora de fin de cita estimada:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Hora_fin'];?></p>
                    </div>
                </li>
                <br>
                <br>
                <br>
                <li> 
                    <h2>Encargado que lo registró:</h2>
                    <div class="text">
                        <p><?php echo $Nombre_usuario['Nombre_completo_usuario'];?></p>
                    </div>
                </li>
            </div>
            <div class="info2" style="background-color:gainsboro; height:700px;"> 
                <form method="post"  action="../conexion/conexion_modifica_cita.php?folio=<?php echo $folio?>">
                <h1 class="header">MODIFICACION DE CITA.</h1>
                <li> 
                    <h2>Fecha de la cita:</h2>
                    <input name="fecha" type="date">
                </li>
                <li> 
                      <h2>Hora de inicio de cita: </h2>
                      <input name="hora_inicio" type="time" required>
                </li>
                <li> 
                      <h2>Hora final de cita estimada:</h2>
                      <input name="hora_fin" type="time" required>
                </li>
                <button class="actualizar" onclick="return confirma_modificacion()" style="margin-left:250px;">Actualizar registro.</button>   
                </form>
                <h2 style="margin: 40px; font-weight:normal">
                    Nota: Vease horarios disponibles primero antes de modificar, si la fecha que registra interviene con una ya registrada no se podra modificar la cita.
                </h2>
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