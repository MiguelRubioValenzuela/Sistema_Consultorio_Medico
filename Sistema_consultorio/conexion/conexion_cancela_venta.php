<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

    $folio = $_GET['folio'];
    $elimina = "DELETE FROM medicamento_ventas WHERE Folio_venta = '$folio'";
    $delete = mysqli_query($link, $elimina);
?>
    <meta http-equiv="refresh" content="0.000001;../php/vender_medicamento.php">
<?php

#$ID_med = $_GET['medicina'];
#$elimina = "DELETE FROM medicamentos WHERE Curp_paciente = '$curp_paciente'";
#$delete = mysqli_query($link, $elimina);
#if($delete){
#    include("../consulta/consulta_pacientes.php");
    
#}


?>
