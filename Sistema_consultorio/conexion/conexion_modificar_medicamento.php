<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");

if(!$link)
    echo "error";

$ID_med = $_GET['medicina'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$tipo = $_POST['tipo'];
$via = $_POST['via'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];
$proveedor = $_POST['proveedor'];

if( $nombre || $descripcion || $tipo != "no" || $via != "no" || $precio || $cantidad || $proveedor)
{
    if($nombre)
    {
        $actualiza = "UPDATE medicamentos SET Nombre_medicamento = '$nombre' WHERE ID_medicamento = '$ID_med';";
        $update = mysqli_query($link, $actualiza);
    }
    if($descripcion)
    {
        $actualiza = "UPDATE medicamentos SET Descripcion = '$descripcion' WHERE ID_medicamento = '$ID_med';";
        $update = mysqli_query($link, $actualiza);
    }
    if($tipo != "no")
    {
        $actualiza = "UPDATE medicamentos SET TIpo_de_medicamento =  '$tipo' WHERE ID_medicamento = '$ID_med'";
        $update = mysqli_query($link, $actualiza);       
   
    }
    if($via != "no")
    {
        $actualiza = "UPDATE medicamentos SET Via_administracion = '$via' WHERE ID_medicamento = '$ID_med'";
        $update = mysqli_query($link, $actualiza);
    }
    if($precio)
    {
        $actualiza = "UPDATE medicamentos SET Precio = '$precio' WHERE ID_medicamento = '$ID_med'";
        $update = mysqli_query($link, $actualiza);
    }
    if($cantidad)
    {
        $actualiza = "UPDATE medicamentos SET Precio_inicial = '$cantidad' WHERE ID_medicamento = '$ID_med'";
        $update = mysqli_query($link, $actualiza);
    }
    if($proveedor)
    {
        $actualiza = "UPDATE medicamentos SET Proveedor = '$proveedor' WHERE ID_medicamento = '$ID_med'";
        $update = mysqli_query($link, $actualiza);
    }
    include("../modificar/modificar_medicamento.php");
    ?>
        <script>
            $resp = alert("Se actualizó el registro con exito, Actualice la pagina para ver el cambio.");
            if($resp)setTimeout(() => {
                <?php header("location:../modificar/modificar_medicamento.php?medicina=$ID_med")?>
            }, 10000);  
        </script>
    <?php
}else
{   include("../modificar/modificar_medicamento.php");
    ?>
        <script>
            alert("no se actualizo el dato");
        </script>
    <?php
}
mysqli_close($link);
?>