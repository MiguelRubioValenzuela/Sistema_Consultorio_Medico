<?php
#        Conexion SQL     Host   Usuario  Password DataBase
include('../PHP/LOGIN.php');
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";
    # declaracion de variables
#$ID = $_POST['id'];
$folio = $_GET['folio'];
$fechainicio = $_POST['fecha'];
if($fechainicio == '')
{
    $fecha_obtenida= "SELECT Fecha_inicio FROM citas WHERE Folio_cita = '$folio';";
    $Date_GET = mysqli_query($link, $fecha_obtenida);
    $date = mysqli_fetch_array($Date_GET);
    $fechainicio = $date['Fecha_inicio'];
}
$inicio = $_POST['hora_inicio'];
$final = $_POST['hora_fin'];

    if($final < $inicio)
    {
?>
    <script>
        alert('La hora final no puede ser menor que la hora inicial');
    </script>
    
    <meta http-equiv="refresh" content="0.000001;../modificar/modificar_cita.php?folio=<?php echo $folio;?>">
<?php
    }
    else
    {
        $obtiene_fecha = "SELECT * FROM citas WHERE Folio_cita != '$folio' AND Fecha_inicio = '$fechainicio' AND ((Hora_inicio >= '$inicio' AND Hora_inicio < '$final') OR (Hora_fin > '$inicio' AND Hora_fin <= '$final')) AND stat = 'Espera' ;";
        $obteniendo_fecha = mysqli_query($link, $obtiene_fecha);
        if($obteniendo_fecha -> num_rows > 0)
        {
?>          <script>
                alert('La hora que intenta ingresar ya esta asignada a una cita, ingrese otra');
            </script>
            <meta http-equiv="refresh" content="0.000001;../modificar/modificar_cita.php?folio=<?php echo $folio;?>">
<?php
        }
        else
        {
            $insertando = "UPDATE citas SET Fecha_inicio = '$fechainicio', Fecha_fin = '$fechainicio', Hora_inicio = '$inicio', Hora_fin = '$final' WHERE Folio_cita = '$folio';";
            if(mysqli_query($link, $insertando))
            {
?>              <script>
                    alert('Cita registrada con exito');
                </script>
                <meta http-equiv="refresh" content="0.000001;../consulta/Consulta_cita.php">
<?php       }   
        }
    }
mysqli_close($link); 
?>