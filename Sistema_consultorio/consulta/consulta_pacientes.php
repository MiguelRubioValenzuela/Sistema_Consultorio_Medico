<?php
    include('../php/LOGIN.php');
    
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
    <title>PACIENTES</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/consulta_paciente.css">
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
            <li><a href="../registrar/Registrar_paciente.php">Registro nuevos pacientes.</a>
                <p>El registro solo es para pacientes nuevos.</p>
            </li>
            <br>
            <li><a href="Consulta_pacientes.php"> Modificar o VIsualizar registro.</a>
                <p>
                    Si quiere modificar registo dirijase a la siguiente seccion.
                </p>
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
                <label> Buscar por CURP: </label>
                <form method="GET"> 
                    <input type="text" name="curp" placeholder="Ingresa CURP." maxlength="18" onkeyup="this.value=this.value.toUpperCase();">
                    <button name="envia_curp" type="submit">Buscar</button>
                </form>   
            </div>
<?php
if(isset($_GET['envia_curp']))
{
    $busqueda = $_GET['curp'];
    if(isset($_GET['curp']))
    {
        $where = "AND Curp_paciente LIKE '%".$busqueda."%'";
    }
}
?>
            <div class="buscar2">  
                <label> Buscar por Nombre (completo): </label>  
                <form method="GET">
                    <input type="text" name="nombre" placeholder="Ingresa Nombre.">
                    <button name="enviar_nombre" type="submit"> Buscar </button>
                </form>   
            </div>
<?php
if(isset($_GET['enviar_nombre']))
{
    $busqueda = $_GET['nombre'];
    if(isset($_GET['nombre']))
    {
        $where = "AND Nombre_completo_paciente LIKE '%".$busqueda."%'";
    }
}
?>
        </div> 
        <div class="formulario">
            <h1>Tabla con todos los datos de pacientes.</h1>
            <table class="table">
                    <tr>
                        <td colspan="5" class="tablita">
                            Pacientes.
                        </td>
                    </tr>
                    <tr>
                        <td class="posicion" >CURP</td>
                        <td class="posicion2" >Nombre.</td>
                        <td class="posicion3" >Edad</td>
                        <td class="posicion4" >Sexo</td>
                        <td class="posicion5" >Boton</td>
                    </tr>
            </table>
            <div class="tabla">
            <table class="justifica">
<?php
$obtener = "SELECT * FROM paciente WHERE stat = 'Activo' $where ;";
$edad = "SELECT SUBSTRING((CURDATE())-(Fecha_nacimiento),1,2) AS Edad_actual FROM paciente WHERE stat = 'Activo'  $where;"; 
$resultado = mysqli_query($link, $obtener);
$edad_actual = mysqli_query($link, $edad);
if($resultado -> num_rows >0)
{
    while($mostrar = mysqli_fetch_array($resultado))
    {
        $age = mysqli_fetch_array($edad_actual);
        if($mostrar['sexo'] == 'M')
        $sexo = 'Masculino';
        if($mostrar['sexo'] == 'F')
        $sexo = 'Femenino';
        if($mostrar['sexo'] == 'X')
        $sexo = 'Sin especificar';
        
?>
                <tr>
                    <td class="pos"><?php echo $mostrar['Curp_paciente']; ?></td>
                    <td class="pos2"><?php echo $mostrar['Nombre_completo_paciente']; ?></td>
                    <td class="pos3"><?php echo $age['Edad_actual']; ?></td>
                    <td class="pos4"><?php echo $sexo; ?></td>
                    <td class="botones">
                        <div id="btn">
                            <a href="../modificar/modificar_paciente.php?curp=<?php echo $mostrar['Curp_paciente']?>">Modificar</a>
                        </div>
                        <div id="btn2">    
                            <a href="../php/ver_paciente.php?curp=<?php echo $mostrar['Curp_paciente']?>"> Ver </a>
                        </div>
                    </td>
                </tr>
<?php
        }
}else
{ 
?>
                <tr>
                    <td colspan="5" class="tablita2">
                        No existen registros....
                    </td>
                </tr>
            </table>
<?php
}
?>


            </div>
        </div>
    </div>
</body>
</html>