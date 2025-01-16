<?php
    include('../php/LOGIN.php');
    include('../PHP/script.php');
    $_SESSION['admin'] = '';
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $folio_citas = $_GET['folio'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta abastecimiento</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/consulta_cita.css">
    <!-- script JS -->
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
            <li><a href="../consulta/Consulta_cita.php">Regresar a agendar citas.</a>
                <p>Para regresar a la pagina anterior puedes entrar en el link anterior.</p>
            </li>
            <br>
            <?php
            if($_SESSION['admin'])
            {
?>
                <li><a href="../registrar/Registrar_abastecimiento.php">Abastecer medicamento.</a>
<?php   
            }
            else
            {
?>
                <li><a href="../php/auth.php?tipo=abastecer">Abastecer medicamento.</a>
<?php
            }
?>              <p>Si desea abastecer medicamentos que lleguen a el consultorio dirijase a el link anterior.</p>
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
        $obtiene_cita = "SELECT * FROM citas WHERE Folio_cita = '$folio_citas';";
        $GET_citas = mysqli_query($link, $obtiene_cita);
        $citas = mysqli_fetch_array($GET_citas);
        $curp = $citas['CURP_Paciente'];
        $id = $citas['ID_Usuario'];
        $obtiene_nombre = "SELECT Nombre_completo_paciente FROM paciente WHERE Curp_paciente = '$curp';";
        $obtiene_usuario = "SELECT Nombre_completo_usuario FROM usuarios WHERE ID_usuario = '$id';";
        $obtiene_tipo = "SELECT Tipo FROM usuarios WHERE ID_usuario = '$usuario';";
        $GET_CURP = mysqli_query($link, $obtiene_nombre);
        $GET_USER = mysqli_query($link, $obtiene_usuario);
        $GET_TYPE = mysqli_query($link, $obtiene_tipo);
        $paciente = mysqli_fetch_array($GET_CURP);
        $user = mysqli_fetch_array($GET_USER);
        $tipo = mysqli_fetch_array($GET_TYPE);
        $type = $tipo['Tipo'];
?>
        <div class="con">
            <div class="info">
                <div>
                    <h1 class="titulo">Cita medica registrada</h1>
                    <h1 class="titulo">
                        <?php   echo 'Folio de la cita:  '.$folio_citas;  ?>
                    </h1>
                </div>
                <div>
                    <h2 class="subtitulo"> Nombre del paciente de la cita: </h2>
                    <h2 class="corresponde pac"><?php   echo $paciente['Nombre_completo_paciente'];  ?></h2>
                </div>
                <div>
                    <h2 class="subtitulo"> Fecha de cita: </h2>
                    <h2 class="corresponde"><?php   echo $citas['Fecha_inicio'];  ?></h2>
                </div>
                <div>
                    <h2 class="subtitulo"> Horario de Inicio de cita: </h2>
                    <h2 class="corresponde"><?php   echo $citas['Hora_inicio'];  ?></h2>
                </div>
                <div>
                    <h2 class="subtitulo"> Horario de fin de cita: </h2>
                    <h2 class="corresponde"><?php   echo $citas['Hora_fin'];  ?></h2>
                </div>
                <div>
                    <h2 class="subtitulo"> Encargado que lo registro: </h2>
                    <h2 class="corresponde"><?php   echo $user['Nombre_completo_usuario'];  ?></h2>
                </div>
                <div>
                    <h2 class="subtitulo"> Estatus de la cita: </h2>
                    <h2 class="corresponde"><?php   echo  $citas['stat'];  ?></h2>
                </div>
            </div>
            <div class="botones">
                <a class="but back" href="../consulta/Consulta_cita.php"> <- Regresar.</a>
                <a class="but can" href="../conexion/conexion_cancela_cita.php?folio=<?php echo $folio_citas;?>&num=1"> Cancelar cita.</a>
                <a class="but can" href="../conexion/conexion_cancela_cita.php?folio=<?php echo $folio_citas;?>&num=2"> !! Eliminar !!.</a>

                <?php
                $inserta_folio = "SELECT stat From citas WHERE Folio_cita = '$folio_citas'";
                $inserta = mysqli_query($link, $inserta_folio);
                $stats = mysqli_fetch_array($inserta);
                $status = $stats['stat'];
                if($status == 'Espera')
                {
?>                  <a class="but cit" href="../modificar/modificar_cita.php?folio=<?php echo $folio_citas;?>"> Modificar cita.</a>
<?php           }
                if($type == 'Medico' || $type == 'Admin')
                {
                    if($status == 'Terminada' ||  $status == 'Cancelada')
                    {
?>                      <a class="but rec" href="" onclick="return concluida()" > Crear receta.</a>
<?php               }else
                    {
?>                      <a class="but rec" href="../registrar/Registrar_receta.php?folio=<?php echo $folio_citas?>"> Crear receta.</a>
<?php               }
?>                  
<?php           }else
                {
?>                  <a class="but rec" href="" onclick="return advertir()"> Crear receta.</a>
<?php           } 
?>
            </div>
        </div>
    </div>
</body>
</html>