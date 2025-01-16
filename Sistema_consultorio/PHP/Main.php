<?php
    include("LOGIN.php");
    $_SESSION['admin'] = '';
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>INICIO</title>
        <!-- Archivo CSS -->
        <link rel="stylesheet" href="../CSS/Main.css">

        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">

    </head>

    <body> 
        <header>   
            <div class="container">
                <p class="logo">Consultorio.</p>
                <nav>
                    <p class="logo2"> Consulta:</p>
                    <a href="../consulta/Consulta_cita.php">Citas.</a>
                    <a href="../consulta/Consulta_ventas.php">Ventas.</a>
                    <a href="../consulta/Consulta_abastecimiento.php">Abastecer.</a>
                    <a href="../consulta/consulta_pacientes.php">Pacientes.</a>
                    <a href="../consulta/Consulta_usuarios.php">Usuario.</a>
                </nav>
            </div>
        </header>
        <section id="hero">
            <h1 id="hero2">Ingresar citas</h1>
                <p> Aqui podrás agendar citas para clientes registrados <br>
                el medico deberá de estar disponible.
                </p>
            <form action="../consulta/Consulta_cita.php">
                <button>Agenda cita</button>
            </form>

        </section>
        <section class="contain">
            <div class="img_container"></div>
            <div class="venta">
                <h2>Vender medicamento.</h2>
                <p>
                    Esta es la seccion que nos va a permitir realizar las ventas de 
                    los medicamentos que puedan necesitar una receta o que no necesite
                    tener una para realizar la compra.
                </p>

                <div class="venta_boton">
                    <form  method="post" action="../php/vender_medicamento.php">
                        <button>Vender</button>
                    </form>
                </div>

            </div>
        </section>
        <section class="container2">
            <h2> Registros a realizar.</h2>
            <div class="cartas">
                <div class="registros">
                    <h2>Registra medicamento</h2>
                    <p>
                        Se llevara a cabo el registro de nuevos medicamentos
                        dentro del sistema. <br><br>
                        Esto para llevar un mejor control de inventario con nuevos
                        productos ingresados al consultorio.
                    </p>
                        <form method="post" action="auth.php?tipo=registro">
                            <button>Registrar</button>
                        </form>
                    
                    <!--<a class="auth" href="auth.php?tipo=registro">Registrar</a><div class="registro_boton"></div>-->
                </div>
                <div class="registros">
                    <h2>Registrar Pacientes</h3>
                    <p>
                        Se registrarán pacientes que tengan la necesidad de agendar
                        una cita medica. <br><br>
                        Tambien se agendarán a los pacientes que deseen tener un control
                        sobre las recetas que ellos tienen y/o productos comprados.
                    </p>
                    <div class="registro_boton">
                        <form action="../registrar/Registrar_paciente.php">
                            <button>Registrar</button>
                        </form>
                    </div>                    
                </div>
            </div>
        </section>
        <section id="sell">
            <div class="img_cont">
                <h2>Nuevo Abastecimiento.</h2>
                <p>
                    En esta seccion se podra realizar el abastecimiento de los medicamentos,
                    <br>
                    Cabe resaltar que unicamente el administrador o quien 
                    cuente con el la contraseña del administrador podra realizar
                    estos abastecimientos.
                </p>
                <form method="post" action="auth.php?tipo=abastecer">
                        <button>Registrar</button>
                </form>
                <!--<a class="auth" href="auth.php?tipo=abastecer">Registrar</a><div class="registro_boton"></div>-->
            </div>
        </section>
        <div class="margen">
            <p id="descrripcion">
                Este es un sistema para manejar o administrar un consultorio medico.
            </p>
            <p id="creadores">
                CopyRight: yo
            </p>
        </div>
    </body>

</html>





