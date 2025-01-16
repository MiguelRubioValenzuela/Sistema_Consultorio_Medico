<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Paciente</title>
    <!-- Archivo CSS -->
    <link rel="stylesheet" href="../CSS/Registro_pacientes.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">

<?php
        include("../php/script.php");
?>

</head>
<body>
    <header>   
        <div class="container">
            <p class="logo">Registro_Pacientes.</p>
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
            <h1>Informacion a tener en cuenta.</h1>
            <li>Registro nuevos usuarios.
                <p>El registro solo es para pacientes nuevos.</p>
            </li>
            <br>
            <li><a href="../consulta/consulta_pacientes.php"> Modificar o Visualizar registro.</a>
                <p>
                    Si quiere modificar registo dirijase a la siguiente seccion.
                </p>
            </li>
            <br>
            <li><a href="../php/Main.php">Volver a inicio.</a>
                <p>
                    Para regresar a el menu inicial puede
                    acceder a "Inicio." en la parte superior de la pantalla.
                    o acceder desde este enlace. 
                </p>
            </li>

        </div>
        <div class="formulario">
            <h1>Formulario para registro de pacientes.</h1>
            <form name="Registro_paciente" method="post" action="../conexion/conexion_pacientes.php">
                <table>
                    <tr>
                        <td id="head">
                            <h2>INTRODUZCA DATOS</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="curp" type="text" placeholder="Ingresa CURP del paciente" pattern=".{18,18}" maxlength="18" onkeyup="this.value=this.value.toUpperCase();" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="nombre" type="text" placeholder="Ingresa Nombre completo del paciente" onkeypress="return Solo_letras(event);" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="telefono" type="tel" placeholder="Ingresa telefono del paciente" onkeypress="return Solo_numeros(event)" pattern=".{10,10}" maxlength="10" title="El telfono requiere 10 digitos" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="correo" type="email" placeholder="Ingrese Correo electronico del pacientre." title="Se requiere obligatoriamente el email" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Fecha de nacimiento</label>
                            <input name="fecha" type="date" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="sexo" required>
                                <option disabled selected=""> Sexo </option>
                                <option value="X">Sin especificar</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="mover">
                    <button>
                        Registrar paciente
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>