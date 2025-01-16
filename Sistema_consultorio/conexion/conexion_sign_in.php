<?php

$ID = $_POST['ID'];
$password = md5($_POST['password']);

$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "Error";

$verificar = "SELECT * FROM usuarios WHERE ID_usuario = '$ID' AND Contraseña = '$password' AND stat = 'Activo'" ;
$verificacion = mysqli_query($link, $verificar);
$resultado = mysqli_num_rows($verificacion);

if($resultado)
{
    session_start();
    $_SESSION['user'] = $ID;
    header("location:../php/Main.php");
}
else{

    session_start();
    $_SESSION['user'] = '';
    include("../php/Sign_in.php")

?>
    <h1 style="position: relative; background-color:darkred; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 10px 10px 10px 10px; ">
        Credenciales erroneas.
    </h1>
<?php

}




?>