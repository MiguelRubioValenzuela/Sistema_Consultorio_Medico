<?php
    include('../php/LOGIN.php');
    include('../php/script.php');
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $folio = $_GET['folio']; 
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $temperatura = $_POST['temp'];
    $pulso = $_POST['car'];
    $alergias = $_POST['aler'];
    $diagnostico = $_POST['diag'];


    $ingresa_datos = "UPDATE `recetas` SET `Diagnostico`='$diagnostico',`Alergias`='$alergias',`Peso`='$peso',`Altura`='$altura',`Temperatura`='$temperatura',`Pulso`='$pulso' WHERE Folio_cita = '$folio'";
    $ingresando_datos = mysqli_query($link, $ingresa_datos);
?>
<meta http-equiv="refresh" content="0.000001;../registrar/Registrar_medicamento_receta.php?folio=<?php echo $folio?>">