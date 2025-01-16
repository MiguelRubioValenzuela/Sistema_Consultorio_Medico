<?php
#        Conexion SQL     Host   Usuario  Password DataBase
include('../PHP/LOGIN.php');
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";
    # declaracion de variables
#$ID = $_POST['id'];

$paciente = $_POST['paciente'];
$fechainicio = $_GET['fechainicio'];
$fechafin = $_GET['fechafin'];
if(isset($_GET['inicio']))
{
    $inicio = $_GET['inicio'];
}else
{
    $inicio = $_POST['inicio'];
}

if(isset($_GET['final']))
{
    $final = $_GET['final'];
}else
{
    $final = $_POST['final'];
}

    if($final < $inicio)
    {
?>
    <script>
        alert('La hora final no puede ser menor que la hora inicial');
    </script>
    <meta http-equiv="refresh" content="0.000001;../conexion/Conexion_registra_cita.php?fecha=<?php echo $fechainicio;?>&fechafin=<?php echo $fechafin;?>">
<?php
    }
    else
    {
        $obtiene_fecha = "SELECT *  FROM citas WHERE Fecha_inicio = '$fechainicio' AND (Hora_inicio > '$inicio' AND Hora_inicio < '$final') OR (Hora_fin > '$inicio' AND Hora_fin < '$final') AND stat = 'Espera' ;";
        $obteniendo_fecha = mysqli_query($link, $obtiene_fecha);
        if($obteniendo_fecha -> num_rows > 0)
        {
?>          <script>
                alert('La hora que intenta ingresar ya esta asignada a una cita, ingrese otra');
            </script>
            <meta http-equiv="refresh" content="0.000001;../conexion/Conexion_registra_cita.php?fecha=<?php echo $fechainicio;?>&fechafin=<?php echo $fechafin;?>">
<?php
        }
        else
        {
            $obtiene_nombre = "SELECT Nombre_completo_paciente FROM paciente WHERE Curp_paciente = '$paciente';";
            $obteniendo_nombre = mysqli_query($link, $obtiene_nombre);
            if($obteniendo_nombre -> num_rows > 0)
            {
                $nombre_paciente = mysqli_fetch_array($obteniendo_nombre);
                
                $obtiene_max_cita = "SELECT MAX(Folio_cita) AS maximo FROM citas;";
                $cita_max = mysqli_query($link, $obtiene_max_cita);
                $maximo = mysqli_fetch_array($cita_max);
                $max;
                if(!$maximo['maximo']){
                    $max = 0;
                }else{
                    $max = $maximo['maximo'];
                }
                $new_id = $max+1;
                echo $new_id.'.'.$fechainicio.'.'.$inicio.','.$fechafin.','.$final.','.$paciente.','.$usuario.',';
                $insertando = "INSERT INTO `citas` (`Folio_cita`, `Fecha_inicio`, `Hora_inicio`, `Fecha_fin`, `Hora_fin`, `CURP_Paciente`, `ID_Usuario`, `stat`) VALUES ('$new_id','$fechainicio','$inicio','$fechafin','$final','$paciente','$usuario','Espera')";
                if(mysqli_query($link, $insertando))
                {
?>                  <script>
                        alert('Cita registrada con exito');
                    </script>
                    <meta http-equiv="refresh" content="0.000001;../consulta/Consulta_cita.php">
<?php           }   
            }
            else
            {
?>              <script>
                    alert('Paciente al que le intenta registrar la cita, no existe');
                </script>
                <meta http-equiv="refresh" content="0.000001;../conexion/Conexion_registra_cita.php?fecha=<?php echo $fechainicio;?>&fechafin=<?php echo $fechafin;?>">
<?php       }
        }
    }
mysqli_close($link); 
?>