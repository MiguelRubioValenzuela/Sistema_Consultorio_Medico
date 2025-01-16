<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$curp_paciente = $_GET['curp_paciente'];
$curp = $_POST['curp'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['correo'];

if($curp || $nombre || $telefono || $email)
{
    if($nombre)
    {
        $actualiza = "UPDATE paciente SET Nombre_completo_paciente = '$nombre' WHERE Curp_paciente = '$curp_paciente';";
        $update = mysqli_query($link, $actualiza);
    }
    if($telefono)
    {
        $obtiene_telefono = "SELECT Telefono_paciente FROM paciente WHERE Telefono_paciente = '$telefono';";
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
            $actualiza = "UPDATE paciente SET Telefono_paciente =  '$telefono' WHERE Curp_paciente = '$curp_paciente'";
            $update = mysqli_query($link, $actualiza);
        }        
    }
    if($email)
    {
        $obtiene_email = "SELECT Correo_electronico_paciente FROM paciente WHERE Correo_electronico_paciente = '$email';";
        $email_similar = mysqli_query($link, $obtiene_email);
        if($email_similar) $row_email = $email_similar->fetch_array();
        
        if($row_email)
        {
            ?>
                <script>
                    confirm("Email ya esta en uso por otro usuaario o es el mismo.")
                </script>
            <?php
        }else
        {
            $actualiza = "UPDATE paciente SET Correo_electronico_paciente = '$email' WHERE Curp_paciente = '$curp_paciente'";
            $update = mysqli_query($link, $actualiza);
        }
    }
    if($curp)
    {
        $obtiene_curp = "SELECT Curp_paciente FROM paciente WHERE Curp_paciente = '$curp';";
        $curp_similar = mysqli_query($link, $obtiene_curp);
        if($curp_similar) $row_curp = $curp_similar->fetch_array();

        if($row_curp)
        {
            ?>
                <script>
                    confirm("Esta es la CURP de otro paciente, o ingresaste la misma CURP.")
                </script>
            <?php
        }else
        {

            $actualiza = "UPDATE paciente SET Curp_paciente = '$curp' WHERE Curp_paciente = '$curp_paciente'";
            $update = mysqli_query($link, $actualiza);
        }
    }
    ?>
    <script>alert("Datos actualizados con exito")</script>
    <meta http-equiv="refresh" content="0.00001;../consulta/consulta_pacientes.php">
    <?php
}else
{
    header("location:../modificar/modificar_paciente.php?curp=$curp_paciente");
}
mysqli_close($link);
?>