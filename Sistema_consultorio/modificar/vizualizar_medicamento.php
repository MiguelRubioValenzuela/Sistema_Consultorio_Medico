<?php
    include('../php/LOGIN.php');
    include('../php/script.php');
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
    <link rel="stylesheet" href="../CSS/visualizar_medicamento.css">
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
        <?php
        if($_SESSION['admin'])
        {
        ?>
            <li><a href="../registrar/registrar_medicamento.php">Registrar medicamentos.</a>
        <?php   
        }else{
        ?>
            <li><a href="../php/auth.php?tipo=registro">Registrar medicamentos..</a>
        <?php
        }
        ?>
                <p> Para registrar medicamentos debes contar con la autorizacion necesaria .</p>
            </li>
            <br>
            <li><a href="../php/vender_medicamento.php">Venta de medicamentos.</a>
                <p> Para realizar una venta de medicamentos tiene que dar clic en el enlace anterior.</p>
            </li>
            <br>
        <?php
        if($_SESSION['admin'])
        {
        ?>
            <li><a href="../registrar/Registrar_abastecimiento.php">Abastecer medicamento.</a>
            <?php   
        }else{
        ?>
            <li><a href="../php/auth.php?tipo=abastecer">Abastecer medicamento.</a>
            <?php
        }
        ?>
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
        <div class="conta">
            <div class="buscar">  
            <label>Buscar por ID: </label>
                <form method="GET">
                    <input type="text" name="id" placeholder="Ingresa ID." maxlength="8" onkeypress="return Solo_numeros(event);">
                    <button name="presiona" type="submit">Buscar</button>
                </form>   
            </div>
<?php
if(isset($_GET['presiona']))
{
    $busqueda = $_GET['id'];
    if(isset($_GET['id']))
    {
        $where = "AND ID_medicamento LIKE'%".$busqueda."%';";
    }
}
?>
            <div class="buscar2">  
                <label> Busca Nombre: </label>  
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
        $where = "AND Nombre_medicamento LIKE'%".$busqueda."%';";
    }
}
?>          <div class="cont3">
                <div class="filtro">
                    <form style="margin-left:5px" method="GET" id="filtro">
                        <label>filtrar Control</label>
                        <select method="GET" name="filtro_control">
                            <option value="no" selected="">Todos</option>
                            <option value="No controlado">No controlado.</option>
                            <option value="Controlado">Controlado.</option>
                        </select>
                        <button class="fil" name="filtrar">buscar</button>
                    </form>
                </div>
            <?php
if(isset($_GET['filtrar']))
{
    if($_GET['filtro_control'] != "no")
    {
        $busqueda = $_GET['filtro_control'];
        $where = "AND Tipo_de_medicamento ='$busqueda';";
    }
}
?>              
                <div class="filtro2">
                    <form style="margin-left:-50px" method="GET" id="filtro2">
                        <label>Via administacion</label>
                        <select method="GET" name="eleccion" style="padding-right:40px">
                            <option value="no" selected="">Todos</option>
                            <option value="Cutanea">Cutanea.</option>
                            <option value="Inhalatoria">Inhalatoria.</option>
                            <option value="Intradérmica">Intradérmica.</option>
                            <option value="Intramuscular">Intramuscular.</option>
                            <option value="Intravenosa">Intravenosa.</option>
                            <option value="Nasal">Nasal.</option>
                            <option value="Ocular">Ocular.</option>
                            <option value="Oral">Oral.</option>
                            <option value="Ötica">Ötica.</option>
                            <option value="Rectal">Rectal.</option>
                            <option value="Subcutanea">Subcutanea.</option>
                            <option value="Sublingual">Sublingual.</option>
                            <option value="Tópica">Tópica.</option>
                            <option value="Transdérmica">Transdérmica.</option>
                            <option value="Vaginal">Vaginal.</option>
                        </select>
                        <button class="fil2" name="pulsar">buscar</button>
                    </form>
                </div>
            </div>
            <?php
$filtro1 = '';
if(isset($_GET['pulsar']))
{
    if($_GET['eleccion'] != "no")
    {
        $busqueda = $_GET['eleccion'];
        $where = "AND Via_administracion ='$busqueda';";
    }
}
?> 
        </div> 
        <div class="formulario">
            <h1>Tabla con todos los medicamentos a vender.</h1>
                <table class="table">
                <tr>
                            <td colspan="7" class="tablita">
                                Medicamentos.
                            </td>
                        </tr>
                        <tr>
                            <td class="posicion2" >Medicamento:</td>
                            <td class="posicion2" >Control:</td>
                            <td class="posicion3" >Via administracion:</td>
                            <td class="posicion4" >Cantidad:</td>
                            <td class="posicion5" >Precio:</td>
                            <td class="posicion5" >Status:</td>
                            <td class="posicion6">Abastecer:</td>
                        </tr>
                </tr>
                </table>    
            <div class="tabla">
                <table>
<?php
            $obtener = "SELECT * FROM medicamentos WHERE stat != '0' $where";
            $resultado = mysqli_query($link, $obtener);
            if($resultado -> num_rows >0)
            {
                while($mostrar = mysqli_fetch_array($resultado))
                {
?>
                    <tr>
                        <td class="med_nombre"><?php echo $mostrar['Nombre_medicamento']; ?></td>
                        <td class="med_cont"><?php echo $mostrar['Tipo_de_medicamento']; ?></td>
                        <td class="med_via"><?php echo $mostrar['Via_administracion']; ?></td>
                        <td class="med_cant"><?php echo $mostrar['Cantidad']; ?></td>
                        <td class="med_pre"><?php echo "$".$mostrar['Precio']; ?></td>
<?php
                    if($mostrar['stat'] == 'Activo')
                    {
?>
                            <td class="med_pre" style="background-color:green;"><?php echo "".$mostrar['stat']; ?></td>
<?php
                    }else
                    {
?>                  
                            <td class="med_pre" style="background-color:red;"><?php echo "".$mostrar['stat']; ?></td>
<?php
                    }
?>
                        <td class="botones">
                            <div id="btn">
                                <a href="../modificar/modificar_medicamento.php?medicina=<?php echo $mostrar['ID_medicamento']?>">Modificar</a>
                            </div>
                            <!--<div id="btn2">    
                                <a href="../php/ver_paciente.php"> Ver </a>
                            </div>-->
                        </td>
                    </tr>
<?php
                }
            }
            else
            {
?>
                    <tr>
                        <td colspan="7" class="tablita2">
                            No existen registros....
                        </td>
                    </tr>
<?php
            }
?>
                </table>    
            </div>
        </div>
    </div>
</body>
</html>