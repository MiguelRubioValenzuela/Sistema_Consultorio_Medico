<?php
include('../php/LOGIN.php');
include('../php/script.php');
#        Conexion SQL     Host   Usuario  Password DataBase
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";
    # declaracion de variables
$dosis = $_POST['Dosis'];
$ID_medicamento = $_GET['medicina'];
$folio_receta = $_GET['folio_receta'];

    #Obtiene el ID maximo del folio de medicamentos comprados
    $Obtiene_id_folio = "SELECT MAX(Folio_Medicamento_Receta) AS maximo FROM medicamentos_receta";
    $ID_folio = mysqli_query($link, $Obtiene_id_folio);
    $new_id = 0;
    if($ID_folio -> num_rows > 0)
    {
        $row = $ID_folio->fetch_array();
        $new_id = $row['maximo']+1;
    }

    #Obtiene el precio del medicamento ingresado y el ID para solo añadir el valor de cantidad a la que ya se tiene
    $Obtiene_precio = "SELECT * FROM medicamentos WHERE ID_medicamento = '$ID_medicamento';";
    $precio_inicial= mysqli_query($link, $Obtiene_precio);
    $initial = $precio_inicial->fetch_array();

    #Una ves que se obtiene el nuevo ID lo compara con el id registrado
    $comprobar = "SELECT ID_Medicamento FROM medicamentos_receta WHERE ID_Medicamento = '$ID_medicamento' AND Folio_Receta = '$folio_receta';";
    $comprobacion = mysqli_query($link, $comprobar);
    $medicamento = '';
    if($comprobacion -> num_rows > 0)
    {
        $MEDS = mysqli_fetch_array($comprobacion);
        $medicamento = $MEDS['ID_Medicamento'];   
    }

    if($ID_medicamento == $medicamento)
    {   
            $Linea_actualizar = "UPDATE `medicamentos_receta` SET Dosis = '$dosis', stat = 'Espera' WHERE ID_Medicamento = '$ID_medicamento' AND Folio_Medicamento_Receta = '$folio_receta';";
            $actualizar = mysqli_query($link, $Linea_actualizar);
            if($actualizar)
            {
            ?>
                <meta http-equiv="refresh" content="0.0000001;../registrar/Registrar_medicamento_receta.php?folio=<?php echo $folio_receta?>">
            <?php
        }
    }
    else
    {
        $folio_rec = "SELECT Folio_receta FROM recetas WHERE Folio_cita = '$folio_receta';";
        $receta = mysqli_query($link, $folio_rec);
        $folio_Recetado = mysqli_fetch_array($receta);
        $folio_receta = $folio_Recetado['Folio_receta'];
        $medicamento = '';
        echo $new_id.''.$folio_receta;
        $InsertData = "INSERT INTO `medicamentos_receta` (`Folio_Medicamento_Receta`, `Folio_Receta`, `ID_Medicamento`, `Dosis`, `stat`) VALUES ('$new_id','$folio_receta','$ID_medicamento','$dosis','Espera')";
        $insert_user = mysqli_query($link, $InsertData);
        if($insert_user)
        {
            ?>
                <meta http-equiv="refresh" content="0.0000001;../registrar/Registrar_medicamento_receta.php?folio=<?php echo $folio_receta?>">
            <?php
        }
    }

mysqli_close($link); 
?>