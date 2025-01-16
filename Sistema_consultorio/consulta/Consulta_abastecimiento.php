<?php
    include('../php/LOGIN.php');
    $_SESSION['admin'] = '';
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $where = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta abastecimiento</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/consulta_abastecimiento.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">

</head>
<body>
    <header>   
        <div class="container">
            <p class="logo">Consulta_Pacientes.</p>
            <nav>
                <a href="../php/Main.php">Inicio.</a>
                <a href="Consulta_cita.php">Citas.</a>
                <a href="../consulta/Consulta_ventas.php">Ventas.</a>
                <a href="Consulta_abastecimiento.php">Abastecer.</a>
                <a href="consulta_pacientes.php">Pacientes.</a>
                <a href="Consulta_usuarios.php">Usuario.</a>
            </nav>
        </div>
    </header>
    <div class="contenedor">
        <div class="carta">
            <h1>Paginas a visitar.</h1>
            <li><a href="../php/vender_medicamento.php">Vender medicamento.</a>
                <p>Vender medicamentos que ya fueron abastecidos.</p>
            </li>
            <br>
            <?php
            if($_SESSION['admin'])
            {
?>
                <li><a href="../registrar/Registrar_abastecimiento.php">Abastecer medicamento.</a>
<?php   
            }
            else
            {
?>
                <li><a href="../php/auth.php?tipo=abastecer">Abastecer medicamento.</a>
<?php
            }
?>              <p>Si desea abastecer medicamentos que lleguen a el consultorio dirijase a el link anterior.</p>
                </li>
            <br>
            <li><a href="../php/Main.php">Volver a inicio.</a>
                <p>
                    Para regresar a el menu inicial puede
                    acceder a "Inicio." en la parte superior de la pantalla.
                    o acceder desde este enlace. 
                </p>
            </li>
        </div>
        <div class="conta">
            <div class="buscar">  
                <label>Busca Fecha: </label>
                <form method="GET"> 
                    <input type="date" name="curp" placeholder="Ingresa fecha.">
                    <button name="envia_curp" type="submit">Buscar</button>
                </form>   
            </div>
<?php
if(isset($_GET['envia_curp']))
{
    $busqueda = $_GET['curp'];
    if(isset($_GET['curp']))
    {
        $where = "SELECT * FROM comprobante_abastecimiento WHERE stat = 'Abastecido' AND Fecha_compra LIKE'%".$busqueda."%' ORDER BY Fecha_compra DESC, Hora DESC; ";
    }
}
?>
            <div class="buscar2">  
                <label>Busca por Folio: </label>  
                <form method="GET">
                    <input type="text" name="nombre" placeholder="Ingresa No. Folio.">
                    <button name="enviar_nombre" type="submit"> Buscar </button>
                </form>   
            </div>
<?php
if(isset($_GET['enviar_nombre']))
{
    $busqueda = $_GET['nombre'];
    if(isset($_GET['nombre']))
    {
        $where = "SELECT * FROM comprobante_abastecimiento WHERE stat = 'Abastecido' AND Folio_compra_proveedores LIKE'%".$busqueda."%' ORDER BY Fecha_compra DESC, Hora DESC; ";
    }
}
?>
        </div> 
        <div class="formulario">
            <h1>Busqueda de los abastecimientos, avienta los resultados siguientes:</h1>
            
<?php
if($where != '')
{
    $resultado = mysqli_query($link, $where);
    
    if($resultado -> num_rows >0)
    {
        while($mostrar = mysqli_fetch_array($resultado))
        {
            $usuario = $mostrar['ID_usuario'];
            $user = "SELECT Nombre_completo_usuario FROM usuarios WHERE ID_usuario = '$usuario' ";
            $res = mysqli_query($link, $user);
            $ID_user = mysqli_fetch_array($res);
            $ID_usuario = $ID_user['Nombre_completo_usuario'];
?>
    <div class="espacio">
        <table>
            <tr>
                <td style="background-color: cyan; font-size:24px; font-weight: bolder;">Folio: <?php echo $mostrar['Folio_compra_proveedores'];?></td>
                <td colspan="4" class="fecha">
                    Fecha compra: <?php echo $mostrar['Fecha_compra'];?>   ----   Hora compra: <?php echo $mostrar['Hora'];?>.
                </td>
            </tr>
            <tr>
                <td class="pos" >Nombre de medicamento:</td>
                <td class="pos" >Precio de compra actual:</td>
                <td class="pos" >Cantidad comprada:</td>
                <td class="pos" >Precio cuando se compró:</td>
                <td class="pos" >Total parcial:</td>
            </tr>
            <div class="scroll">
                <?php
                $folio = $mostrar['Folio_compra_proveedores'];
                $medicamento_abastecido = "SELECT * FROM medicamentos_abastecidos WHERE Folio_compra_proveedores = '$folio' AND stat = 'Abastecido';";
                $med_abastecido = mysqli_query($link, $medicamento_abastecido);
                if($med_abastecido -> num_rows > 0)
                {
                    $total = 0;
                    while($medicina = mysqli_fetch_array($med_abastecido))
                    {
                        $ID = $medicina['ID_medicamento'];
                        
                        $medicamento_registrado = "SELECT * FROM medicamentos WHERE ID_medicamento = '$ID';";
                        $med = mysqli_query($link, $medicamento_registrado);
                        $medicamento = mysqli_fetch_array($med);
                        $total_normal = $medicina['Cantidad_medicamento']*$medicina['Precio_medicamento_actual'];
                        $total += $total_normal;
                        ?>
                            <tr>
                                <td class="pos1"><?php echo $medicamento['Nombre_medicamento'];?></td>
                                <td class="pos1"><?php echo '$'.$medicamento['Precio'];?></td>
                                <td class="pos1"><?php echo $medicina['Cantidad_medicamento'];?></td>
                                <td class="pos1"><?php echo '$'.$medicina['Precio_medicamento_actual'];?></td>
                                <td class="pos1"><?php echo '$'.$total_normal; ?></td>
                            </tr>
                            <?php
                    }
                }
                ?>
            </div>
            <tr>
                <td colspan="2" style="font-size:20px; font-weight: bolder;">Usuario que abastecío:</td>
                <td colspan="4"><?php echo $ID_usuario;?></td>
            </tr>
            <tr>
                <td colspan="4" style="font-size:20px; font-weight: bolder; padding-left:620px;">TOTAL:</td>
                <td colspan="2"><?php echo '$'.$total;?></td>
            </tr>
        </table>
    </div>
    <?php
        }
    }
    
}
?>
            
        </div>
    </div>
</body>
</html>