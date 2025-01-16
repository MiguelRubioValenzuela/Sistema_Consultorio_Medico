<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";
    $curp = $_GET['curp'];
    $folio = $_GET['folio'];

    $obtiene = "UPDATE ventas SET Curp_paciente = '' WHERE Curp_paciente = '$curp' AND Folio_ventas = '$folio';";
    $curp_obtenida = mysqli_query($link, $obtiene);
    if($curp_obtenida)
    {
        echo $curp.' + '.$folio;
    }
?>
    <meta http-equiv="refresh" content="0.000001;../php/vender_medicamento.php">
