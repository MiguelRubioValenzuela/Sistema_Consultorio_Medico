<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$curp_paciente = $_GET['curp_paciente'];

$elimina = "UPDATE paciente SET stat = 'Eliminado' WHERE Curp_paciente = '$curp_paciente'";
$delete = mysqli_query($link, $elimina);
if($delete){
    ?>
        <script>
            confirm("Se ha eliminado la informacion del paciente.")
        </script>
        <meta http-equiv="refresh" content="0.0000001;../consulta/consulta_pacientes.php">
    <?php
}


?>
