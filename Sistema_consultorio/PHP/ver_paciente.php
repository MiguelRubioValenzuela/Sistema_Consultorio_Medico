<?php
    include("script.php");
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
    <title>Info Paciente</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/ver.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body>
    <header>   
        <div class="container">
            <p class="logo">Consulta_Pacientes.</p>
            <nav>
                <a href="Main.php">Inicio.</a>
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
            <li><a href="Main.php">Volver a inicio.</a>
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
$edad = "SELECT SUBSTRING((CURDATE())-(Fecha_nacimiento),1,2) AS Edad_actual FROM paciente WHERE Curp_paciente = '$Curp_paciente';"; 
$edad_actual = mysqli_query($link, $edad);
$age = mysqli_fetch_array($edad_actual);

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
                <div class="Justifica">
                    <li> 
                        <h2>CURP:</h2>
                        <div class="texto">
                            <p><?php echo $mostrar['Curp_paciente'];?></p>
                        </div>
                    </li>
                    <li> 
                        <h2>Nombre Completo:</h2>
                        <div class="texto">
                            <p><?php echo $mostrar['Nombre_completo_paciente'];?></p>
                        </div>
                    </li>
                </div>
                <div class="justifica">
                    <li> 
                        <h2>Telefono:</h2>
                        <div class="texto">
                            <p><?php echo $mostrar['Telefono_paciente'];?></p>
                        </div>
                    </li>
                    <li> 
                        <h2>Correo electronico:</h2>
                        <div class="texto">
                            <p><?php echo $mostrar['Correo_electronico_paciente'];?></p>
                        </div>
                    </li>
                </div>
                <div class="justifica">
                    <li> 
                        <h2>Fecha de nacimiento:</h2>
                        <div class="texto">
                            <p><?php echo $mostrar['Fecha_nacimiento'];?></p>
                        </div>
                    </li>
                    <li> 
                        <h2>Edad:</h2>
                        <div class="texto">
                            <p><?php echo $age['Edad_actual'];?></p>
                        </div>
                    </li>
                    <li> 
                        <h2>Sexo:</h2>
                        <div class="texto">
                            <p><?php echo $sexo;?></p>
                        </div>
                    </li>
                </div>
            </div>
            <div class="info">
            </div>
            <div class="margen">
                <h1>Registro de recetas medicas del paciente</h1>
            </div>
<!-- Busqueda de la receta medica --> 
        <div class="formulario">       
<?php

            $obtener = "SELECT * FROM citas WHERE CURP_Paciente = '$Curp_paciente' AND stat = 'Terminada' ORDER BY Folio_cita DESC; ";
            $resultado = mysqli_query($link, $obtener);
            if($resultado -> num_rows >0)
            {
                while($mostrar = mysqli_fetch_array($resultado))
                {
                    $folio = $mostrar['Folio_cita'];
                    $recetas = "SELECT * FROM recetas WHERE Folio_cita = '$folio' AND stat = 'Terminada';";
                    $recetados = mysqli_query($link, $recetas);
                    $receta = mysqli_fetch_array($recetados);

                    $a = $receta['ID_usuario'];
                    $u = "SELECT Nombre_completo_usuario FROM usuarios WHERE ID_usuario = '$a' ";
                    $res = mysqli_query($link, $u);
                    $us= mysqli_fetch_array($res);
                    $nombre_completo_usuario = $us['Nombre_completo_usuario'];
            ?>
                <div>
                    <table style="margin-left: 950px;">
                        <tr>
                            <td class="fecha" style=" font-size:24px; font-weight: bolder;">No. Receta: <?php echo $mostrar['Folio_cita'];?></td>
                            <td colspan="6" class="fecha">
                                Fecha de emision de receta: <?php echo $receta['Fecha_prescripcion'];?>.
                            </td>
                        </tr>
                        <tr>
                            <td class="pos nom" colspan="1" >Medicamento recetado:</td>
                            <td class="pos dosis" colspan="4">Dosis prescrita:</td>
                        </tr>

                        <div class="scroll">
                            <?php
                            $medicamento_abastecido = "SELECT * FROM medicamentos_receta WHERE Folio_Receta = '$folio' AND stat = 'Terminada';";
                            $med_abastecido = mysqli_query($link, $medicamento_abastecido);
                            if($med_abastecido -> num_rows > 0)
                            {
                                while($medicina = mysqli_fetch_array($med_abastecido))
                                {
                                    $ID = $medicina['ID_Medicamento'];
                                    
                                    $medicamento_registrado = "SELECT * FROM medicamentos WHERE ID_medicamento = '$ID';";
                                    $med = mysqli_query($link, $medicamento_registrado);
                                    $medicamento = mysqli_fetch_array($med);
                                    ?>
                                        <tr>
                                            <td class="pos1 nom" colspan="1"><?php echo $medicamento['Nombre_medicamento'];?></td>
                                            <td class="pos1 dosis" colspan="4"><?php echo $medicina['Dosis'];?></td>
                                        </tr>
                                        <?php
                                }
                            }
                            ?>
                        </div>
                        <tr>
                            <td class="pos diag" >Diagnostico realizado:</td>
                            <td class="pos aler" >Alergia:</td>
                            <td class="pos" >Peso:</td>
                            <td class="pos" >Altura:</td>
                            <td class="pos" >Pulso:</td>
                        </tr>
                        <tr>
                            <td class="pos1"><?php echo $receta['Diagnostico'];?></td>
                            <td class="pos1"><?php echo $receta['Alergias'];?></td>
                            <td class="pos1"><?php echo $receta['Peso'] ?></td>
                            <td class="pos1"><?php echo $receta['Altura'] ?></td>
                            <td class="pos1"><?php echo $receta['Pulso'] ?></td>
                        </tr>
                        <tr>
                            <td class="pos1" colspan="1" style="font-size:20px; font-weight: bolder; padding-left:0px; background-color:white;">Medico que lo recetó: </td>
                            <td class="pos1" colspan="6" style="font-size:20px; padding-left:0px; background-color:white;"><?php echo $nombre_completo_usuario;?></td>
                        </tr>
                        <tr>
                            <td class="pos1" colspan="1" style="font-size:20px; font-weight: bolder; padding-left:0px;">Comentarios: </td>
                            <td class="pos1" colspan="6"><?php echo $receta['Comentarios'];?></td>
                        </tr>
                    </table>
                </div>
    <?php
                }
            }
            ?>  
                    
                </div>
                </div>
                <?php
        }
                ?>
            </div>
</body>
</html>