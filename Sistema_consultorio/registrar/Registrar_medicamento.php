<?php
    include("../php/LOGIN.php");
    include("../php/script.php");
    $link = mysqli_connect("localhost", "root", "", "consultorio_db");
    if(!$link)
        echo "Error";
    $admin = $_SESSION['admin'];
    if(!$admin)
        header("location:../php/Main.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registra medicamento</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/Registro_medicamento.css">
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
                <p> Para realizar una venta de medicamentos tiene que dar clic en el enlace anterior. .</p>
            </li>
            <br>
            <li><a href="../modificar/vizualizar_medicamento.php"> Modificar informacion de medicamento.</a>
                <p>
                    Si quiere modificar un medicamento de clic en el link anterior.
                </p>
            </li>
            <br>
            <li><a href="../registrar/registrar_abastecimiento.php">Abastecer medicamento.</a>
                <p>
                    De clic en la opcion anterior para realizar el abastecimiento.
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
        $obtiene_ID = "SELECT MAX(ID_medicamento) AS maximo FROM medicamentos;";
        $obtener_maximo = mysqli_query($link, $obtiene_ID);
        $row = $obtener_maximo->fetch_array();
    
        $new_id = $row['maximo']+1;
        $vector = array(0, 0, 0, 0, 0, 0, 0, 0);
        #Verifica y crea un nuevo id que sea diferente del nuevo maximo para agregar 8 digitos
        for($var = 7; $var >= 0; $var--)
        {
            $vector[$var] = $new_id % 10;
            $new_id /= 10;
        }
        $new_id = $vector[0].$vector[1].$vector[2].$vector[3].$vector[4].$vector[5].$vector[6].$vector[7];
?>
        <div class="contenedor2">
            <div class="info">
                <form method="post"  action="../conexion/conexion_registrar_medicamento.php">
                  <h1>Registrar medicamento.</h1>
                  <h2 style="font-size: 25px; margin-left:290px; margin-top:30px; border-bottom: 0px solid white; width:max-content">
                  ID medicamento: <?php echo $new_id; ?></h2>
                  <li> 
                      <h2>Nombre del medicamento:</h2>
                      <input name="nombre" type="text" maxlength="100" onkeyup="this.value=this.value.toUpperCase();" required>
                  </li>
                  <li> 
                      <h2>Descripcion:</h2>
                      <textarea name="descripcion" id="desc" cols="36" rows="8" maxlength="500"></textarea>
                      <!--<input id="desc" name="descripcion" type="text"  onkeypress="return Solo_letras(event);">-->
                  </li>
                  <li> 
                      <h2>Tipo de medicamento:</h2>
                      <select name="tipo" id="seleccion" required>
                          <option value="" disabled selected="">Seleccione tipo de medicamento</option>
                          <option value="No controlado">No controlado.</option>
                          <option value="Controlado">Controlado.</option>
                      </select>
                  </li>
                  <li> 
                      <h2>Via de administracion:</h2>
                      <select name="via" id="seleccion" required>
                          <option value="" disabled selected="">Seleccione Via de administracion</option>
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
                  </li>
                  <li> 
                      <h2>Precio de compra:</h2>
                      <input name="precio_compra" type="text" onkeypress="return solo_precio(event);" required>
                  </li>
                  <li> 
                      <h2>Precio de venta:</h2>
                      <input name="precio" type="text" onkeypress="return solo_precio(event);" required>
                  </li>
                  <li> 
                      <h2>Proveedor:</h2>
                      <input name="proveedor" type="text" maxlength="50">
                  </li>
                    <!--<li>
                        <h2 style="color: darkred; font-size: 30px;">ID de autorizacion:</h2>
                        <input name="id" type="password" maxlength="8" pattern=".{8,8}" required>
                    </li>-->
                    <button class="actualizar" onclick="return confirma_registro()">Registrar medicamento.</button>   
                </form>
            </div>
        </div>
    </div>
</body>
</html>