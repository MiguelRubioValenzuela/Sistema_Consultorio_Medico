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
    <title>Venta de medicamentos.</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/vender_medicamento.css">
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
            }
            else
            {
?>
                <li><a href="../php/auth.php?tipo=registro">Registrar medicamentos..</a>
<?php
            }
?>
                    <p> Para registrar medicamentos debes contar con la autorizacion necesaria .</p>
                </li>
            <br>
<?php
            if($_SESSION['admin'])
            {
?>
                <li><a href="../modificar/vizualizar_medicamento.php"> Modificar informacion de medicamento.</a>
                    <p>Si quiere modificar un medicamento de clic en el link anterior.</p>
                </li>
<?php   
            }
            else
            {
?>
                <li><a href="../php/auth.php?tipo=modificar"> Modificar informacion de medicamento.</a>
                    <p>Si quiere modificar un medicamento de clic en el link anterior.</p>
                </li>                
<?php
            }
            
?>
            <br>
<?php
            if($_SESSION['admin'])
            {
?>
                <li><a href="../registrar/Registrar_abastecimiento.php">Abastecer medicamento.</a>
<?php   
            }
            else
            {
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
            <h1>VENTA DE MEDICAMENTOS.</h1>
            <table class="table">
            <tr>
                        <td colspan="7" class="tablita">
                            Medicamentos.
                        </td>
                    </tr>
                    <tr>
                        <td class="posicion" >Medicamento:</td>
                        <td class="posicion2" >Control:</td>
                        <td class="posicion3" >Via administracion:</td>
                        <td class="posicion4" >Cantidad:</td>
                        <td class="posicion5" >Precio:</td>
                        <td class="posicion7" >Ver:</td>
                        <td class="posicion6" >Vender:</td>
                    </tr>
            </table>
            <div class="tabla">
                <table>
                    <?php

                        $obtener = "SELECT * FROM medicamentos WHERE stat = 'Activo' $where";
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
                                    <td class="visualizar">
                                        <form method="post" action="../consulta/consultar_medicamento.php?medicina=<?php echo $mostrar['ID_medicamento']; ?>">
                                            <button><p>Ver</p></button>
                                        </form>
                                    </td>
                                    <td class="botones">
                                        <form method="post" action="../conexion/conexion_venta.php?identificador_med=<?php echo $mostrar['ID_medicamento']; ?>">
                                            <input type="submit" id="menos" name="restar" value="-">
                                            <input name="cant" type="text" onkeypress="return Solo_numeros(event)" maxlength="3" placeholder="Cantidad" required> 
                                            <button><p>+</p></button>
                                        </form>
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
        <?php

$nomU = "SELECT Nombre_completo_usuario FROM usuarios WHERE ID_usuario = '$usuario'";
$nomb_user = mysqli_query($link, $nomU);
$nombre_usuario = mysqli_fetch_array($nomb_user);

$Obtiene_id_folio = "SELECT MAX(Folio_ventas) AS maximo FROM ventas";
$ID_folio = mysqli_query($link, $Obtiene_id_folio);
$maximo = mysqli_fetch_array($ID_folio);
$max;
if(!$maximo['maximo']){
    $max = 0;
}else{
    $max = $maximo['maximo'];
}
$aux = $max;
$Obtiene_status = "SELECT stat, ID_usuario FROM ventas WHERE Folio_ventas = '$max';";
$stat = mysqli_query($link, $Obtiene_status);
$stats = mysqli_fetch_array($stat);
$status;

if($stats){
    $status = $stats['stat'];
    if($status == 'Vendido') {$aux = $max+1;}    
}else {$aux = $max+1;}

if($aux > $max)
{
    $inserta_folio = "INSERT INTO ventas (Folio_ventas, ID_usuario, stat) VALUES ('$aux', '$usuario', 'Espera')";
    $inserta = mysqli_query($link, $inserta_folio);
}
$ids = $stats['ID_usuario'];
if($ids != $usuario)
{
    $actualiza_user = "UPDATE ventas SET ID_usuario = '$usuario' WHERE Folio_ventas = '$aux'";
    $actualiza = mysqli_query($link, $actualiza_user);
}

$Obtiene_curp = "SELECT Curp_paciente FROM ventas WHERE Folio_ventas = '$aux';";
$curp = mysqli_query($link, $Obtiene_curp);
if($curp -> num_rows > 0)
{   
    $paciente = mysqli_fetch_array($curp);
    $nombre_paciente = $paciente['Curp_paciente'];
    $Obtiene_paciente = "SELECT Nombre_completo_paciente FROM paciente WHERE Curp_paciente = '$nombre_paciente';";
    $Paciente_nombre = mysqli_query($link, $Obtiene_paciente);
}
?>  
        <div class="contener_abas">
            <h1>Medicamentos a vender.</h1>
            <div class="cont_folio">
                <h2 class="folios">Folio: <br><?php    echo $aux?></h2>
                <h2 class="nombres">Encargado: <br><?php    echo $nombre_usuario['Nombre_completo_usuario']?></h2>
                <h2 class="fecha">Fecha: <br><?php  echo date('Y-m-d')?></h2>
            </div>
<?php
                if($Paciente_nombre -> num_rows > 0)
                {   $pac = mysqli_fetch_array($Paciente_nombre);
?>
                    <div class="paciente">    
                        <h2>Paciente: <?php    echo $pac['Nombre_completo_paciente']?></h2>
                        <a href="../conexion/conexion_elimina_curp.php?curp=<?php echo $nombre_paciente?>&folio=<?php echo $aux?>"> Eliminar</a>
                    </div>
<?php
                }
?>
            
<?php

            $obtiene_medicamentos = "SELECT * FROM medicamento_ventas WHERE Folio_venta = '$aux' AND stat = 'Espera';";
            $medicamentos = mysqli_query($link, $obtiene_medicamentos);
            if($medicamentos -> num_rows >0)
            {
                $total = 0;
                $total_ganancias = 0;
                ?>
                <p id="num">No.</p>
                <p id="med">Medicamento:</p>
                <p id="can">Cant:</p>
                <p id="preu">$Un:</p>
                <p id="pret">Total:</p>
                <table class="Medicamentos">
                    <?php
                $cont = 1;
                while($mostrar = mysqli_fetch_array($medicamentos))
                {
                    $id = $mostrar['ID_Medicamento'];
                    $id_medicamentos = "SELECT Nombre_medicamento, Precio FROM medicamentos WHERE ID_medicamento = '$id';";
                    $Nombre_medicamento = mysqli_query($link, $id_medicamentos);
                    $nombre = mysqli_fetch_array($Nombre_medicamento); 
                    $total += ($mostrar['Precio_Medicamento_Actual']*$mostrar['Cantidad_Medicamento']);
                    ?>
                        <tr class="just">
                            <td id="mostrar1"><?php echo $cont?></td>
                            <td id="mostrar2"><?php echo $nombre['Nombre_medicamento']?></td>
                            <td id="mostrar3"><?php echo $mostrar['Cantidad_Medicamento']?></td>
                            <td id="mostrar4"><?php echo '$'.$mostrar['Precio_Medicamento_Actual']?></td>
                            <td id="mostrar5"><?php echo '$'.($mostrar['Precio_Medicamento_Actual']*$mostrar['Cantidad_Medicamento'])?></td>
                            <td id="mostrar6"><a href="../conexion/conexion_eliminar_venta.php?folio=<?php echo $mostrar['Folio_Medicamento_Venta'];?>">X</a></td>
                            <td id="punto">.</td>
                        </tr>
                        <tr id="no">
                            <td id="no">.</td>
                        </tr>                     
<?php           $cont += 1;
                $sub = ($total/100)*84;
                $iva = ($total/100)*16;           
                }
                ?>
                </table>   
                <table class="total">
                    <tr>
                        <td style="font-size: 20px; font-weight: normal;" >Sub-Total: </td>
                        <td style="font-size: 20px; font-weight: normal;"  id="num_total"><?php echo '$'.$sub;?></td>
                    </tr>
                    <tr>
                        <td style="font-size: 20px; font-weight: normal;"  >Iva (16%): </td>
                        <td style="font-size: 20px; font-weight: normal;"  id="num_total"><?php echo '$'.$iva;?></td>
                    </tr>
                    <tr>
                        <td >Total: </td>
                        <td id="num_total"><?php echo '$'.$total;?></td>
                    </tr>
                </table>
                    <a id="cancelar" href="../conexion/conexion_cancela_venta.php?folio=<?php echo $aux?>">Cancelar</a>
                    <form id="pago" method="post" action="../conexion/conexion_confirma_venta.php?folio=<?php echo $aux?>&total=<?php echo $total?>">                    
                        <input name="monto" id="monto" type="text" placeholder="Ingresa mónto para pagar." onkeypress="return solo_precio(event)" required>
                        <button id="abastecido">Pagar.</button>
                    </form>
<?php
        if(!$nombre_paciente)
        {
?>
            <form id="codigo" method="post" action="../conexion/conexion_agrega_curp.php?folio=<?php echo $aux?>">
                <p>Paciente a vender: </p>
                <input name="curp" type="text" placeholder="CURP" pattern=".{18,18}" maxlength="18" onkeyup="this.value=this.value.toUpperCase();" required>
                <button>Agregar</button>
            </form>
<?php
        }
    }
?>
    </div>
    
</body>
</html>