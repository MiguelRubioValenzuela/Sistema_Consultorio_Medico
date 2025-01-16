<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
$num = $_GET['num'];

if($folio)
{
    if($num == '1')
    {
        $elimina = "UPDATE citas SET stat = 'Cancelada' WHERE Folio_cita = '$folio'";
        $delete = mysqli_query($link, $elimina);
        if($delete){
        ?>
            <script>
                alert("La cita ha sido cancelada.")
            </script>
            <meta http-equiv="refresh" content="0.0000001;../consulta/Consulta_cita.php">
        <?php
    }
    }
    elseif($num == '2')
    {
        $elimina = "UPDATE citas SET stat = 'Eliminada' WHERE Folio_cita = '$folio'";
        $delete = mysqli_query($link, $elimina);
    if($delete){
        ?>
            <script>
                alert("La cita ha sido Eliminada.")
            </script>
            <meta http-equiv="refresh" content="0.0000001;../consulta/Consulta_cita.php">
        <?php
    }
    }
}
else{
        ?>
            <script>
                alert("Folio no encontrado.")
            </script>
            <meta http-equiv="refresh" content="0.0000001;../consulta/Consulta_cita.php">
        <?php
        #header("location:modificar_usuario.php");
}


?>
