<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
#Genera la actualizacion del status
$elimina = "UPDATE medicamentos_abastecidos SET stat = 'Eliminado', Cantidad_medicamento = 0 WHERE Folio_medicamento_comprado = '$folio'";
$delete = mysqli_query($link, $elimina);
if($delete)
{
?>
            <meta http-equiv="refresh" content="0.00001;../registrar/Registrar_abastecimiento.php">
<?php
}


?>
