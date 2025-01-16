<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
#Genera la actualizacion del status

        $vender= "UPDATE medicamentos_abastecidos SET stat = 'Abastecido' WHERE Folio_compra_proveedores = '$folio' AND stat = 'Espera'";
        $sold = mysqli_query($link, $vender);
        if($sold)
        {      
            $obtiene_med = "SELECT Cantidad_medicamento, ID_medicamento FROM medicamentos_abastecidos WHERE Folio_compra_proveedores = '$folio' AND stat = 'Abastecido';";
            $medicamentos = mysqli_query($link, $obtiene_med);
            if($medicamentos -> num_rows > 0)
            {
                while($medicinas = mysqli_fetch_array($medicamentos))
                {
                    $cant = $medicinas['Cantidad_medicamento'];
                    $id = $medicinas['ID_medicamento'];

                    $actualiza_cant = "UPDATE medicamentos SET Cantidad = (Cantidad+$cant) WHERE ID_medicamento = '$id';";
                    $cantidad_actualizada = mysqli_query($link, $actualiza_cant);
                }
            }
            $abastecer = "UPDATE comprobante_abastecimiento SET stat = 'Abastecido', Fecha_compra = CURRENT_DATE, Hora = CURRENT_TIME WHERE Folio_compra_proveedores = '$folio';";
            $abastecido = mysqli_query($link, $abastecer); 

?>          
            <script> 
            alert("Se realizo el abastecimiento exitosamente");
            window.open('../Tickets/ticket.php?folio=<?php echo $folio;?>');
            </script>

            <meta http-equiv="refresh" content="0.00001;../registrar/Registrar_abastecimiento.php">
            
<?php
        } 
?>