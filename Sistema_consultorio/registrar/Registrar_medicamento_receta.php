<?php
    include('../php/LOGIN.php');
    include('../php/script.php');
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $folio = $_GET['folio']; 
    $where = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar abastecimiento</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/Registro_med_receta.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body>
<?php
$obtiene_cita = "SELECT * FROM citas WHERE Folio_cita = '$folio'";
$cita_obtenida = mysqli_query($link, $obtiene_cita);
$citas = mysqli_fetch_array($cita_obtenida);
$paciente = $citas['CURP_Paciente'];

$confirma_cita = "SELECT Folio_cita FROM recetas WHERE Folio_cita = '$folio'";
$cita_confirmada = mysqli_query($link, $confirma_cita);
$cita_tomada = mysqli_fetch_array($cita_confirmada);

if($cita_confirmada -> num_rows <= 0) 
{
    $Obtiene_id_folio = "SELECT MAX(Folio_Receta) AS maximo FROM recetas";
    $ID_folio = mysqli_query($link, $Obtiene_id_folio);
    $maximo = mysqli_fetch_array($ID_folio);
    $max;
    if(!$maximo['maximo']){
        $max = 0;
    }else{
        $max = $maximo['maximo'];
    }
    $aux = $max+1;        
    $inserta_folio = "INSERT INTO `recetas`(`Folio_Receta`, `CURP_Paciente`, `ID_usuario`, `Folio_cita`, `Diagnostico`, `Alergias`, `Peso`, `Altura`, `Temperatura`, `Pulso`, `Fecha_prescripcion`, `Comentarios`) VALUES ('$aux','$paciente','$usuario','$folio','','','','','','', CURRENT_DATE,'')";
    $inserta = mysqli_query($link, $inserta_folio);
}else{
    $aux = $cita_tomada['Folio_cita'];
}

$Obtiene_pac = "SELECT * FROM paciente WHERE Curp_paciente = '$paciente';";
$pac = mysqli_query($link, $Obtiene_pac);
$paciente_obtenido = mysqli_fetch_array($pac);

$confirma_cita = "SELECT * FROM recetas WHERE Folio_cita = '$folio'";
$cita_confirmada = mysqli_query($link, $confirma_cita);
$cita_tomada = mysqli_fetch_array($cita_confirmada);
$ids = $cita_tomada['ID_usuario'];

$nomU = "SELECT Nombre_completo_usuario FROM usuarios WHERE ID_usuario = '$usuario'";
$nomb_user = mysqli_query($link, $nomU);
$nombre_usuario = mysqli_fetch_array($nomb_user);

$edad = "SELECT SUBSTRING((CURDATE())-(Fecha_nacimiento),1,2) AS Edad_actual FROM paciente WHERE Curp_paciente = '$paciente';"; 
$edad_actual = mysqli_query($link, $edad);
$age = mysqli_fetch_array($edad_actual);

    if($paciente_obtenido['sexo'] == 'M')
        $sexo = 'Masculino';
    if($paciente_obtenido['sexo'] == 'F')
        $sexo = 'Femenino';
    if($paciente_obtenido['sexo'] == 'X')
        $sexo = 'Sin especificar';

if($ids != $usuario)
{
    $actualiza_user = "UPDATE citas SET ID_usuario = '$usuario' WHERE Folio_cita = '$folio'";
    $actualiza = mysqli_query($link, $actualiza_user);
}
?>  
    <div class="contener" style="margin-top: 60px;">
        <h1>Registro de la receta medica.</h1>
        <h2 class="num">No. Receta: <?php echo $aux?></h2>
        <h2 class='no'>Datos del paciente:</h2>
        <div class="cont">
            <h2 class="in">Nombre:</h2>
            <h2 class="in edad">Edad: </h2>
            <h2 class="in sexo">Sexo: </h2>
        </div>
        <div class="cont2">
            <h2 class="nombre"><?php echo $paciente_obtenido['Nombre_completo_paciente'];?></h2>
            <h2 class="edad2"><?php echo $age['Edad_actual']?></h2>
            <h2 class="sexo2"><?php echo $sexo?></h2>
        </div>
        <div class="cont3">
            <h2 class="con ced">Cedula:</h2>
            <h2 class="con med">Medico:</h2>
            <h2 class="con fec">Fecha:</h2>
        </div>
        <div class="cont3">
            <h2 class="con user"><?php echo $usuario?></h2>
            <h2 class="con2 nomb"><?php echo $nombre_usuario['Nombre_completo_usuario'];?></h2>
            <h2 class="con date"><?php echo date('Y-M-d')?></h2>
        </div>
    </div>

<!-- Division con las busquedas por ID -->

    <div class="buscar">  
        <label>Buscar por ID: </label>
        <form method="GET">
            <input type="text" name="id" placeholder="Ingresa ID." maxlength="8" onkeypress="return Solo_numeros(event);">
            <button type="submit" name="folio" value="<?php echo $folio?>">Buscar</button>
        </form>   
    </div>

<?php
if(isset($_GET['folio']))
{
    if(isset($_GET['id']))
    {
        $busqueda = $_GET['id'];
        $where = "WHERE ID_medicamento LIKE'%".$busqueda."%';";
    }
}
?>

<!-- Division con las busquedas por nombre-->

    <div class="buscar2">  
        <label> Busca por Nombre: </label>  
        <form method="GET">
            <input type="text" name="nombre" placeholder="Ingresa Nombre.">
            <button type="submit" name="folio" value="<?php echo $folio?>"> Buscar </button>
        </form>   
    </div>

<?php
if(isset($_GET['folio']))
{
    if(isset($_GET['nombre']))
    {
        $busqueda = $_GET['nombre'];
        $where = "WHERE Nombre_medicamento LIKE'%".$busqueda."%';";
    }
}
?>

<!-- Division con las busquedas por control del medicamento-->

    <div class="filtro">
        <form style="margin-left:5px" method="GET" id="filtro">
            <label>filtrar Control</label>
            <br>
            <select method="GET" name="filtro_control">
                <option value="no" selected="">Todos</option>
                <option value="No controlado">No controlado.</option>
                <option value="Controlado">Controlado.</option>
            </select>
            <button class="fil" name="folio" value="<?php echo $folio?>">buscar</button>
        </form>
    </div>

<?php
if(isset($_GET['folio']))
{
    if(isset($_GET['filtro_control']))
    {
        if($_GET['filtro_control'] != "no")
        {
            $busqueda = $_GET['filtro_control'];
            $where = "WHERE Tipo_de_medicamento ='$busqueda';";
        }
    }
}
?>  
<!-- Division con las busquedas por via de administracion -->            
    <div class="filtro2">
        <form style="margin-left:-50px" method="GET" id="filtro2">
            <label>Via administacion</label>
            <br>
            <select method="GET" name="eleccion" style="padding-right:40px">
                <option value="no" selected="">Todos</option>
                <option value="Cutanea">Cutanea.</option>
                <option value="Inhalatoria">Inhalatoria.</option>
                <option value="Intradérmica">Intradérmica.</option>
                <option value="Intramuscular">Intramuscular.</option>
                <option value="Intravenosa">Intravenosa.</option>
                <option value="Nasal">Nasal.</option>
                <option value="Ocular">Ocular.</option>
                <option value="Oral">Oral.</option>
                <option value="Ötica">Ötica.</option>
                <option value="Rectal">Rectal.</option>
                <option value="Subcutanea">Subcutanea.</option>
                <option value="Sublingual">Sublingual.</option>
                <option value="Tópica">Tópica.</option>
                <option value="Transdérmica">Transdérmica.</option>
                <option value="Vaginal">Vaginal.</option>
            </select>
            <button class="fil2" name="folio" value="<?php echo $folio?>">buscar</button>
        </form>
    </div>
            <?php
$filtro1 = '';
if(isset($_GET['folio']))
{
    if(isset($_GET['eleccion']))
    {
        if($_GET['eleccion'] != "no")
        {
            $busqueda = $_GET['eleccion'];
            $where = "WHERE Via_administracion ='$busqueda';";
        }
    }
}
?> 
<!-- Division con la tabla con la informacion de los medicamentos -->
    <div class="tabla">
        <table>
<?php       $obtener = "SELECT * FROM medicamentos $where";
            $resultado = mysqli_query($link, $obtener);
            if($resultado -> num_rows >0)
            {
                while($mostrar = mysqli_fetch_array($resultado))
                {
?>
                    <tr>
                        <td class="med_nombre"><?php echo $mostrar['Nombre_medicamento']; ?></td>
                        <td class="med_cont"><?php echo $mostrar['Tipo_de_medicamento']; ?></td>
                        <td class="med_via"><?php echo $mostrar['Via_administracion']; ?></td>
                        <td class="med_desc"><?php echo $mostrar['Descripcion']; ?></td>
                        <td class="visualizar">
                            <form method="post" action="../conexion/Conexion_recetas.php?medicina=<?php echo $mostrar['ID_medicamento']; ?>&folio_receta=<?php echo $folio?>">
                                <input class="dosis" name="Dosis" type="text" placeholder="Dosis por medicamento" required>
                                <button><p>Añadir</p></button>
                            </form>
                        </td>
                    </tr>
                        <?php
                }
            }
            else
            {
?>
                <tr>
                    <td colspan="7" class="tablita2">
                        No existen registros....
                    </td>
                </tr>
<?php
            }
?>
        </table>
    </div>
    <h1 class="med_en">Medicamentos en receta:</h1>
    <div class="tabla2">
        <table>
<?php   $obtener = "SELECT * FROM medicamentos_receta WHERE Folio_Receta = '$folio' AND stat = 'Espera';";
        $resultado = mysqli_query($link, $obtener);
        if($resultado -> num_rows >0)
        {
            while($mostrar = mysqli_fetch_array($resultado))
            {   
                $id = $mostrar['ID_Medicamento'];

                $med_rec = "SELECT * FROM medicamentos WHERE ID_medicamento = '$id';";
                $recetados = mysqli_query($link, $med_rec);
                $muestra = mysqli_fetch_array($recetados);
?>              <tr>
                    <td class="med_no"><?php echo $muestra['Nombre_medicamento']; ?></td>
                    <td class="med_dosis"><?php echo $mostrar['Dosis']; ?></td>
                    <td class="visualizar">
                        <form method="post" action="../conexion/conexion_eliminar_med_receta.php?folio=<?php echo $mostrar['Folio_Medicamento_Receta'];?>&receta=<?php echo $folio;?>">
                            <button class="elimina"><p>X</p></button>
                        </form>
                    </td>
                </tr>
<?php       }
        }
?>      </table>
    </div>
<?php   $obtener = "SELECT * FROM medicamentos_receta WHERE Folio_Receta = '$folio' AND stat = 'Espera';";
        $resultado = mysqli_query($link, $obtener);
        if($resultado -> num_rows >0)
        {
?>          <div class="comentarios">
                <label>Comentarios adicionales</label>
                <form method="post" action="../conexion/conexion_confirma_receta.php?folio=<?php echo $folio?>">
                    <textarea name="comentario" cols="50" rows="10" maxlength="500"></textarea>
                    <div class="ajustar">
                        <button class="terminar" onclick="return recetar()">Terminar registro.</button>
                    </div>
                </form>        
            </div>
<?php   }else
        {
?>          <div class="comentarios">
                <label>Comentarios requeridos</label>
                <form method="post" action="../conexion/conexion_confirma_receta.php?folio=<?php echo $folio?>">
                    <textarea name="comentario" cols="50" rows="10" maxlength="500" required></textarea>
                    <div class="ajustar">
                        <button class="terminar" onclick="return recetar()">Terminar registro.</button>
                    </div>
                </form>        
            </div>
<?php   }
?>  
</body>
</html>























