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
    <link rel="stylesheet" href="../CSS/consulta_cita.css">
    
    <!-- script JS -->
    <script src='../fullcalendar/packages/web-component/index.global.min.js'></script>
    <script src='../fullcalendar/dist/index.global.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        initialDate: '<?php echo date('Y-m-d');?>',
        selectable: true,
        headerToolbar: 
        {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: 
        [ 
<?php     $obtiene_citas = "SELECT * FROM citas WHERE stat != 'Eliminada';";
          $citas_registradas = mysqli_query($link, $obtiene_citas);
          if($citas_registradas -> num_rows > 0)
          {
            while($mostrar = mysqli_fetch_array($citas_registradas))
            {
              $curp = $mostrar['CURP_Paciente'];
              $get_nombre = "SELECT Nombre_completo_paciente FROM paciente WHERE Curp_paciente = '$curp';";
              $obtuvo_nombre = mysqli_query($link, $get_nombre);
              $nombre = mysqli_fetch_array($obtuvo_nombre);
?>            {
                groupId: '<?php echo $mostrar['Folio_cita']; ?>',
<?php           if($mostrar['stat'] == "Cancelada")
                {
?>                  title: '!!Cancelada!! Cita: <?php echo $nombre['Nombre_completo_paciente']?>',
<?php           }else
                {
?>                  title: 'Cita: <?php echo $nombre['Nombre_completo_paciente']?>',
<?php           }
?>              url: '../consulta/consulta_cita_agendada.php?folio=<?php echo $mostrar['Folio_cita']; ?>',
                start: '<?php echo $mostrar['Fecha_inicio'].'T'.$mostrar['Hora_inicio'];?>',
                end: '<?php echo $mostrar['Fecha_fin'].'T'.$mostrar['Hora_fin'];?>',
<?php           if($mostrar['stat'] == "Espera")
                {
?>                  color: '#009bdf'
<?php           }elseif($mostrar['stat'] == "Cancelada")
                {
?>                  color: '#df0000'
<?php           }else
                {
?>                  color: '#00df07'
<?php           }
?>            },
<?php       }
          }
?>      ],
        //dateClick: function(info) {
          //alert('clicked ' + info.dateStr);
        //},
        select: function(info) 
        {
          if(confirm('Desea registrar la cita el dia seleccionado')){
            window.location.assign('../conexion/Conexion_registra_cita.php?fecha='+info.startStr+'&fechafin='+info.endStr);
          }
        }
      });
  calendar.render();
});

    </script>
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
            <li><a href="../registrar/Registrar_paciente.php">Registra paciente.</a>
                <p>Si el paciente no se encuentra registrado usted puede registrarlo acediendo al link anterior.</p>
            </li>
            <br>
                <li><a href="../consulta/consulta_pacientes.php">Vizualizar Paciente.</a>
                <p>Si no conoce una CURP para agendar la cita, puede vizualizarla accediendo al link anterior.</p>
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
        <div id='calendar'></div>
    </div>
</body>
</html>