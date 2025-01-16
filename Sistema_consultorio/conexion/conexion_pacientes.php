<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$curp = $_POST['curp'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['correo'];
$fecha = $_POST['fecha'];
$sexo = $_POST['sexo'];

$obtiene_curp = "SELECT Curp_paciente, stat FROM paciente WHERE Curp_paciente = '$curp';";
$curp_similar = mysqli_query($link, $obtiene_curp);
if($curp_similar) $row_curp = $curp_similar->fetch_array();

$obtiene_email = "SELECT Correo_electronico_paciente FROM paciente WHERE Correo_electronico_paciente = '$email';";
$email_similar = mysqli_query($link, $obtiene_email);
if($email_similar) $row_email = $email_similar->fetch_array();

$obtiene_telefono = "SELECT Telefono_paciente FROM paciente WHERE Telefono_paciente = '$telefono';";
$telefono_similar = mysqli_query($link, $obtiene_telefono);
if($telefono_similar) $row_telefono = $telefono_similar->fetch_array();

include("../registrar/Registrar_paciente.php");
if($row_curp || $row_email || $row_telefono)
{
    if($row_curp)
    {
        $status = $row_curp['stat'];
        $curp_paciente = $row_curp['Curp_paciente'];
        if($status == "Activo")
        {

            ?>
            <h1 style="background-color:darkred; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 20px 10px 20px 10px; color:white; font-size:28px;" >
                <?php 
                    print "CURP ya registrada, se necesita nueva CURP para continuar con el registro.";
                    ?>
            </h1>
            <?php
        }else
        {
            $elimina = "UPDATE paciente SET stat = 'Activo' WHERE Curp_paciente = '$curp_paciente'";
            $delete = mysqli_query($link, $elimina);
            ?>
            <script>
                alert('El registro que acabas de ingresar ya estaba registrado anteriormente, accede a modificacion para realizar los cambios requeridos');
            </script>
            <meta http-equiv="refresh" content="0.0000001;../registrar/Registrar_paciente.php">
            <?php
        }
    }
    if($row_email)
    {
        ?>
            <h1 style="background-color:darkred; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 20px 10px 20px 10px; color:white; font-size:28px;" >
                <?php 
                    print "Correo electronico ya esta en uso, ingrese uno nuevo.";
                ?>
            </h1>
        <?php
    }
    if($row_telefono)
    {
        ?>
            <h1 style="background-color:darkred; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 20px 10px 20px 10px; color:white; font-size:28px;" >
                <?php 
                    print "El telefono ya se encuentra registrado, ingrese uno nuevo.";
                ?>
            </h1>
        <?php
    }
}
else{
    $insertar = "INSERT INTO paciente VALUES ('$curp','$telefono','$email','$nombre','$fecha','$sexo', 'Activo');";
    $insertar_paciente = mysqli_query($link, $insertar);
    if($insertar_paciente)
    {
    ?>
        <h1 style="background-color:darkgreen; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 20px 10px 20px 10px; color:white; font-size:28px;" >
            <?php 
                print "Se insertó un nuevo paciente.";
            ?>
        </h1>
    <?php
    }
}


?>