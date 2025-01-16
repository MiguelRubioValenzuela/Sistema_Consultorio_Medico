<?php
#       conexion SQL
include('../PHP/LOGIN.php');
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
$monto = $_GET['monto'];
#Genera la actualizacion del status

        $vender= "UPDATE medicamento_ventas SET stat = 'Vendido' WHERE Folio_venta = '$folio' AND stat = 'Espera'";
        $sold = mysqli_query($link, $vender);
        if($sold)
        {      
            $obtiene_med = "SELECT Cantidad_Medicamento, ID_Medicamento FROM medicamento_ventas WHERE Folio_venta = '$folio' AND stat = 'Vendido';";
            $medicamentos = mysqli_query($link, $obtiene_med);
            if($medicamentos -> num_rows > 0)
            {
                while($medicinas = mysqli_fetch_array($medicamentos))
                {
                    $cant = $medicinas['Cantidad_Medicamento'];
                    $id = $medicinas['ID_Medicamento'];
                    $actualiza_cant = "UPDATE medicamentos SET Cantidad = (Cantidad-$cant) WHERE ID_medicamento = '$id';";
                    $cantidad_actualizada = mysqli_query($link, $actualiza_cant);
                }
            }
            $abastecer = "UPDATE ventas SET stat = 'Vendido', Fecha = CURRENT_DATE, Hora = CURRENT_TIME, ID_usuario = '$usuario' WHERE Folio_ventas = '$folio';";
            $abastecido = mysqli_query($link, $abastecer); 
?>          
            <script> 
            alert("Venta realizada con exito");
            window.open('../Tickets/ticket_ventas.php?folio=<?php echo $folio;?>&monto=<?php echo $monto;?>');
            </script>

            <meta http-equiv="refresh" content="0.00001;../php/vender_medicamento.php">
            
<?php
        } 
?>