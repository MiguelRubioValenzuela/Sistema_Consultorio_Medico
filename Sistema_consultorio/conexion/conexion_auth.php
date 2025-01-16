<?php
$tipo = $_GET['tipo'];
$ID = md5($_POST['ID']);

$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "Error";

$verificar = "SELECT Nombre_completo_usuario FROM usuarios WHERE Contraseña = '$ID' AND Tipo = 'Admin';" ;
$verificacion = mysqli_query($link, $verificar);
$resultado = mysqli_num_rows($verificacion);
if($resultado)
{

    session_start();
    $_SESSION['admin'] = $ID;
    if($tipo == "registro")
    header("location:../registrar/Registrar_medicamento.php");
    if($tipo == "abastecer")
    header("location:../registrar/Registrar_abastecimiento.php");
    if($tipo == "modificar")
    header("location:../modificar/vizualizar_medicamento.php");
}
else{
    session_start();
    $_SESSION['admin'] = '';
    if($tipo == "registro")
    header("location:../php/auth.php?tipo=registro");
    if($tipo == "abastecer")
    header("location:../php/auth.php?tipo=abastecer");
    if($tipo == "modificar")
    header("location:../php/auth.php?tipo=modificar");
?>
    <script>
        confirm("No coinciden las credenciales de autorizacion.");
    </script>
<?php
}

?>