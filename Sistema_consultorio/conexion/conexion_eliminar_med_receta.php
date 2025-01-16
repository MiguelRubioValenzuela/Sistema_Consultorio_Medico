<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
$folio_receta = $_GET['receta'];
#Genera la actualizacion del status
$elimina = "UPDATE medicamentos_receta SET stat = 'Eliminado' WHERE Folio_Medicamento_Receta = '$folio'";
$delete = mysqli_query($link, $elimina);
if($delete)
{
?>
            <meta http-equiv="refresh" content="0.00001;../registrar/Registrar_medicamento_receta.php?folio=<?php echo $folio_receta?>">
<?php
}


?>
