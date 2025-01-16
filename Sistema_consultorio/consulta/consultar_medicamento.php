<?php
    include("../php/LOGIN.php");
    include("../php/script.php");
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $ID_med = $_GET['medicina'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificacion medicamentos</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/modifica_medicamento.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body>
    <header>   
        <div class="container">
            <p class="logo">Consulta_Pacientes.</p>
            <nav>
                <a href="../php/Main.php">Inicio.</a>
                <a href="../consulta/Consulta_cita.php">Citas.</a>
                <a href="../consulta/Consulta_ventas.php">Ventas.</a>
                <a href="../consulta/Consulta_abastecimiento.php">Abastecer.</a>
                <a href="../consulta/consulta_pacientes.php">Pacientes.</a>
                <a href="../consulta/Consulta_usuarios.php">Usuario.</a>
            </nav>
        </div>
    </header>
    <div class="contenedor">
        <div class="carta">
            <h1>Paginas a visitar.</h1>
            <li><a href="../php/vender_medicamento.php">Venta de medicamentos.</a>
                <p> Para realizar una venta de medicamentos tiene que dar clic en el enlace anterior.</p>
            </li>
            <br>
            <li><a href="../modificar/vizualizar_medicamento.php"> Modificar informacion de medicamento.</a>
                <p>Si quiere modificar un medicamento de clic en el link anterior.</p>
            </li>
            <br>
            <li><a href="../registrar/registrar_medicamento.php"> Registro de medicamentos.</a>
                <p>
                    Si quiere modificar un medicamento de clic en el link anterior.
                </p>
            </li>
            <br>
            <li><a href="../registrar/registrar_abastecimiento.php">Abastecer medicamento.</a>
                <p>
                    De clic en el menu anterior para realizar el abastecimiento.
                </p>
            </li>
            <br>
            <li><a href="../php/Main.php">Volver a inicio.</a>
                <p> Para regresar a el menu inicial puede
                    acceder a "Inicio." en la parte superior de la pantalla.
                    o acceder desde este enlace.  .</p>
            </li>
        </div>
<?php
$obtener_datos = "SELECT * FROM medicamentos WHERE ID_medicamento = '$ID_med' AND stat = 'Activo';";
$resultado = mysqli_query($link, $obtener_datos);
if($resultado -> num_rows > 0){
    $mostrar = mysqli_fetch_array($resultado);
?>
        <div class="contenedor2">
            <div class="info">
                <h1 class="header">
                    DATOS DE MEDICAMENTO
                </h1>
                <li> 
                    <h2>ID Medicamento:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['ID_medicamento'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Nombre:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Nombre_medicamento'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Descripcion:</h2>
                    <div class="textdesc">
                        <p><?php echo $mostrar['Descripcion'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Control:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Tipo_de_medicamento'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Via de administracion:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Via_administracion'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Cantidad:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Cantidad'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Precio a publico:</h2>
                    <div class="text">
                        <p><?php echo "$".$mostrar['Precio'];?></p>
                    </div>
                </li>
                <li> 
                    <h2>Proveedor:</h2>
                    <div class="text">
                        <p><?php echo $mostrar['Proveedor'];?></p>
                    </div>
                </li>
            </div>
        </div>
        <?php
}else
{
        ?>
        <div class="contenedor2">
            <div class="info">
                <h1>
                    VISUALIZACION DE REGISTRO.
                </h1>
                 <h2>No hay registros de pacientes ingresados</h2>
            </div>
        </div>
        <?php
}
        ?>
    </div>
</body>
</html>