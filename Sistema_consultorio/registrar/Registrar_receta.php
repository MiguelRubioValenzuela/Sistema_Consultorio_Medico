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
    <link rel="stylesheet" href="../CSS/Registro_recetas.css">
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
    $inserta_folio = "INSERT INTO `recetas`(`Folio_Receta`, `CURP_Paciente`, `ID_usuario`, `Folio_cita`, `Diagnostico`, `Alergias`, `Peso`, `Altura`, `Temperatura`, `Pulso`, `Fecha_prescripcion`, `Comentarios`, `stat`) VALUES ('$aux','$paciente','$usuario','$folio','','','','','','', CURRENT_DATE,'', 'Espera')";
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
    <div class="contener">
        <h1>Registro de la receta medica.</h1>
        <h2 class="no">No. Receta: <?php echo $aux?></h2>
        <h2 class='no'>Datos del paciente:</h2>
        <div class="cont">
            <h2 class="in move">Nombre:</h2>
            <h2 class="in">Edad: </h2>
            <h2 class="in">Sexo: </h2>
        </div>
        <div class="cont">
            <h2 class="mov"><?php echo $paciente_obtenido['Nombre_completo_paciente'];?></h2>
            <h2 class="on"><?php echo $age['Edad_actual']?></h2>
            <h2 class="se"><?php echo $sexo?></h2>
        </div>
    </div>
    <div class="contenedor">
        <form method="post" action="../registrar/Registrar_datos_receta.php?folio=<?php echo $folio?>">
            <div class="peso">
                <h3>Peso: </h3>
                <input name="peso" type="num" placeholder="Peso en Kg" onkeypress="return solo_num(event)" required>
            </div>
            <div class="alt">
                <h3>Altura: </h3>
                <input name="altura" type="text" placeholder="Altura en Metros." onkeypress="return solo_num(event)" required>
            </div>
            <div class="temp">
                <h3>Temperatura °C: </h3>
                <input name="temp" type="text" placeholder="Temperatura °Celsius" onkeypress="return solo_num(event)" required>
            </div>
            <div class="car">
                <h3>Pulso cardiaco: </h3>
                <input name="car" type="text" placeholder="Pulsaciones/Segundo" onkeypress="return Solo_numeros(event)" required>
            </div>
            <div class="aler">
                <h3>Alergias: </h3>
                <input name="aler" type="text" placeholder="Alergias" onkeypress="return Solo_letras(event)" required>
            </div>
            <div class="diag">
                <h3>Diagnostico: </h3>
                <textarea name="diag" cols="90" rows="6" maxlength="500"></textarea>
            </div>
            <button>Recetar medicamentos y/o comentarios</button>
        </form>
    </div>

</body>
</html>























