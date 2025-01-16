<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
$comentario = '';
if(isset($_POST['comentario']))
{
    $comentario = $_POST['comentario'];
}
#Genera la actualizacion del status  
        $abastecer = "UPDATE recetas SET stat = 'Terminada', Comentarios = '$comentario' WHERE Folio_cita = '$folio';";
        $abastecido = mysqli_query($link, $abastecer); 
        
        $obt = "SELECT Folio_Receta FROM recetas WHERE Folio_cita = '$folio';";
        $obtenido = mysqli_query($link, $obt); 
        $tomado = mysqli_fetch_array($obtenido);
        $folio_receta = $tomado['Folio_Receta'];

        
        $vender= "UPDATE medicamentos_receta SET stat = 'Terminada' WHERE Folio_Receta = '$folio' AND stat = 'Espera'";
        $sold = mysqli_query($link, $vender);

        $citas = "UPDATE citas SET stat = 'Terminada' WHERE Folio_cita = '$folio';";
        $terminar_cita = mysqli_query($link, $citas);
?>          
            <script> 
            alert("Se recetó y termino la cita correspondiente");
            window.open('../Tickets/Receta.php?folio=<?php echo $folio;?>');
            </script>

            <meta http-equiv="refresh" content="0.00001;../consulta/Consulta_cita.php">