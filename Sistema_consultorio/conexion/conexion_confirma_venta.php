<?php
#       conexion SQL
include("../php/LOGIN.php");
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";
    $folio = $_GET['folio'];
    $monto = $_POST['monto'];
    $tot = $_GET['total'];
    $cambio = $monto-$tot;

    if($cambio < 0)
    {
        ?>
        <script>
            alert("No cuenta con el efectivo suficiente para realizar la compra");
        </script>
        <meta http-equiv="refresh" content="0.000001;../php/vender_medicamento.php">
        <?php
    }
    else
    {

        #$elimina = "DELETE FROM medicamento_ventas WHERE Folio_venta = '$folio'";
        #$delete = mysqli_query($link, $elimina);
?>
  <!--  <meta http-equiv="refresh" content="0.000001;../php/vender_medicamento.php">-->
<?php
        $nomU = "SELECT Nombre_completo_usuario FROM usuarios WHERE ID_usuario = '$usuario'";
        $nomb_user = mysqli_query($link, $nomU);
        $nombre_usuario = mysqli_fetch_array($nomb_user); 

        $Obtiene_id_folio = "SELECT MAX(Folio_ventas) AS maximo FROM ventas";
        $ID_folio = mysqli_query($link, $Obtiene_id_folio);
        $maximo = mysqli_fetch_array($ID_folio);
        $max;
        if(!$maximo['maximo'])
        {
            $max = 0;
        }
        else
        {
            $max = $maximo['maximo'];
        }
        $aux = $max;
        $Obtiene_status = "SELECT stat FROM ventas WHERE Folio_ventas = '$max';";
        $stat = mysqli_query($link, $Obtiene_status);
        $stats = mysqli_fetch_array($stat);
        $status;

        if($stats)
        {
            $status = $stats['stat'];
            if($status == 'Vendido') 
            {
                $aux = $max+1;
            }    
        }
        else 
        {
            $aux = $max+1;
        }

        if($aux > $max)
        {
            $inserta_folio = "INSERT INTO ventas (Folio_ventas, stat) VALUES ('$aux',  'Espera')";
            $inserta = mysqli_query($link, $inserta_folio);
        }

        $Obtiene_curp = "SELECT Curp_paciente FROM ventas WHERE Folio_ventas = '$aux';";
        $curp = mysqli_query($link, $Obtiene_curp);
        if($curp -> num_rows > 0)
        {   
            $paciente = mysqli_fetch_array($curp);
            $nombre_paciente = $paciente['Curp_paciente'];
            echo $nombre_paciente;
            $Obtiene_paciente = "SELECT Nombre_completo_paciente FROM paciente WHERE Curp_paciente = '$nombre_paciente';";
            $Paciente_nombre = mysqli_query($link, $Obtiene_paciente);
        }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/vender_medicamento.css">
    <title>Confirmacion</title>
</head>
<body>
        <div class="contener_abas">
            <h1>Medicamentos abastecidos.</h1>
            <div class="cont_folio">
                <h2 class="folios">Folio: <br><?php    echo $aux?></h2>
                <h2 class="nombres">Encargado: <br><?php    echo $nombre_usuario['Nombre_completo_usuario']?></h2>
                <h2 class="fecha">Fecha: <br><?php  echo date('Y-m-d')?></h2>
            </div>
<?php
                if($Paciente_nombre -> num_rows > 0)
                {   $pac = mysqli_fetch_array($Paciente_nombre);
?>
                    <div class="paciente">    
                        <h2>Paciente: <?php    echo $pac['Nombre_completo_paciente']?></h2>
                        <a href=""> Eliminar</a>
                    </div>
<?php
                }
?>
            
<?php
            $obtiene_medicamentos = "SELECT * FROM medicamento_ventas WHERE Folio_venta = '$aux' AND stat = 'Espera';";
            $medicamentos = mysqli_query($link, $obtiene_medicamentos);
            if($medicamentos -> num_rows >0)
            {
                
                $total = 0;
                $total_ganancias = 0;
                ?>
                <p id="num">No.</p>
                <p id="med">Medicamento:</p>
                <p id="can">Cant:</p>
                <p id="preu">$Un:</p>
                <p id="pret">Total:</p>
                <table class="Medicamentos">
                    <?php
                $cont = 1;
                while($mostrar = mysqli_fetch_array($medicamentos))
                {
                    $id = $mostrar['ID_Medicamento'];
                    $id_medicamentos = "SELECT Nombre_medicamento, Precio FROM medicamentos WHERE ID_medicamento = '$id';";
                    $Nombre_medicamento = mysqli_query($link, $id_medicamentos);
                    $nombre = mysqli_fetch_array($Nombre_medicamento); 
                    $total += ($mostrar['Precio_Medicamento_Actual']*$mostrar['Cantidad_Medicamento']);
                    ?>
                        <tr class="just">
                            <td id="mostrar1"><?php echo $cont?></td>
                            <td id="mostrar2"><?php echo $nombre['Nombre_medicamento']?></td>
                            <td id="mostrar3"><?php echo $mostrar['Cantidad_Medicamento']?></td>
                            <td id="mostrar4"><?php echo '$'.$mostrar['Precio_Medicamento_Actual']?></td>
                            <td id="mostrar5"><?php echo '$'.($mostrar['Precio_Medicamento_Actual']*$mostrar['Cantidad_Medicamento'])?></td>
                            <td id="mostrar6"><a href="../conexion/conexion_eliminar_venta.php?folio=<?php echo $mostrar['Folio_Medicamento_Venta'];?>">X</a></td>
                            <td id="punto">.</td>
                        </tr>
                        <tr id="no">
                            <td id="no">.</td>
                        </tr>                     
<?php           $cont += 1;
                $sub = ($total/100)*84;
                $iva = ($total/100)*16;           
                }
                ?>
                </table>   
                <table class="total">
                    <tr>
                        <td style="font-size: 20px; font-weight: normal;" >Sub-Total: </td>
                        <td style="font-size: 20px; font-weight: normal;"  id="num_total"><?php echo '$'.$sub;?></td>
                    </tr>
                    <tr>
                        <td style="font-size: 20px; font-weight: normal;"  >Iva (16%): </td>
                        <td style="font-size: 20px; font-weight: normal;"  id="num_total"><?php echo '$'.$iva;?></td>
                    </tr>
                </table>
                <table id="pagando">
                    <tr>
                        <td >Cantidad pagada: </td>
                        <td id="num_tot"><?php echo '$'.$monto;?></td>
                    </tr>
                    <tr>
                        <td >Total a pagar: </td>
                        <td id="num_tot"><?php echo '$'.$tot;?></td>
                    </tr>
                    <tr >
                        <td id="cambiando">Cambio: </td>
                        <td id="num_total"><?php echo '$'.$cambio;?></td>
                    </tr>
                </table>
                <div class="mantener">
                    <a id="cancel" href="../php/vender_medicamento.php">Cancelar</a>
                </div>
                    <form id="pago" method="post" action="../conexion/conexion_pago_confirmado.php?folio=<?php echo $aux?>&monto=<?php echo $monto?>">                    
                        <button id="abasteci">Confirmar pago.</button>
                    </form>
                <?php
            }
        }  
?>
</body>
</html>