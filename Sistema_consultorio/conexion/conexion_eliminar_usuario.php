<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$usuario = $_GET['user'];
$identificador = md5($_POST['IDadmin']);

$obtiene_admin = "SELECT Contraseña FROM usuarios WHERE Tipo = 'Admin'";
$ID_admin = mysqli_query($link, $obtiene_admin);
$AdminID = $ID_admin->fetch_array();
#Valida el ID administrador
if($identificador == $AdminID['Contraseña'])
{
    $elimina = "UPDATE usuarios SET stat = 'Inactivo' WHERE ID_usuario = '$usuario'";
    $delete = mysqli_query($link, $elimina);
    if($delete){
        include("../php/Sign_in.php");
        ?>
            <script>
                confirm("Se ha eliminado la informacion del usuario.")
            </script>
        <?php
    }
}
else{
    include("../modificar/modificar_usuario.php");
        ?>
            <script>
                confirm("ID de admin, es incorrecto, no se puede eliminar el registro.")
            </script>
        <?php
        #header("location:modificar_usuario.php");
}


?>
