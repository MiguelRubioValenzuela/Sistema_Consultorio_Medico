<?php
include('../php/LOGIN.php');
include('../php/script.php');
#        Conexion SQL     Host   Usuario  Password DataBase
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";
    # declaracion de variables
$ID_medicamento = $_GET['identificador_med'];
$cantidad = $_POST['cant'];
if(isset($_POST['restar']))
{
    $manera = $_POST['restar'];
}
else{
    $manera = 'No Enviado';
}

    #Obtiene el ID maximo del folio de medicamentos comprados
    $Obtiene_id_folio = "SELECT MAX(Folio_Medicamento_Venta) AS maximo FROM medicamento_ventas";
    $ID_folio = mysqli_query($link, $Obtiene_id_folio);;
    $row = $ID_folio->fetch_array();
    $new_id = $row['maximo']+1;

    #Obtiene el precio del medicamento ingresado y el ID para solo añadir el valor de cantidad a la que ya se tiene
    $Obtiene_precio = "SELECT Precio, Cantidad FROM medicamentos WHERE ID_medicamento = '$ID_medicamento';";
    $precio_inicial= mysqli_query($link, $Obtiene_precio);
    $initial = $precio_inicial->fetch_array();
    $precio = $initial['Precio'];
    $Cant_anterior = $initial['Cantidad'];
    
    #obtiene el folio maximo dentro del comprobante para ingresar en los medicamentos el folio actual
    $Obtiene_id_folio = "SELECT MAX(Folio_ventas) AS maximo FROM ventas WHERE stat = 'Espera';";
    $ID_folio = mysqli_query($link, $Obtiene_id_folio);
    $maximo = mysqli_fetch_array($ID_folio);
    $max = $maximo['maximo'];
    
    #Obtiene el id medicamento para poder comprobar igualdades y actualizar la cantidad
    $comprobar = "SELECT ID_medicamento, Cantidad_Medicamento FROM medicamento_ventas WHERE ID_medicamento = '$ID_medicamento' AND Folio_venta = '$max';";
    $comprobacion = mysqli_query($link, $comprobar);
    $MEDS = mysqli_fetch_array($comprobacion);
    $medicamento = $MEDS['ID_medicamento'];
    $cant = $MEDS['Cantidad_Medicamento'];

    #Una ves que se obtiene el nuevo ID lo compara con el id registrado
    
    if($ID_medicamento == $medicamento)
    {   
        if($manera == '-')
        {
            if(($cant-$cantidad) <= 0)
            {
                $Linea_actualizar = "UPDATE `medicamento_ventas` SET `Cantidad_Medicamento`= 0, stat = 'Eliminado' WHERE ID_medicamento = '$ID_medicamento' AND Folio_venta = '$max';";
                $actualizar = mysqli_query($link, $Linea_actualizar);
                if($actualizar)
                {
                    ?>
                        <meta http-equiv="refresh" content="0.0000001;../php/vender_medicamento.php">
                    <?php
                }
            }
            else
            {
                $Linea_actualizar = "UPDATE `medicamento_ventas` SET `Cantidad_Medicamento`= (Cantidad_Medicamento-$cantidad) WHERE ID_medicamento = '$ID_medicamento' AND Folio_venta = '$max';";
                $actualizar = mysqli_query($link, $Linea_actualizar);
                if($actualizar)
                {
                    ?>
                        <meta http-equiv="refresh" content="0.0000001;../php/vender_medicamento.php">
                    <?php
                }
            }
        }
        else
        {
            if(($cant+$cantidad) > $Cant_anterior)
            {
                ?>
                    <script>
                        alert("No se cuenta con la cantidad de medicamento. \nIngrese una cantidad que sea menor a la cantidad de medicamentos en el inventario");
                    </script>
                    <meta http-equiv="refresh" content="0.0000001;../php/vender_medicamento.php">
                <?php
            }
            else
            {
                $Linea_actualizar = "UPDATE `medicamento_ventas` SET `Cantidad_Medicamento`= (Cantidad_Medicamento+$cantidad), stat = 'Espera' WHERE ID_medicamento = '$ID_medicamento' AND Folio_venta = '$max';";
                $actualizar = mysqli_query($link, $Linea_actualizar);
                if($actualizar)
                {
                    ?>
                        <meta http-equiv="refresh" content="0.0000001;../php/vender_medicamento.php">
                    <?php
                }
            }
        }
    }
    else
    {
        if(($cant+$cantidad) > $Cant_anterior)
        {
            ?>
                <script>
                    alert("No se cuenta con la cantidad de medicamento. \nIngrese una cantidad que sea menor a la cantidad de medicamentos en el inventario");
                </script>
                <meta http-equiv="refresh" content="0.0000001;../php/vender_medicamento.php">
            <?php
        }
        else
        {
            $InsertData = "INSERT INTO `medicamento_ventas`(`Folio_Medicamento_Venta`, `Folio_venta`, `ID_medicamento`, `Cantidad_Medicamento`, `Precio_Medicamento_Actual`, `stat`) VALUES ('$new_id','$max','$ID_medicamento','$cantidad','$precio','Espera')";
            $insert_user = mysqli_query($link, $InsertData);
            if($insert_user)
            {
                ?>
                    <meta http-equiv="refresh" content="0.0000001;../php/vender_medicamento.php">
                <?php
            }
        }
    }

mysqli_close($link); 
?>