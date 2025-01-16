<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
#Genera la actualizacion del status
$elimina = "UPDATE medicamento_ventas SET stat = 'Eliminado', Cantidad_Medicamento = 0 WHERE Folio_Medicamento_Venta = '$folio'";
$delete = mysqli_query($link, $elimina);
if($delete)
{
?>
            <meta http-equiv="refresh" content="0.00001;../php/vender_medicamento.php">
<?php
}
?>
