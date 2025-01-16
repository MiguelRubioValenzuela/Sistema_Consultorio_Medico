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
    $Obtiene_id_folio = "SELECT MAX(Folio_medicamento_comprado) AS maximo FROM medicamentos_abastecidos";
    $ID_folio = mysqli_query($link, $Obtiene_id_folio);;
    $row = $ID_folio->fetch_array();
    $new_id = $row['maximo']+1;

    #Obtiene el precio del medicamento ingresado y el ID para solo añadir el valor de cantidad a la que ya se tiene
    $Obtiene_precio = "SELECT Precio_inicial FROM medicamentos WHERE ID_medicamento = '$ID_medicamento';";
    $precio_inicial= mysqli_query($link, $Obtiene_precio);
    $initial = $precio_inicial->fetch_array();
    $precio = $initial['Precio_inicial'];
    
    #obtiene el folio maximo dentro del comprobante para ingresar en los medicamentos el folio actual
    $Obtiene_id_folio = "SELECT MAX(Folio_compra_proveedores) AS maximo FROM comprobante_abastecimiento WHERE stat = 'Espera';";
    $ID_folio = mysqli_query($link, $Obtiene_id_folio);
    $maximo = mysqli_fetch_array($ID_folio);
    $max = $maximo['maximo'];
    
    #Obtiene el id medicamento para poder comprobar igualdades y actualizar la cantidad
    $comprobar = "SELECT ID_medicamento, Cantidad_medicamento FROM medicamentos_abastecidos WHERE ID_medicamento = '$ID_medicamento' AND Folio_compra_proveedores = '$max';";
    $comprobacion = mysqli_query($link, $comprobar);
    $MEDS = mysqli_fetch_array($comprobacion);
    $medicamento = $MEDS['ID_medicamento'];
    $cant = $MEDS['Cantidad_medicamento'];

    #Una ves que se obtiene el nuevo ID lo compara con el id registrado
    
    if($ID_medicamento == $medicamento)
    {   
        if($manera == '-')
        {
            if(($cant-$cantidad) <= 0)
            {
                $Linea_actualizar = "UPDATE `medicamentos_abastecidos` SET `Cantidad_medicamento`= 0, stat = 'Eliminado' WHERE ID_medicamento = '$ID_medicamento' AND Folio_compra_proveedores = '$max';";
                $actualizar = mysqli_query($link, $Linea_actualizar);
                if($actualizar)
                {
                    ?>
                        <meta http-equiv="refresh" content="0.0000001;../registrar/Registrar_abastecimiento.php">
                    <?php
                }
            }
            else
            {
                $Linea_actualizar = "UPDATE `medicamentos_abastecidos` SET `Cantidad_medicamento`= (Cantidad_medicamento-$cantidad) WHERE ID_medicamento = '$ID_medicamento' AND Folio_compra_proveedores = '$max';";
                $actualizar = mysqli_query($link, $Linea_actualizar);
                if($actualizar)
                {
                    ?>
                        <meta http-equiv="refresh" content="0.0000001;../registrar/Registrar_abastecimiento.php">
                    <?php
                }
            }
        }
        else
        {
            $Linea_actualizar = "UPDATE `medicamentos_abastecidos` SET `Cantidad_medicamento`= (Cantidad_medicamento+$cantidad), stat = 'Espera' WHERE ID_medicamento = '$ID_medicamento' AND Folio_compra_proveedores = '$max';";
            $actualizar = mysqli_query($link, $Linea_actualizar);
            if($actualizar)
            {
                ?>
                    <meta http-equiv="refresh" content="0.0000001;../registrar/Registrar_abastecimiento.php">
                <?php
            }
        }
    }
    else
    {
        $InsertData = "INSERT INTO `medicamentos_abastecidos`(`Folio_medicamento_comprado`, `Folio_compra_proveedores`, `ID_medicamento`, `Cantidad_medicamento`, `Precio_medicamento_actual`, `stat`) VALUES ('$new_id','$max','$ID_medicamento','$cantidad','$precio','Espera')";
        $insert_user = mysqli_query($link, $InsertData);
        if($insert_user)
        {
            ?>
                <meta http-equiv="refresh" content="0.0000001;../registrar/Registrar_abastecimiento.php">
            <?php
        }
    }

mysqli_close($link); 
?>