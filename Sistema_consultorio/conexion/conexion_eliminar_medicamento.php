<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

?>
    <script>
        alert("Se ha eliminado la informacion del medicamento.");
                <?php
                        $ID_med = $_GET['medicina'];
                        $elimina = "UPDATE medicamentos SET stat = 'Inactivo' WHERE ID_medicamento = '$ID_med'";
                        $delete = mysqli_query($link, $elimina);
                ?>
    </script>
    <meta http-equiv="refresh" content="0.000001;../modificar/vizualizar_medicamento.php">

<?php

#$ID_med = $_GET['medicina'];
#$elimina = "DELETE FROM medicamentos WHERE Curp_paciente = '$curp_paciente'";
#$delete = mysqli_query($link, $elimina);
#if($delete){
#    include("../consulta/consulta_pacientes.php");
    
#}


?>
