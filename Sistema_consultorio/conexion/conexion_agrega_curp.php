<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";
    $curp = $_POST['curp'];
    $folio = $_GET['folio'];

    $obtiene = "SELECT Curp_paciente FROM paciente WHERE Curp_paciente = '$curp';";
    $curp_obtenida = mysqli_query($link, $obtiene);
    if($curp_obtenida -> num_rows > 0)
    {
        $obtencion = mysqli_fetch_array($curp_obtenida);
        $curp_paciente = $obtencion['Curp_paciente'];

        if($curp == $curp_paciente)
        {
            $actualiza = "UPDATE ventas SET Curp_paciente = '$curp' WHERE Folio_ventas = '$folio'";
            $actualizar = mysqli_query($link, $actualiza);
        }
        
    }
?>
    <meta http-equiv="refresh" content="0.000001;../php/vender_medicamento.php">
