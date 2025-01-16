<?php
#        Conexion SQL     Host   Usuario  Password DataBase
include('../PHP/LOGIN.php');
include('../PHP/script.php');
$link = mysqli_connect('localhost', 'root', '', 'consultorio_db');
if(!$link)
    echo "error";
    # declaracion de variables
#$ID = $_POST['id'];!b5
$fecha = $_GET['fecha'];
$fechafin = $_GET['fechafin'];

$control = strpos($fecha, 'T');
$controlfin = strpos($fechafin, 'T');
$hora = 0;
$horafin = 0;
if($control != 0)
{
    $hora = substr($fecha, 11, 8 );
    $fecha = substr($fecha, 0, 10);
}
if($controlfin != 0)
{
    $horafin = substr($fechafin, 11, 8 );
    $fechafin = substr($fechafin, 0, 10);
}else
{
    $fechafin = $fecha;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario cita</title>
  <link rel="stylesheet" href="../CSS/citas.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="col-md-8 offset-md-2" style="margin-top: 150px;">
<?php
            if($hora != 0)
            {
?>              <form method="post" class="row formulario" action="conexion_cita_registrada.php?fechainicio=<?php echo$fecha;?>&fechafin=<?php echo$fechafin;?>&inicio=<?php echo$hora;?>&final=<?php echo$horafin;?>">
<?php       }
            else
            {
?>              <form class="row formulario" method="post" action="conexion_cita_registrada.php?fechainicio=<?php echo$fecha;?>&fechafin=<?php echo$fechafin;?>">
<?php       }
?>          <h1 style="text-align: center;">Registro de citas</h1>
                    <div class="col-6">
                        <label for="" class="form-label espacio">CURP del paciente a agendar cita</label>
                        <input name="paciente" type="text" class="form-control" placeholder="CURP" pattern=".{18,18}" maxlength="18" onkeyup="this.value=this.value.toUpperCase();"required>
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label espacio">Encargado que lo registra.</label>
                        <br>
<?php                   $get_nombre = "SELECT Nombre_completo_usuario FROM usuarios WHERE ID_usuario = '$usuario';";
                        $obtuvo_nombre = mysqli_query($link, $get_nombre);
                        $nombre = mysqli_fetch_array($obtuvo_nombre);
                        $nom = $nombre['Nombre_completo_usuario'];
?>                      <label for="" class="form-label informacion"><?php echo $nom;?></label>
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label espacio">Fecha inicio cita:</label>
                        <br>
                        <label for="" class="form-label informacion"><?php echo $fecha;?></label>
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label espacio">Fecha Fin cita:</label>
                        <br>
                        <label for="" class="form-label informacion"><?php echo $fechafin;?></label>
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label espacio">Hora asignada:</label>
                        <br>
    <?php               if($hora != 0)
                        {
    ?>
                            <label for="" class="form-label informacion"><?php echo $hora;?></label>
    <?php
                        }else
                        {
    ?>
                            <input name="inicio" type="time" class="form-control" placeholder="Hora inicio." required>
    <?php
                        }
    ?>                      
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label espacio">Hora de fin:</label>
                        <br>
    <?php               if($hora != 0)
                        {
    ?>
                            <label for="" class="form-label informacion"><?php echo $horafin;?></label>
    <?php
                        }else
                        {
    ?>
                            <input name="final" type="time" class="form-control" placeholder="Hora fin." required>
    <?php
                        }
    ?>                      
                    </div>
                    <div class="espacio"><p style="font-size: 1px; padding: 30px">.</p></div>
                    <button class="confirma">Confirmar</button>
                    <div class="espacio"><p style="font-size: 1px; padding: 30px">.</p></div>
                </form>
                <form action="../consulta/Consulta_cita.php">
                    <button class="cancela" onclick="return confirma_cancelacion();">Cancelar</button>
                </form>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($link); 
?>