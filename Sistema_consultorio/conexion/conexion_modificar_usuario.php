<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");

if(!$link)
    echo "error";

$usuario = $_GET['user'];
$curp = $_POST['curp'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['correo'];
$pass = $_POST['password'];
$pass_comparar = $_POST['confirm'];

if($curp || $nombre || $telefono || $email || $pass)
{
    if($nombre)
    {
        $actualiza = "UPDATE usuarios SET Nombre_completo_usuario = '$nombre' WHERE ID_usuario = '$usuario';";
        $update = mysqli_query($link, $actualiza);
    }
    if($pass)
    {
        $password = md5($pass);
        $password_comparar = md5($pass_comparar);
        if($password == $password_comparar)
        {
            $actualiza = "UPDATE usuarios SET contraseña = '$password' WHERE ID_usuario = '$usuario';";
            $update = mysqli_query($link, $actualiza);
            ?>
                <script>
                    confirm("Se actualizó la contraseña con exito.");
                </script>
            <?php
        }
        else{
            ?>
                <script>
                    confirm("Las contraseñas no coinciden");
                    </script>
            <?php
        }
    }
    if($telefono)
    {
        $obtiene_telefono = "SELECT Telefono_usuario FROM usuarios WHERE Telefono_usuario = '$telefono';";
        $telefono_similar = mysqli_query($link, $obtiene_telefono);
        if($telefono_similar) $row_telefono = $telefono_similar->fetch_array();

        if($row_telefono)
        {
            ?>
                <script>
                    confirm("El telefono ya está registrado en otro usuario o es el mismo.")
                </script>
            <?php
        }else
        {
            $actualiza = "UPDATE usuarios SET Telefono_usuario =  '$telefono' WHERE ID_usuario = '$usuario'";
            $update = mysqli_query($link, $actualiza);
        }        
    }
    if($email)
    {
        $obtiene_email = "SELECT Correo_electronico_usuario FROM usuarios WHERE Correo_electronico_usuario = '$email';";
        $email_similar = mysqli_query($link, $obtiene_email);
        if($email_similar) $row_email = $email_similar->fetch_array();
        
        if($row_email)
        {
            ?>
                <script>
                    confirm("Email ya esta en uso por otro usuario o es el mismo.")
                </script>
            <?php
        }else
        {
            $actualiza = "UPDATE usuarios SET Correo_electronico_usuario = '$email' WHERE ID_usuario = '$usuario'";
            $update = mysqli_query($link, $actualiza);
        }
    }
    if($curp)
    {
        $obtiene_curp = "SELECT Curp_usuario FROM usuarios WHERE Curp_usuario = '$curp';";
        $curp_similar = mysqli_query($link, $obtiene_curp);
        if($curp_similar) $row_curp = $curp_similar->fetch_array();

        if($row_curp)
        {
            ?>
                <script>
                    confirm("Esta es la CURP de otro usuarios, o ingresaste la misma CURP.")
                </script>
            <?php
        }else
        {

            $actualiza = "UPDATE usuarios SET Curp_usuario = '$curp' WHERE ID_usuario = '$usuario'";
            $update = mysqli_query($link, $actualiza);
        }
    }
    ?>
    <script>alert("Datos actualizados con exito")</script>
    <meta http-equiv="refresh" content="0.00001;../consulta/Consulta_usuarios.php">
    <?php
}else
{
    header("location:../consulta/Consulta_usuarios.php");
}
mysqli_close($link);
?>