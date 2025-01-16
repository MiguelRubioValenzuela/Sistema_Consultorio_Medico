<?php
#        Conexion SQL     Host   Usuario  Password DataBase
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";
    # declaracion de variables
#$ID = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$tipo = $_POST['tipo'];
$cantidad = 0;
$precio_compra = $_POST['precio_compra'];
$via = $_POST['via'];
$precio = $_POST['precio'];
$proveedor = $_POST['proveedor'];

    #Obtiene el ID maximo de los usuarios que no sean medicos
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

    $mostrar = $row['maximo']+1;
    $vector = array(0, 0, 0, 0, 0, 0, 0, 0);
    for($var = 7; $var >= 0; $var--)
    {
        $vector[$var] = $mostrar % 10;
        $mostrar /= 10;
    }
    $mostrar = $vector[0].$vector[1].$vector[2].$vector[3].$vector[4].$vector[5].$vector[6].$vector[7];
    #Una ves que se obtiene el nuevo ID lo compara con el id de los medicos
    $InsertData = "INSERT INTO medicamentos (ID_medicamento, Nombre_medicamento, Descripcion, Tipo_de_medicamento, Cantidad, Via_administracion, Precio_inicial, Precio, Proveedor, stat) VALUES ( '$new_id','$nombre','$descripcion','$tipo','$cantidad','$via','$precio_compra','$precio','$proveedor', 'Activo')";
    $insert_user = mysqli_query($link, $InsertData);
    include("../registrar/Registrar_medicamento.php");
    ?>
    <script>
        confirm("<?php print "Medicamento registrado con ID: $mostrar"?>");
    </script>
    <?php


    #include("../registrar/Registrar_medicamento.php");
    #?>
    <!--<script>
        alert("Credenciales de autorizacion invalidas, no puede registrarse.");
    </script>
    <?php

mysqli_close($link); 
?>