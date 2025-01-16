<?php
#        Conexion SQL     Host   Usuario  Password DataBase
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$obtiene_admin = "SELECT Contraseña AS id FROM usuarios WHERE Tipo = 'Admin'";
$ID_admin = mysqli_query($link, $obtiene_admin);
$AdminID = $ID_admin->fetch_array();
#Valida el ID administrador

if($AdminID)
{
    $ID = md5($_POST['IDs']);
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $telefono = $_POST['telefono'];
    $curp = $_POST['curp'];
    $tipo = $_POST['type'];
    $cedula;
    # Valida el tipo a medico para poder ingresar la cedula medica
    if($tipo == "Medico")
    {
        $cedula = $_POST['cedula_medica'];
    }
    #Obtiene el ID maximo de los usuarios que no sean medicos
    $obtiene_ID = "SELECT MAX(ID_usuario) AS maximo FROM usuarios WHERE Tipo != 'Medico'";
    $obtener_maximo = mysqli_query($link, $obtiene_ID);
    $row = $obtener_maximo->fetch_array();

    if($ID == $AdminID['id'])
    {
        $new_id = $row['maximo']+1;
        $vector = array(0, 0, 0, 0, 0, 0, 0, 0);
        #Verifica y crea un nuevo id que sea diferente del nuevo maximo para agregar 8 digitos
        for($var = 7; $var >= 0; $var--)
        {
            $vector[$var] = $new_id % 10;
            $new_id /= 10;
        }
        $new_id = $vector[0].$vector[1].$vector[2].$vector[3].$vector[4].$vector[5].$vector[6].$vector[7];
        #Una ves que se obtiene el nuevo ID lo compara con el id de los medicos
        $obtiene_ID_medico = "SELECT ID_usuario FROM usuarios WHERE Tipo = 'Medico';";
        $obtener_ID_diferente = mysqli_query($link, $obtiene_ID_medico);
        $old_id = $row['maximo']+1;
        if($obtener_ID_diferente)
                {   
                    while($fila_id_medico = $obtener_ID_diferente->fetch_array())
                    if($fila_id_medico['ID_usuario'] == $new_id)
                    {
                        $old_id++;
                        $aux = $old_id;
                        $vector = array(0, 0, 0, 0, 0, 0, 0, 0);
                        for($var = 7; $var >= 0; $var--)
                        {
                            $vector[$var] = $aux % 10;
                            $aux /= 10;
                        }
                        $new_id = $vector[0].$vector[1].$vector[2].$vector[3].$vector[4].$vector[5].$vector[6].$vector[7];
                    }
                }
        if($tipo == "Medico")
        {
            $new_id = $cedula;
        }
        $obtiene_datos = "SELECT * FROM usuarios";
        $obtener = mysqli_query($link, $obtiene_datos);
        $bandera = false;
        if($obtener -> num_rows > 0)
        {
            while($datos = mysqli_fetch_array($obtener))
            {
                if($email == $datos['Correo_electronico_usuario'] || $telefono == $datos['Telefono_usuario'] || $curp == $datos['Curp_usuario'])
                {
                    include("../registrar/Registrar_usuario.php");
                    if($email == $datos['Correo_electronico_usuario'])
                    {
                        ?>
                        <h1 style="background-color:darkred; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 10px 10px 10px 10px; ">
                            Correo electronico ya registrado.
                        </h1>
                        <?php
                    }
                    elseif($telefono == $datos['Telefono_usuario'])
                    {
                        ?>
                        <h1 style="background-color:darkred; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 10px 10px 10px 10px; ">
                            Telefono ya esta registrado
                        </h1>
                        <?php
                    }
                    elseif($curp == $datos['Curp_usuario'])
                    {
                        ?>
                        <h1 style="background-color:darkred; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 10px 10px 10px 10px; ">
                            Curp ya esta registrada.
                        </h1>
                        <?php
                    }
                }
                else
                {
                    $bandera = true;
                }
            }

        }else
        {
            $bandera = true;
        }
        if($bandera == true)
        {
            $InsertData = "INSERT INTO `usuarios`(`ID_usuario`, `Contraseña`, `Nombre_completo_usuario`, `Correo_electronico_usuario`, `Telefono_usuario`, `Curp_usuario`, `Tipo`, `stat` ) VALUES ( '$new_id','$password','$nombre','$email','$telefono','$curp','$tipo', 'Activo')";
            $insert_user = mysqli_query($link, $InsertData);
            include("../registrar/Registrar_usuario.php");
            if($tipo == "Medico")
            {
?>              <h1 style="background-color:darkgreen; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 10px 10px 10px 10px; color:white" >
<?php               print "Usuario con ID: $cedula registrado"
?>              </h1>
<?php       }
            else
            {        
?>              <h1 style="background-color:darkgreen; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 10px 10px 10px 10px; color:white" >
<?php               print "Usuario con ID: $new_id registrado"
?>              </h1>
<?php       }
        }
    }
    else{
    ?>
        <?php
        include("../registrar/Registrar_usuario.php");
        ?>
        <h1 style="background-color:darkred; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 10px 10px 10px 10px; ">
            No autorizó registrar a un usuario.
        </h1>
    <?php
    }


}else
{       
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $telefono = $_POST['telefono'];
    $curp = $_POST['curp'];

    $InsertData = "INSERT INTO `usuarios`(`ID_usuario`, `Contraseña`, `Nombre_completo_usuario`, `Correo_electronico_usuario`, `Telefono_usuario`, `Curp_usuario`, `Tipo`) VALUES ( '00000000','$password','$nombre','$email','$telefono','$curp','Admin')";
    $insert_user = mysqli_query($link, $InsertData);
    include("../registrar/Registrar_usuario.php");
    ?>
        <h1 style="background-color:darkgreen; font-family: 'Times New Roman', Times, serif; text-align:center; padding: 10px 10px 10px 10px; color:white" >
            <?php 
                print "Usuario con ID: 00000000 registrado"
            ?>
        </h1>
    <?php
}

mysqli_close($link);  
?>